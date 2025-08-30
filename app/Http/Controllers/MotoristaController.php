<?php

namespace App\Http\Controllers;

use App\Models\Empacotamento;
use App\Models\EmpacotamentoPeca;
use App\Models\Entrega;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MotoristaController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Buscar status
        $statusPronto = Status::where('nome', 'Pronto para motorista')->first();
        $statusTransito = Status::where('nome', 'Em Trânsito')->first();
        $statusEntregue = Status::where('nome', 'Entregue')->first();
        $statusConfirmado = Status::where('nome', 'Confirmado pelo Cliente')->first();
        
        // Contar empacotamentos
        $prontos = Empacotamento::where('status_id', $statusPronto?->id)->count();
        $emTransito = Empacotamento::where('status_id', $statusTransito?->id)->count();
        $entreguesHoje = Empacotamento::where('status_id', $statusEntregue?->id)
            ->whereDate('data_entrega', Carbon::today())
            ->count();
        $total = Empacotamento::count();
        
        // Buscar empacotamentos prontos para entrega com suas peças individuais
        $empacotamentosProntos = Empacotamento::with([
                'coleta.estabelecimento', 
                'pecasIndividuais.tipo', 
                'status', 
                'entrega'
            ])
            ->whereHas('coleta')
            ->where('status_id', $statusPronto?->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Contar total de sacolas prontas
        $totalSacolasProntas = $empacotamentosProntos->sum(function($emp) {
            return $emp->pecasIndividuais->count();
        });

        // Buscar empacotamentos em trânsito com suas peças individuais
        $empacotamentosTransito = Empacotamento::with([
                'coleta.estabelecimento', 
                'pecasIndividuais.tipo', 
                'status', 
                'entrega'
            ])
            ->whereHas('coleta')
            ->where(function($query) use ($statusTransito) {
                // Empacotamento com status "Em Trânsito"
                $query->where('status_id', $statusTransito?->id)
                      // OU tem entrega com status "Em Trânsito"
                      ->orWhereHas('entrega', function($subQuery) use ($statusTransito) {
                          $subQuery->where('status_id', $statusTransito?->id);
                      });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Contar total de sacolas em trânsito
        $totalSacolasTransito = $empacotamentosTransito->sum(function($emp) {
            return $emp->pecasIndividuais->count();
        });
            
        // Buscar entregas realizadas hoje
        $empacotamentosEntregues = Empacotamento::with(['coleta.estabelecimento', 'status', 'entrega.motoristaEntrega'])
            ->whereHas('coleta')
            ->whereHas('entrega', function($query) use ($statusEntregue, $statusConfirmado) {
                $query->whereIn('status_id', [$statusEntregue?->id, $statusConfirmado?->id])
                      ->whereDate('data_entrega', Carbon::today());
            })
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('motorista.dashboard', compact(
            'prontos', 'emTransito', 'entreguesHoje', 'total',
            'empacotamentosProntos', 'empacotamentosTransito', 'empacotamentosEntregues',
            'totalSacolasProntas', 'totalSacolasTransito'
        ));
    }
    
    public function buscarEmpacotamento(Request $request)
    {
        $codigo = $request->input('codigo');

        $empacotamento = Empacotamento::with(['coleta.estabelecimento', 'status', 'entrega'])
            ->where('codigo_qr', $codigo)
            ->first();

        if (!$empacotamento) {
            return response()->json([
                'success' => false,
                'message' => '❌ Empacotamento não encontrado!\nVerifique se o QR Code está correto.'
            ]);
        }

        // Verificar se o empacotamento está ativo
        if (!$empacotamento->coleta) {
            return response()->json([
                'success' => false,
                'message' => '❌ Empacotamento sem coleta associada!'
            ]);
        }

        return response()->json([
            'success' => true,
            'empacotamento' => $empacotamento->load(['coleta.estabelecimento', 'status', 'entrega'])
        ]);
    }
    
    public function confirmarSaida(Request $request)
    {
        $empacotamento = Empacotamento::findOrFail($request->empacotamento_id);

        $statusTransito = Status::where('nome', 'Em Trânsito')->first();

        // Atualizar status do empacotamento
        $empacotamento->update(['status_id' => $statusTransito->id]);

        // Criar ou atualizar entrega
        Entrega::updateOrCreate(
            ['empacotamento_id' => $empacotamento->id],
            [
                'status_id' => $statusTransito->id,
                'data_saida' => now(),
                'motorista_saida_id' => Auth::id()
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Saída confirmada com sucesso!'
        ]);
    }
    
    public function confirmarEntrega(Request $request)
    {
        $request->validate([
            'empacotamento_id' => 'required|exists:empacotamento,id',
            'nome_recebedor' => 'required|string|max:255',
            'assinatura_recebedor' => 'required|string'
        ]);

        $empacotamento = Empacotamento::findOrFail($request->empacotamento_id);

        $statusEntregue = Status::where('nome', 'Entregue')->first();

        // Atualizar status do empacotamento
        $empacotamento->update(['status_id' => $statusEntregue->id]);

        // Criar ou atualizar entrega
        Entrega::updateOrCreate(
            ['empacotamento_id' => $empacotamento->id],
            [
                'status_id' => $statusEntregue->id,
                'data_entrega' => now(),
                'motorista_entrega_id' => Auth::id(),
                'nome_recebedor' => $request->nome_recebedor,
                'assinatura_recebedor' => $request->assinatura_recebedor
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Entrega confirmada! Aguardando confirmação do cliente.'
        ]);
    }

    public function confirmarRecebimento(Request $request)
    {
        $request->validate([
            'codigo_qr' => 'required|string',
            'assinatura_cliente' => 'required|string'
        ]);

        $empacotamento = Empacotamento::where('codigo_qr', $request->codigo_qr)->first();

        if (!$empacotamento) {
            return response()->json([
                'success' => false,
                'message' => 'Código QR não encontrado!'
            ]);
        }

        if ($empacotamento->status->nome !== 'Entregue') {
            return response()->json([
                'success' => false,
                'message' => 'Este empacotamento ainda não foi entregue!'
            ]);
        }

        $statusConfirmado = Status::where('nome', 'Confirmado pelo Cliente')->first();

        // Atualizar status do empacotamento
        $empacotamento->update(['status_id' => $statusConfirmado->id]);

        // Atualizar entrega
        $entrega = Entrega::where('empacotamento_id', $empacotamento->id)->first();
        if ($entrega) {
            $entrega->update([
                'status_id' => $statusConfirmado->id,
                'data_confirmacao_recebimento' => now(),
                'assinatura_cliente' => $request->assinatura_cliente
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Recebimento confirmado com sucesso!'
        ]);
    }

    /**
     * Buscar sacola individual por QR code
     */
    public function buscarSacola(Request $request)
    {
        $codigo = $request->input('codigo');

        $sacola = EmpacotamentoPeca::with(['empacotamento.coleta.estabelecimento', 'empacotamento.status', 'tipo'])
            ->where('codigo_qr', $codigo)
            ->first();

        if (!$sacola) {
            return response()->json([
                'success' => false,
                'message' => '❌ Sacola não encontrada!\nVerifique se o QR Code está correto.'
            ]);
        }

        // Verificar se a sacola pertence a um empacotamento válido
        if (!$sacola->empacotamento || !$sacola->empacotamento->coleta) {
            return response()->json([
                'success' => false,
                'message' => '❌ Sacola sem empacotamento válido!'
            ]);
        }

        // Verificar se está pronta para saída
        if ($sacola->empacotamento->status->nome !== 'Pronto para motorista') {
            return response()->json([
                'success' => false,
                'message' => '❌ Esta sacola ainda não está pronta para saída!\nStatus atual: ' . $sacola->empacotamento->status->nome
            ]);
        }

        return response()->json([
            'success' => true,
            'sacola' => $sacola->load(['empacotamento.coleta.estabelecimento', 'empacotamento.status', 'tipo'])
        ]);
    }

    /**
     * Confirmar saída de sacola individual
     */
    public function confirmarSaidaSacola(Request $request)
    {
        $request->validate([
            'codigo_qr' => 'required|string'
        ]);

        $sacola = EmpacotamentoPeca::with(['empacotamento'])
            ->where('codigo_qr', $request->codigo_qr)
            ->first();

        if (!$sacola) {
            return response()->json([
                'success' => false,
                'message' => 'Sacola não encontrada!'
            ]);
        }

        // Verificar se pode dar saída
        if ($sacola->empacotamento->status->nome !== 'Pronto para motorista') {
            return response()->json([
                'success' => false,
                'message' => 'Esta sacola não está pronta para saída!'
            ]);
        }

        $statusTransito = Status::where('nome', 'Em Trânsito')->first();

        // Atualizar status da sacola individual
        $sacola->update([
            'status_saida' => 'em_transito',
            'data_saida' => now(),
            'motorista_saida_id' => Auth::id()
        ]);

        // Verificar se todas as sacolas do empacotamento saíram
        $todasSacolas = $sacola->empacotamento->pecasIndividuais;
        $sacolasEmTransito = $todasSacolas->where('status_saida', 'em_transito');

        if ($todasSacolas->count() === $sacolasEmTransito->count()) {
            // Todas as sacolas saíram, atualizar status do empacotamento
            $sacola->empacotamento->update(['status_id' => $statusTransito->id]);

            // Criar ou atualizar entrega
            Entrega::updateOrCreate(
                ['empacotamento_id' => $sacola->empacotamento->id],
                [
                    'status_id' => $statusTransito->id,
                    'data_saida' => now(),
                    'motorista_saida_id' => Auth::id()
                ]
            );

            $mensagem = 'Sacola confirmada! 🎉 TODAS as sacolas do empacotamento estão agora em trânsito.';
        } else {
            $restantes = $todasSacolas->count() - $sacolasEmTransito->count();
            $mensagem = "Sacola confirmada! ✅ Ainda restam {$restantes} sacola(s) para saída.";
        }

        return response()->json([
            'success' => true,
            'message' => $mensagem,
            'todas_sacolasem_transito' => $todasSacolas->count() === $sacolasEmTransito->count()
        ]);
    }
}
