<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coleta;
use App\Models\Empacotamento;
use App\Models\Entrega;
use App\Models\Estabelecimento;
use App\Models\Usuario;
use Carbon\Carbon;

class PainelController extends Controller
{
    /**
     * Exibe o dashboard principal
     */
    public function index()
    {
        $hoje = Carbon::today();
        $mesAtual = Carbon::now()->startOfMonth();
        
        // Estatísticas do dia
        $coletasHoje = Coleta::whereDate('created_at', $hoje)->count();
        $empacotamentosHoje = Empacotamento::whereDate('created_at', $hoje)->count();
        $pesoTotalHoje = Coleta::whereDate('created_at', $hoje)->sum('peso_total');
        $pesagensHoje = \App\Models\Pesagem::whereDate('created_at', $hoje)->count();

        // Estatísticas do mês
        $coletasMes = Coleta::where('created_at', '>=', $mesAtual)->count();
        $empacotamentosMes = Empacotamento::where('created_at', '>=', $mesAtual)->count();
        $pesoTotalMes = Coleta::where('created_at', '>=', $mesAtual)->sum('peso_total');
        $pesagensMes = \App\Models\Pesagem::where('created_at', '>=', $mesAtual)->count();
        
        // Coletas recentes
        $coletasRecentes = Coleta::with(['estabelecimento', 'status'])
                                ->orderBy('created_at', 'desc')
                                ->limit(5)
                                ->get();

        // Coletas para acompanhamento (últimas 20)
        $coletasAcompanhamento = Coleta::with(['estabelecimento', 'status', 'pesagens', 'empacotamento.status', 'empacotamento.entrega.status'])
                                      ->orderBy('created_at', 'desc')
                                      ->limit(20)
                                      ->get();
        
        // Empacotamentos pendentes
        $empacotamentosPendentes = Empacotamento::with(['coleta.estabelecimento', 'status'])
                                               ->whereHas('status', function($query) {
                                                   $query->whereIn('nome', ['Aguardando empacotamento', 'Em empacotamento', 'Pronto para entrega']);
                                               })
                                               ->orderBy('created_at', 'asc')
                                               ->limit(5)
                                               ->get();
        
        // Estatísticas gerais
        $totalEstabelecimentos = Estabelecimento::where('ativo', true)->count();
        $totalUsuarios = Usuario::where('ativo', true)->count();
        
        return view('painel.index', compact(
            'coletasHoje',
            'empacotamentosHoje',
            'pesoTotalHoje',
            'pesagensHoje',
            'coletasMes',
            'empacotamentosMes',
            'pesoTotalMes',
            'pesagensMes',
            'coletasRecentes',
            'empacotamentosPendentes',
            'coletasAcompanhamento',
            'totalEstabelecimentos',
            'totalUsuarios'
        ));
    }

