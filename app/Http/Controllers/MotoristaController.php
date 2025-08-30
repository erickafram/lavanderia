<?php

namespace App\Http\Controllers;

use App\Models\Empacotamento;
use App\Models\EmpacotamentoPeca;
use App\Models\Entrega;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        
        // Buscar empacotamentos prontos para entrega com suas peças individuais (apenas sacolas prontas)
        $empacotamentosProntos = Empacotamento::with([
                'coleta.estabelecimento', 
                'pecasIndividuais' => function($query) {
                    $query->where('status_saida', 'pronto');
                },
                'pecasIndividuais.tipo', 
                'status', 
                'entrega'
            ])
            ->whereHas('coleta')
            ->where('status_id', $statusPronto?->id)
            ->whereHas('pecasIndividuais', function($query) {
                $query->where('status_saida', 'pronto');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Contar total de sacolas prontas (apenas as que estão efetivamente prontas)
        $totalSacolasProntas = $empacotamentosProntos->sum(function($emp) {
            return $emp->pecasIndividuais->where('status_saida', 'pronto')->count();
        });

        // Buscar empacotamentos que têm pelo menos uma sacola em trânsito
        $empacotamentosTransito = Empacotamento::with([
                'coleta.estabelecimento', 
                'pecasIndividuais' => function($query) {
                    $query->where('status_saida', 'em_transito');
                },
                'pecasIndividuais.tipo', 
                'status', 
                'entrega'
            ])
            ->whereHas('coleta')
            ->whereHas('pecasIndividuais', function($query) {
                $query->where('status_saida', 'em_transito');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Contar total de sacolas em trânsito (apenas as que estão efetivamente em trânsito)
        $totalSacolasTransito = $empacotamentosTransito->sum(function($emp) {
            return $emp->pecasIndividuais->where('status_saida', 'em_transito')->count();
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
        
        // Log para debug
        \Log::info("🔍 BUSCAR EMPACOTAMENTO - Código recebido: " . $codigo);
        \Log::info("🔍 Request completo: " . json_encode($request->all()));

        $empacotamento = Empacotamento::with(['coleta.estabelecimento', 'status', 'entrega'])
            ->where('codigo_qr', $codigo)
            ->first();
            
        \Log::info("🔍 Empacotamento encontrado: " . ($empacotamento ? "SIM (ID: {$empacotamento->id})" : "NÃO"));

        if (!$empacotamento) {
            \Log::warning("❌ Empacotamento não encontrado para código: " . $codigo);
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

        \Log::info("✅ Retornando empacotamento com sucesso - ID: " . $empacotamento->id);
        
        return response()->json([
            'success' => true,
            'empacotamento' => $empacotamento->load(['coleta.estabelecimento', 'status', 'entrega'])
        ]);
    }
    
    public function confirmarSaida(Request $request)
    {
        $request->validate([
            'empacotamento_id' => 'required|exists:empacotamento,id'
        ]);

        DB::beginTransaction();
        try {
            $empacotamento = Empacotamento::findOrFail($request->empacotamento_id);

            // Verificar se está disponível para entrega
            $statusPermitidos = ['Pronto para motorista', 'Em Trânsito'];
            if (!in_array($empacotamento->status->nome, $statusPermitidos)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este empacotamento não está disponível para entrega. Status atual: ' . $empacotamento->status->nome
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
            $statusTransito = Status::where('nome', 'Em trânsito')->first();
            if (!$statusTransito) {
                return response()->json([
                    'success' => false,
                    'message' => 'Status "Em trânsito" não encontrado no sistema'
                ]);
            }

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

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Saída confirmada com sucesso! Empacotamento agora está em trânsito.'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao confirmar saída: ' . $e->getMessage()
            ]);
        }
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
        
        // Log para debug
        \Log::info("🏷️ BUSCAR SACOLA - Código recebido: " . $codigo);
        \Log::info("🏷️ Request completo: " . json_encode($request->all()));

        $sacola = EmpacotamentoPeca::with(['empacotamento.coleta.estabelecimento', 'empacotamento.status', 'tipo'])
            ->where('codigo_qr', $codigo)
            ->first();
            
        \Log::info("🏷️ Sacola encontrada: " . ($sacola ? "SIM (ID: {$sacola->id})" : "NÃO"));

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

        // Verificar se a sacola individual está disponível para saída
        if ($sacola->status_saida === 'em_transito') {
            return response()->json([
                'success' => false,
                'message' => '❌ Esta sacola já está em trânsito!'
            ]);
        }

        if ($sacola->status_saida === 'entregue') {
            return response()->json([
                'success' => false,
                'message' => '❌ Esta sacola já foi entregue!'
            ]);
        }

        // Verificar se empacotamento permite saída
        $statusPermitidos = ['Pronto para motorista', 'Em Trânsito'];
        if (!in_array($sacola->empacotamento->status->nome, $statusPermitidos)) {
            return response()->json([
                'success' => false,
                'message' => '❌ Este empacotamento não está disponível para saída!\nStatus atual: ' . $sacola->empacotamento->status->nome
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
        \Log::info('🚚 CONFIRMAR SAÍDA SACOLA INICIADA', [
            'codigo_qr' => $request->codigo_qr,
            'usuario_id' => Auth::id()
        ]);

        $request->validate([
            'codigo_qr' => 'required|string'
        ]);

        $sacola = EmpacotamentoPeca::with(['empacotamento.status'])
            ->where('codigo_qr', $request->codigo_qr)
            ->first();

        if (!$sacola) {
            \Log::warning('❌ Sacola não encontrada!', ['codigo_qr' => $request->codigo_qr]);
            return response()->json([
                'success' => false,
                'message' => 'Sacola não encontrada!'
            ]);
        }

        \Log::info('📦 Sacola encontrada', [
            'sacola_id' => $sacola->id,
            'status_atual' => $sacola->status_saida,
            'empacotamento_id' => $sacola->empacotamento->id,
            'empacotamento_status' => $sacola->empacotamento->status->nome
        ]);

        // Verificar se a sacola individual pode dar saída
        if ($sacola->status_saida === 'em_transito') {
            \Log::warning('⚠️ Sacola já está em trânsito', [
                'status_sacola' => $sacola->status_saida,
                'codigo_qr' => $sacola->codigo_qr
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Esta sacola já está em trânsito!'
            ]);
        }

        if ($sacola->status_saida === 'entregue') {
            \Log::warning('⚠️ Sacola já foi entregue', [
                'status_sacola' => $sacola->status_saida,
                'codigo_qr' => $sacola->codigo_qr
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Esta sacola já foi entregue!'
            ]);
        }

        // Verificar se empacotamento permite saída (deve estar pelo menos "Pronto" ou "Em Trânsito")
        $statusPermitidos = ['Pronto para motorista', 'Em Trânsito'];
        if (!in_array($sacola->empacotamento->status->nome, $statusPermitidos)) {
            \Log::warning('⚠️ Empacotamento não permite saída', [
                'status_empacotamento' => $sacola->empacotamento->status->nome,
                'status_permitidos' => $statusPermitidos
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Este empacotamento não está disponível para saída!'
            ]);
        }

        $statusTransito = Status::where('nome', 'Em Trânsito')->first();
        
        if (!$statusTransito) {
            \Log::error('❌ Status "Em Trânsito" não encontrado!');
            return response()->json([
                'success' => false,
                'message' => 'Erro no sistema: Status não encontrado!'
            ]);
        }

        \Log::info('🔄 Atualizando status da sacola', [
            'de' => $sacola->status_saida,
            'para' => 'em_transito'
        ]);

        // Atualizar status da sacola individual
        $atualizado = $sacola->update([
            'status_saida' => 'em_transito',
            'data_saida' => now(),
            'motorista_saida_id' => Auth::id()
        ]);

        if (!$atualizado) {
            \Log::error('❌ Falha ao atualizar sacola!');
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar sacola!'
            ]);
        }

        // Recarregar sacola para verificar se foi atualizada
        $sacola->refresh();
        \Log::info('✅ Status da sacola atualizado', [
            'novo_status' => $sacola->status_saida,
            'data_saida' => $sacola->data_saida
        ]);

        // Verificar se todas as sacolas do empacotamento saíram
        $todasSacolas = $sacola->empacotamento->pecasIndividuais;
        $sacolasEmTransito = $todasSacolas->where('status_saida', 'em_transito');

        \Log::info('📊 Verificando outras sacolas', [
            'total_sacolas' => $todasSacolas->count(),
            'em_transito' => $sacolasEmTransito->count()
        ]);

        if ($todasSacolas->count() === $sacolasEmTransito->count()) {
            \Log::info('🎉 Todas as sacolas em trânsito! Atualizando empacotamento...');
            
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

        \Log::info('✅ CONFIRMAÇÃO CONCLUÍDA', [
            'mensagem' => $mensagem,
            'todas_em_transito' => $todasSacolas->count() === $sacolasEmTransito->count()
        ]);

        return response()->json([
            'success' => true,
            'message' => $mensagem,
            'todas_sacolasem_transito' => $todasSacolas->count() === $sacolasEmTransito->count()
        ]);
    }
}
