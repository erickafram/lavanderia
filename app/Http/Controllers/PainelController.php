<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coleta;
use App\Models\Empacotamento;
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
        $coletasAcompanhamento = Coleta::with(['estabelecimento', 'status', 'pesagens', 'empacotamento.status'])
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
     * Calcular progresso de uma coleta
     */
    private function calcularProgressoColeta($coleta)
    {
        $progresso = [
            'coleta' => [
                'concluida' => true,
                'data' => $coleta->created_at,
                'status' => $coleta->status->nome
            ],
            'pesagem' => [
                'concluida' => $coleta->pesagens->count() > 0,
                'data' => $coleta->pesagens->first()?->created_at,
                'quantidade' => $coleta->pesagens->count()
            ],
            'empacotamento' => [
                'concluida' => $coleta->empacotamento !== null,
                'data' => $coleta->empacotamento?->created_at,
                'status' => $coleta->empacotamento?->status->nome,
                'codigo_qr' => $coleta->empacotamento?->codigo_qr
            ],
            'entrega' => [
                'concluida' => $coleta->empacotamento && $coleta->empacotamento->status->nome === 'Entregue',
                'data' => $coleta->empacotamento?->data_entrega,
                'motorista' => $coleta->empacotamento?->motorista?->nome
            ]
        ];

        // Calcular percentual
        $etapasConcluidas = 0;
        if ($progresso['coleta']['concluida']) $etapasConcluidas++;
        if ($progresso['pesagem']['concluida']) $etapasConcluidas++;
        if ($progresso['empacotamento']['concluida']) $etapasConcluidas++;
        if ($progresso['entrega']['concluida']) $etapasConcluidas++;

        $progresso['percentual'] = round(($etapasConcluidas / 4) * 100);

        return $progresso;
    }

    /**
     * Acompanhamento de coleta
     */
    public function acompanharColeta(Request $request)
    {
        $request->validate([
            'numero_coleta' => 'required|string'
        ]);

        $coleta = Coleta::with(['estabelecimento', 'status', 'pesagens', 'empacotamento.status'])
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
