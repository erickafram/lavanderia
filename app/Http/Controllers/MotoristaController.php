<?php

namespace App\Http\Controllers;

use App\Models\Empacotamento;
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
        $statusPronto = Status::where('nome', 'Pronto para Entrega')->first();
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
        
        // Buscar empacotamentos prontos para entrega
        $empacotamentosProntos = Empacotamento::with(['coleta.estabelecimento', 'status', 'entrega'])
            ->whereHas('coleta')
            ->where('status_id', $statusPronto?->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Buscar empacotamentos em trânsito
        $empacotamentosTransito = Empacotamento::with(['coleta.estabelecimento', 'status', 'entrega'])
            ->whereHas('coleta')
            ->whereHas('entrega', function($query) use ($statusTransito) {
                $query->where('status_id', $statusTransito?->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Buscar entregas realizadas hoje
        $empacotamentosEntregues = Empacotamento::with(['coleta.estabelecimento', 'status', 'entrega'])
            ->whereHas('coleta')
            ->whereHas('entrega', function($query) use ($statusEntregue, $statusConfirmado) {
                $query->whereIn('status_id', [$statusEntregue?->id, $statusConfirmado?->id])
                      ->whereDate('data_entrega', Carbon::today());
            })
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('motorista.dashboard', compact(
            'prontos', 'emTransito', 'entreguesHoje', 'total',
            'empacotamentosProntos', 'empacotamentosTransito', 'empacotamentosEntregues'
        ));
    }
    
    public function buscarEmpacotamento(Request $request)
    {
        $codigo = $request->input('codigo');
        
        $empacotamento = Empacotamento::with(['coleta.estabelecimento', 'status'])
            ->where('codigo_qr', $codigo)
            ->first();
            
        if (!$empacotamento) {
            return response()->json([
                'success' => false,
                'message' => 'Empacotamento não encontrado!'
            ]);
        }
        
        return response()->json([
            'success' => true,
            'empacotamento' => $empacotamento
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
}