    /**
     * Calcular progresso de uma coleta com tempos entre etapas
     */
    private function calcularProgressoColeta($coleta)
    {
        // Datas das etapas
        $dataColeta = $coleta->created_at;
        $dataPesagem = $coleta->pesagens->first()?->created_at;
        $dataEmpacotamento = $coleta->empacotamento?->data_empacotamento;
        $entrega = $coleta->empacotamento?->entrega;
        $dataEntrega = $entrega?->data_entrega;

        $progresso = [
            'coleta' => [
                'concluida' => true,
                'data' => $dataColeta,
                'status' => $coleta->status->nome,
                'tempo_desde_inicio' => '0h 0m'
            ],
            'pesagem' => [
                'concluida' => $coleta->pesagens->count() > 0,
                'data' => $dataPesagem,
                'quantidade' => $coleta->pesagens->count(),
                'tempo_desde_coleta' => $dataPesagem ? $this->calcularTempoEntre($dataColeta, $dataPesagem) : null,
                'tempo_desde_inicio' => $dataPesagem ? $this->calcularTempoEntre($dataColeta, $dataPesagem) : null
            ],
            'empacotamento' => [
                'concluida' => $coleta->empacotamento !== null,
                'data' => $dataEmpacotamento,
                'status' => $coleta->empacotamento?->status->nome,
                'codigo_qr' => $coleta->empacotamento?->codigo_qr,
                'tempo_desde_pesagem' => $dataEmpacotamento && $dataPesagem ? $this->calcularTempoEntre($dataPesagem, $dataEmpacotamento) : null,
                'tempo_desde_inicio' => $dataEmpacotamento ? $this->calcularTempoEntre($dataColeta, $dataEmpacotamento) : null
            ],
            'entrega' => [
                'concluida' => $entrega && in_array($entrega->status->nome, ['Em trânsito', 'Entregue', 'Confirmado pelo Cliente']),
                'data' => $entrega?->data_saida,
                'motorista' => $entrega?->motoristaSaida?->nome,
                'tempo_desde_empacotamento' => $entrega && $entrega->data_saida && $dataEmpacotamento ? $this->calcularTempoEntre($dataEmpacotamento, $entrega->data_saida) : null,
                'tempo_desde_inicio' => $entrega && $entrega->data_saida ? $this->calcularTempoEntre($dataColeta, $entrega->data_saida) : null
            ],
            'confirmacao_cliente' => [
                'concluida' => $entrega && in_array($entrega->status->nome, ['Entregue', 'Confirmado pelo Cliente']),
                'data' => $dataEntrega,
                'nome_recebedor' => $entrega?->nome_recebedor,
                'assinatura' => $entrega?->assinatura_recebedor,
                'tempo_desde_entrega' => $dataEntrega && $entrega && $entrega->data_saida ?
                    $this->calcularTempoEntre($entrega->data_saida, $dataEntrega) : null,
                'tempo_desde_inicio' => $dataEntrega ?
                    $this->calcularTempoEntre($dataColeta, $dataEntrega) : null
            ]
        ];

        // Calcular percentual (5 etapas agora)
        $etapasConcluidas = 0;
        if ($progresso['coleta']['concluida']) $etapasConcluidas++;
        if ($progresso['pesagem']['concluida']) $etapasConcluidas++;
        if ($progresso['empacotamento']['concluida']) $etapasConcluidas++;
        if ($progresso['entrega']['concluida']) $etapasConcluidas++;
        if ($progresso['confirmacao_cliente']['concluida']) $etapasConcluidas++;

        $progresso['percentual'] = round(($etapasConcluidas / 5) * 100);

        // Tempo total do processo (se confirmado pelo cliente)
        if ($progresso['confirmacao_cliente']['concluida']) {
            $progresso['tempo_total'] = $this->calcularTempoEntre($dataColeta, $entrega->data_confirmacao_recebimento);
        } elseif ($progresso['entrega']['concluida']) {
            $progresso['tempo_total'] = $this->calcularTempoEntre($dataColeta, $dataEntrega);
        } else {
            // Tempo até agora
            $progresso['tempo_total'] = $this->calcularTempoEntre($dataColeta, Carbon::now());
        }

        return $progresso;
    }

    /**
     * Calcular tempo entre duas datas
     */
    private function calcularTempoEntre($dataInicio, $dataFim)
    {
        if (!$dataInicio || !$dataFim) {
            return null;
        }

        $inicio = Carbon::parse($dataInicio);
        $fim = Carbon::parse($dataFim);

        $diffInMinutes = $inicio->diffInMinutes($fim);

        if ($diffInMinutes < 60) {
            return $diffInMinutes . 'm';
        } elseif ($diffInMinutes < 1440) { // menos de 24 horas
            $horas = floor($diffInMinutes / 60);
            $minutos = $diffInMinutes % 60;
            return $horas . 'h ' . $minutos . 'm';
        } else { // mais de 24 horas
            $dias = floor($diffInMinutes / 1440);
            $horasRestantes = floor(($diffInMinutes % 1440) / 60);
            return $dias . 'd ' . $horasRestantes . 'h';
        }
    }

    /**
     * Acompanhamento de coleta
     */
    public function acompanharColeta(Request $request)
    {
        $request->validate([
            'numero_coleta' => 'required|string'
        ]);

        $coleta = Coleta::with(['estabelecimento', 'status', 'pesagens', 'empacotamento.status', 'empacotamento.entrega.status'])
            ->where('numero_coleta', $request->numero_coleta)
            ->first();

        if (!$coleta) {
            return response()->json([
                'success' => false,
                'message' => 'Coleta não encontrada'
            ]);
        }

        // Calcular progresso da coleta
        $progresso = $this->calcularProgressoColeta($coleta);

        return response()->json([
            'success' => true,
            'coleta' => $coleta,
            'progresso' => $progresso
        ]);
    }
}
