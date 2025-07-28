<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empacotamento;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MotoristaController extends Controller
{
    /**
     * Dashboard do motorista
     */
    public function dashboard()
    {
        $motorista = Auth::user();

        // Empacotamentos prontos para entrega (sem motorista)
        $empacotamentosProntos = Empacotamento::with(['coleta.estabelecimento', 'status'])
            ->whereHas('status', function($query) {
                $query->where('nome', 'Pronto para entrega');
            })
            ->whereNull('motorista_id')
            ->orderBy('data_empacotamento', 'desc')
            ->get();

        // Empacotamentos em trânsito (com este motorista)
        $empacotamentosEmTransito = Empacotamento::with(['coleta.estabelecimento', 'status'])
            ->where('motorista_id', $motorista->id)
            ->whereHas('status', function($query) {
                $query->where('nome', 'Em trânsito');
            })
            ->orderBy('data_saida', 'desc')
            ->get();

        // Empacotamentos entregues hoje (com este motorista)
        $empacotamentosEntregues = Empacotamento::with(['coleta.estabelecimento', 'status'])
            ->where('motorista_id', $motorista->id)
            ->whereHas('status', function($query) {
                $query->where('nome', 'Entregue');
            })
            ->whereDate('data_entrega', today())
            ->orderBy('data_entrega', 'desc')
            ->get();

        // Estatísticas
        $totalProntos = $empacotamentosProntos->count();
        $totalEmTransito = $empacotamentosEmTransito->count();
        $totalEntreguesHoje = $empacotamentosEntregues->count();
        $totalEntreguesMotorista = Empacotamento::where('motorista_id', $motorista->id)
            ->whereHas('status', function($query) {
                $query->where('nome', 'Entregue');
            })->count();

        return view('motorista.dashboard', compact(
            'empacotamentosProntos',
            'empacotamentosEmTransito',
            'empacotamentosEntregues',
            'totalProntos',
            'totalEmTransito',
            'totalEntreguesHoje',
            'totalEntreguesMotorista'
        ));
    }

    /**
     * Buscar empacotamento por QR Code ou código
     */
    public function buscarEmpacotamento(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string'
        ]);

        $empacotamento = Empacotamento::with(['coleta.estabelecimento', 'coleta.pecas.tipo', 'status'])
            ->where('codigo_qr', $request->codigo)
            ->first();

        if (!$empacotamento) {
            return response()->json([
                'success' => false,
                'message' => 'Empacotamento não encontrado'
            ]);
        }

        return response()->json([
            'success' => true,
            'empacotamento' => $empacotamento
        ]);
    }

    /**
     * Confirmar saída para entrega
     */
    public function confirmarSaida(Request $request)
    {
        $request->validate([
            'empacotamento_id' => 'required|exists:empacotamento,id'
        ]);

        DB::beginTransaction();
        try {
            $empacotamento = Empacotamento::findOrFail($request->empacotamento_id);

            // Verificar se está pronto para entrega
            if ($empacotamento->status->nome !== 'Pronto para entrega') {
                return response()->json([
                    'success' => false,
                    'message' => 'Este empacotamento não está pronto para entrega'
                ]);
            }

            // Verificar se já tem motorista
            if ($empacotamento->motorista_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este empacotamento já foi assumido por outro motorista'
                ]);
            }

            // Buscar status "Em trânsito"
            $statusEmTransito = Status::where('nome', 'Em trânsito')->first();
            if (!$statusEmTransito) {
                return response()->json([
                    'success' => false,
                    'message' => 'Status "Em trânsito" não encontrado'
                ]);
            }

            // Atualizar empacotamento
            $empacotamento->update([
                'motorista_id' => Auth::id(),
                'status_id' => $statusEmTransito->id,
                'data_saida' => now()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Saída confirmada com sucesso!'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao confirmar saída: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Confirmar entrega
     */
    public function confirmarEntrega(Request $request)
    {
        $request->validate([
            'empacotamento_id' => 'required|exists:empacotamento,id',
            'nome_recebedor' => 'required|string|max:255',
            'assinatura' => 'nullable|string', // Base64 da assinatura
            'observacoes' => 'nullable|string|max:1000'
        ]);

        DB::beginTransaction();
        try {
            $empacotamento = Empacotamento::findOrFail($request->empacotamento_id);

            // Verificar se está em trânsito com este motorista
            if ($empacotamento->status->nome !== 'Em trânsito' || $empacotamento->motorista_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Você não pode entregar este empacotamento'
                ]);
            }

            // Buscar status "Entregue"
            $statusEntregue = Status::where('nome', 'Entregue')->first();
            if (!$statusEntregue) {
                return response()->json([
                    'success' => false,
                    'message' => 'Status "Entregue" não encontrado'
                ]);
            }

            // Salvar assinatura se fornecida
            $caminhoAssinatura = null;
            if ($request->assinatura) {
                $assinaturaData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->assinatura));
                $nomeArquivo = 'assinatura_' . $empacotamento->id . '_' . time() . '.png';
                $caminhoAssinatura = 'assinaturas/' . $nomeArquivo;

                \Storage::disk('public')->put($caminhoAssinatura, $assinaturaData);
            }

            // Atualizar empacotamento
            $empacotamento->update([
                'status_id' => $statusEntregue->id,
                'data_entrega' => now(),
                'nome_recebedor' => $request->nome_recebedor,
                'assinatura_recebimento' => $caminhoAssinatura,
                'observacoes_entrega' => $request->observacoes
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Entrega confirmada com sucesso!'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao confirmar entrega: ' . $e->getMessage()
            ]);
        }
    }
}
