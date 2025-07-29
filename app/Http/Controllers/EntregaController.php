<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empacotamento;
use App\Models\Entrega;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EntregaController extends Controller
{
    /**
     * Dashboard do motorista
     */
    public function dashboard()
    {
        $motorista = Auth::user();

        // Empacotamentos prontos para entrega
        $empacotamentosProntos = Empacotamento::with(['coleta.estabelecimento', 'status', 'entrega'])
            ->whereHas('status', function($query) {
                $query->where('nome', 'Pronto para entrega');
            })
            ->orderBy('data_empacotamento', 'desc')
            ->get();

        // Empacotamentos em trânsito (com este motorista)
        $empacotamentosEmTransito = Empacotamento::with(['coleta.estabelecimento', 'status', 'entrega'])
            ->whereHas('entrega', function($query) use ($motorista) {
                $query->where('motorista_saida_id', $motorista->id)
                      ->whereHas('status', function($subQuery) {
                          $subQuery->where('nome', 'Em trânsito');
                      });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Empacotamentos entregues hoje (com este motorista)
        $empacotamentosEntregues = Empacotamento::with(['coleta.estabelecimento', 'status', 'entrega'])
            ->whereHas('entrega', function($query) use ($motorista) {
                $query->where('motorista_entrega_id', $motorista->id)
                      ->whereHas('status', function($subQuery) {
                          $subQuery->whereIn('nome', ['Entregue', 'Confirmado pelo Cliente']);
                      })
                      ->whereDate('data_entrega', today());
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Estatísticas
        $totalProntos = $empacotamentosProntos->count();
        $totalEmTransito = $empacotamentosEmTransito->count();
        $totalEntreguesHoje = $empacotamentosEntregues->count();
        $totalEntreguesMotorista = Entrega::where('motorista_entrega_id', $motorista->id)
            ->whereHas('status', function($query) {
                $query->whereIn('nome', ['Entregue', 'Confirmado pelo Cliente']);
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

        $empacotamento = Empacotamento::with(['coleta.estabelecimento', 'coleta.pecas.tipo', 'status', 'entrega'])
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

            // Verificar se já tem entrega em andamento
            $entregaExistente = $empacotamento->entrega;
            if ($entregaExistente && $entregaExistente->motorista_saida_id) {
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
            $empacotamento->update(['status_id' => $statusEmTransito->id]);

            // Criar ou atualizar entrega
            Entrega::updateOrCreate(
                ['empacotamento_id' => $empacotamento->id],
                [
                    'status_id' => $statusEmTransito->id,
                    'data_saida' => now(),
                    'motorista_saida_id' => Auth::id()
                ]
            );

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
            $entrega = $empacotamento->entrega;
            if (!$entrega || $entrega->status->nome !== 'Em trânsito' || $entrega->motorista_saida_id !== Auth::id()) {
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
            $empacotamento->update(['status_id' => $statusEntregue->id]);

            // Atualizar entrega
            $entrega->update([
                'status_id' => $statusEntregue->id,
                'data_entrega' => now(),
                'motorista_entrega_id' => Auth::id(),
                'nome_recebedor' => $request->nome_recebedor,
                'assinatura_recebedor' => $caminhoAssinatura,
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
