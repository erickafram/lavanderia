<?php

namespace App\Http\Controllers;

use App\Models\Empacotamento;
use App\Models\EmpacotamentoPeca;
use App\Models\Coleta;
use App\Models\ColetaPeca;
use App\Models\Usuario;
use App\Models\Status;
use App\Models\Tipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EmpacotamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Empacotamento::with([
                                  'coleta.estabelecimento', 
                                  'coleta.pecas', 
                                  'pecasIndividuais',
                                  'usuarioEmpacotamento', 
                                  'motorista', 
                                  'status'
                              ])
                              ->whereHas('coleta'); // Apenas empacotamentos com coleta válida

        // Filtros
        if ($request->filled('status_id')) {
            $query->where('status_id', $request->status_id);
        }

        if ($request->filled('motorista_id')) {
            $query->where('motorista_id', $request->motorista_id);
        }

        if ($request->filled('data_inicio')) {
            $query->whereDate('data_empacotamento', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->whereDate('data_empacotamento', '<=', $request->data_fim);
        }

        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function($q) use ($busca) {
                $q->where('codigo_qr', 'like', "%{$busca}%")
                  ->orWhereHas('coleta', function($subQ) use ($busca) {
                      $subQ->where('numero_coleta', 'like', "%{$busca}%")
                           ->orWhereHas('estabelecimento', function($estQ) use ($busca) {
                               $estQ->where('razao_social', 'like', "%{$busca}%");
                           });
                  });
            });
        }

        $empacotamentos = $query->orderBy('created_at', 'desc')->paginate(15);

        // Dados para filtros
        $status = Status::whereIn('nome', [
            'Aguardando empacotamento',
            'Em empacotamento', 
            'Pronto para entrega',
            'Em trânsito',
            'Entregue'
        ])->get();

        $motoristas = Usuario::where('ativo', true)
                            ->orderBy('nome')
                            ->get();

        return view('empacotamento.index', compact('empacotamentos', 'status', 'motoristas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $coletaId = $request->get('coleta_id');
        $coleta = null;

        if ($coletaId) {
            $coleta = Coleta::with(['estabelecimento', 'pecas.tipo'])->findOrFail($coletaId);
        }

        // Buscar coletas que podem ser empacotadas (concluídas e não empacotadas)
        $coletas = Coleta::with(['estabelecimento', 'pecas.tipo'])
                        ->whereHas('status', function($q) {
                            $q->where('nome', 'Concluída');
                        })
                        ->whereDoesntHave('empacotamento')
                        ->orderBy('numero_coleta', 'desc')
                        ->get();

        $tipos = Tipo::ativos()->orderBy('nome')->get();

        return view('empacotamento.create', compact('coletas', 'coleta', 'tipos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'coleta_id' => 'required|exists:coletas,id',
            'data_empacotamento' => 'required|date',
            'observacoes_empacotamento' => 'nullable|string|max:1000'
        ]);

        DB::beginTransaction();
        try {
            // Verificar se a coleta já foi empacotada
            $coletaJaEmpacotada = Empacotamento::where('coleta_id', $request->coleta_id)->exists();
            if ($coletaJaEmpacotada) {
                return back()->withErrors(['coleta_id' => 'Esta coleta já foi empacotada.']);
            }

            // Buscar status "Pronto para motorista"
            $statusProntoEntrega = Status::where('nome', 'Pronto para motorista')->first();
            if (!$statusProntoEntrega) {
                return back()->withErrors(['status' => 'Status "Pronto para motorista" não encontrado.']);
            }

            // Criar empacotamento
            $empacotamento = Empacotamento::create([
                'coleta_id' => $request->coleta_id,
                'usuario_empacotamento_id' => Auth::id(),
                'motorista_id' => null, // Motorista será definido na saída
                'status_id' => $statusProntoEntrega->id,
                'data_empacotamento' => $request->data_empacotamento,
                'observacoes_empacotamento' => $request->observacoes_empacotamento
            ]);

            // Processar peças do empacotamento
            if ($request->has('pecas') || $request->has('pecas_extras') || $request->has('pecas_duplicadas')) {
                // Empacotamento com dados de peças (vindo do formulário)
                $this->processarPecasEmpacotamento($request, $empacotamento);
            } else {
                // Empacotamento inicial - criar peças baseadas na coleta
                $this->criarPecasIniciaisEmpacotamento($empacotamento);
            }

            // Atualizar status da coleta para "Empacotada"
            $statusEmpacotada = Status::where('nome', 'Empacotada')->first();
            if ($statusEmpacotada) {
                $empacotamento->coleta->update(['status_id' => $statusEmpacotada->id]);
            }

            DB::commit();

            // Se foi criação inicial (sem dados de peças), redirecionar para edição
            if (!$request->has('pecas') && !$request->has('pecas_extras') && !$request->has('pecas_duplicadas')) {
                return redirect()->route('empacotamento.edit', $empacotamento->id)
                               ->with('success', 'Empacotamento criado! Agora você pode ajustar as quantidades e dividir as peças conforme necessário.');
            }

            return redirect()->route('empacotamento.show', $empacotamento->id)
                           ->with('success', 'Empacotamento criado com sucesso!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Erro ao criar empacotamento: ' . $e->getMessage()]);
        }
    }

    /**
     * Processar peças do empacotamento
     */
    private function processarPecasEmpacotamento(Request $request, Empacotamento $empacotamento)
    {
        $coleta = $empacotamento->coleta;

        // Verificar se há peças existentes para conferência (coleta por quantidade)
        if ($request->has('pecas')) {
            foreach ($request->pecas as $pecaId => $dadosEmpacotamento) {
                $coletaPeca = $coleta->pecas->find($pecaId);
                if ($coletaPeca) {
                    // Atualizar quantidade empacotada na peça da coleta
                    $coletaPeca->update([
                        'quantidade_empacotada' => $dadosEmpacotamento['quantidade_empacotada'] ?? 0,
                        'peso_empacotado' => $dadosEmpacotamento['peso_empacotado'] ?? 0,
                    ]);

                    // Criar peça individual do empacotamento com QR code
                    if (($dadosEmpacotamento['quantidade_empacotada'] ?? 0) > 0) {
                        EmpacotamentoPeca::create([
                            'empacotamento_id' => $empacotamento->id,
                            'tipo_id' => $coletaPeca->tipo_id,
                            'quantidade' => $dadosEmpacotamento['quantidade_empacotada'],
                            'peso' => $dadosEmpacotamento['peso_empacotado'] ?? 0,
                            'observacoes' => "Peça empacotada - Qtd. original: {$coletaPeca->quantidade}"
                        ]);
                    }
                }
            }
        }

        // Processar peças duplicadas (conferência de quantidade)
        if ($request->has('pecas_duplicadas')) {
            foreach ($request->pecas_duplicadas as $dadosDuplicada) {
                $coletaPecaOriginal = $coleta->pecas->find($dadosDuplicada['peca_original_id']);
                if ($coletaPecaOriginal && ($dadosDuplicada['quantidade_empacotada'] ?? 0) > 0) {
                    // Criar peça individual duplicada do empacotamento com QR code
                    EmpacotamentoPeca::create([
                        'empacotamento_id' => $empacotamento->id,
                        'tipo_id' => $coletaPecaOriginal->tipo_id,
                        'quantidade' => $dadosDuplicada['quantidade_empacotada'],
                        'peso' => $dadosDuplicada['peso_empacotado'] ?? 0,
                        'observacoes' => "Peça duplicada - Baseada na peça original ID: {$coletaPecaOriginal->id}"
                    ]);
                }
            }
        }

        // Processar peças extras (conferência de quantidade)
        if ($request->has('pecas_extras')) {
            foreach ($request->pecas_extras as $dadosExtra) {
                if (!empty($dadosExtra['tipo_id']) && ($dadosExtra['quantidade'] ?? 0) > 0) {
                    // Criar peça individual extra do empacotamento com QR code
                    EmpacotamentoPeca::create([
                        'empacotamento_id' => $empacotamento->id,
                        'tipo_id' => $dadosExtra['tipo_id'],
                        'quantidade' => $dadosExtra['quantidade'],
                        'peso' => $dadosExtra['peso'] ?? 0,
                        'observacoes' => 'Peça extra - Não estava na coleta original'
                    ]);
                }
            }
        }

        // Verificar se há novas peças para cadastrar (coleta por peso)
        if ($request->has('novas_pecas')) {
            // Para coletas por peso, substituir todas as peças existentes pelas novas
            // Remover peças existentes da coleta
            $coleta->pecas()->delete();

            // Criar novas peças baseadas no empacotamento
            foreach ($request->novas_pecas as $novaPeca) {
                if (!empty($novaPeca['tipo_id']) && !empty($novaPeca['quantidade'])) {
                    // Criar peça na coleta
                    ColetaPeca::create([
                        'coleta_id' => $coleta->id,
                        'tipo_id' => $novaPeca['tipo_id'],
                        'quantidade' => $novaPeca['quantidade'],
                        'peso' => 0, // Peso individual não é conhecido
                        'quantidade_empacotada' => $novaPeca['quantidade'],
                        'peso_empacotado' => 0,
                        'observacoes' => 'Tipos definidos no empacotamento (coleta foi por peso total)'
                    ]);

                    // Criar peça individual do empacotamento com QR code
                    EmpacotamentoPeca::create([
                        'empacotamento_id' => $empacotamento->id,
                        'tipo_id' => $novaPeca['tipo_id'],
                        'quantidade' => $novaPeca['quantidade'],
                        'peso' => $novaPeca['peso'] ?? 0,
                        'observacoes' => 'Peça empacotada - Coleta por peso total'
                    ]);
                }
            }
        }
    }

    /**
     * Processar atualizações das peças individuais do empacotamento
     */
    private function processarPecasIndividuaisEmpacotamento(Request $request, Empacotamento $empacotamento)
    {
        // Processar lotes removidos
        if ($request->has('lotes_removidos')) {
            foreach ($request->lotes_removidos as $pecaId) {
                $pecaIndividual = EmpacotamentoPeca::find($pecaId);
                if ($pecaIndividual && $pecaIndividual->empacotamento_id == $empacotamento->id) {
                    $pecaIndividual->delete();
                }
            }
        }

        // Verificar se há peças individuais para atualizar
        if ($request->has('pecas_individuais')) {
            foreach ($request->pecas_individuais as $pecaId => $dadosPeca) {
                $pecaIndividual = EmpacotamentoPeca::find($pecaId);

                if ($pecaIndividual && $pecaIndividual->empacotamento_id == $empacotamento->id) {
                    $pecaIndividual->update([
                        'quantidade' => $dadosPeca['quantidade'],
                        'peso' => $dadosPeca['peso'] ?? 0,
                    ]);
                }
            }
        }

        // Processar novos lotes
        if ($request->has('novos_lotes')) {
            foreach ($request->novos_lotes as $dadosLote) {
                EmpacotamentoPeca::create([
                    'empacotamento_id' => $empacotamento->id,
                    'tipo_id' => $dadosLote['tipo_id'],
                    'quantidade' => $dadosLote['quantidade'],
                    'peso' => $dadosLote['peso'] ?? 0,
                    'observacoes' => "Lote adicional - Tipo: {$dadosLote['tipo_nome']}"
                ]);
            }
        }

        // Processar peças extras
        if ($request->has('pecas_extras')) {
            // Debug: vamos ver o que está chegando
            \Log::info('Peças extras recebidas:', $request->pecas_extras);

            foreach ($request->pecas_extras as $dadosExtra) {
                $pecaExtra = EmpacotamentoPeca::create([
                    'empacotamento_id' => $empacotamento->id,
                    'tipo_id' => $dadosExtra['tipo_id'],
                    'quantidade' => $dadosExtra['quantidade'],
                    'peso' => $dadosExtra['peso'] ?? 0,
                    'observacoes' => $dadosExtra['observacoes'] ?? "Peça extra - Tipo: {$dadosExtra['tipo_nome']}"
                ]);

                \Log::info('Peça extra criada:', $pecaExtra->toArray());
            }
        } else {
            \Log::info('Nenhuma peça extra recebida no request');
        }
    }

    /**
     * Criar peças iniciais do empacotamento baseadas na coleta
     */
    private function criarPecasIniciaisEmpacotamento(Empacotamento $empacotamento)
    {
        $coleta = $empacotamento->coleta;

        // Para cada peça da coleta, criar uma peça individual no empacotamento com quantidade 0
        foreach ($coleta->pecas as $coletaPeca) {
            if ($coletaPeca->quantidade > 0) {
                // Criar peça individual com quantidade 0 (usuário vai preencher)
                EmpacotamentoPeca::create([
                    'empacotamento_id' => $empacotamento->id,
                    'tipo_id' => $coletaPeca->tipo_id,
                    'quantidade' => 0, // Quantidade 0 por padrão
                    'peso' => $coletaPeca->peso ?? 0,
                    'observacoes' => "Lote inicial - Qtd. original da coleta: {$coletaPeca->quantidade} peças"
                ]);

                // Inicializar quantidade_empacotada como 0 (não empacotou nada ainda)
                $coletaPeca->update([
                    'quantidade_empacotada' => 0,
                    'peso_empacotado' => 0,
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $empacotamento = Empacotamento::with([
            'coleta.estabelecimento',
            'coleta.pecas.tipo',
            'pecasIndividuais.tipo',
            'usuarioEmpacotamento',
            'motorista',
            'status'
        ])->findOrFail($id);

        return view('empacotamento.show', compact('empacotamento'));
    }

    /**
     * Confirmar entrega do empacotamento
     */
    public function confirmarEntrega(Request $request, $id)
    {
        $request->validate([
            'nome_recebedor' => 'required|string|max:255',
            'data_entrega' => 'required|date',
            'observacoes_entrega' => 'nullable|string|max:1000'
        ]);

        $empacotamento = Empacotamento::findOrFail($id);

        // Verificar se pode ser entregue
        if (!$empacotamento->podeSerEntregue()) {
            return back()->withErrors(['error' => 'Este empacotamento não pode ser entregue no status atual.']);
        }

        DB::beginTransaction();
        try {
            // Buscar status "Entregue"
            $statusEntregue = Status::where('nome', 'Entregue')->first();
            if (!$statusEntregue) {
                return back()->withErrors(['error' => 'Status "Entregue" não encontrado.']);
            }

            // Atualizar empacotamento
            $empacotamento->update([
                'status_id' => $statusEntregue->id,
                'data_entrega' => $request->data_entrega,
                'data_confirmacao_recebimento' => now(),
                'nome_recebedor' => $request->nome_recebedor,
                'observacoes_entrega' => $request->observacoes_entrega
            ]);

            // Atualizar status da coleta para "Entregue"
            $empacotamento->coleta->update(['status_id' => $statusEntregue->id]);

            DB::commit();

            return redirect()->route('empacotamento.show', $empacotamento->id)
                           ->with('success', 'Entrega confirmada com sucesso!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Erro ao confirmar entrega: ' . $e->getMessage()]);
        }
    }

    /**
     * Reimprimir QR Code
     */
    public function reimprimirQR($id)
    {
        $empacotamento = Empacotamento::with(['coleta.estabelecimento'])->findOrFail($id);

        return view('empacotamento.qrcode', compact('empacotamento'));
    }

    /**
     * Gerar etiqueta do empacotamento para impressão
     */
    public function gerarEtiqueta($id)
    {
        $empacotamento = Empacotamento::with([
            'coleta.estabelecimento',
            'coleta.pecas.tipo',
            'usuarioEmpacotamento',
            'pecasIndividuais.tipo'
        ])->findOrFail($id);

        return view('empacotamento.etiqueta', compact('empacotamento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $empacotamento = Empacotamento::with([
            'coleta.estabelecimento',
            'coleta.pecas.tipo',
            'pecasIndividuais.tipo',
            'usuarioEmpacotamento',
            'status'
        ])->findOrFail($id);

        // Verificar se pode ser editado
        if ($empacotamento->status->nome === 'Entregue') {
            return redirect()->route('empacotamento.show', $empacotamento->id)
                           ->with('error', 'Empacotamentos entregues não podem ser editados.');
        }

        $tipos = Tipo::ativos()->orderBy('nome')->get();

        return view('empacotamento.edit', compact('empacotamento', 'tipos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $empacotamento = Empacotamento::findOrFail($id);

        // Verificar se pode ser editado
        if ($empacotamento->status->nome === 'Entregue') {
            return redirect()->back()
                           ->with('error', 'Empacotamentos entregues não podem ser editados.');
        }

        $request->validate([
            'data_empacotamento' => 'required|date',
            'observacoes_empacotamento' => 'nullable|string|max:1000'
        ]);

        DB::beginTransaction();
        try {
            // Atualizar empacotamento
            $empacotamento->update([
                'data_empacotamento' => $request->data_empacotamento,
                'observacoes_empacotamento' => $request->observacoes_empacotamento
            ]);

            // Processar peças individuais atualizadas
            $this->processarPecasIndividuaisEmpacotamento($request, $empacotamento);

            DB::commit();

            return redirect()->route('empacotamento.show', $empacotamento->id)
                           ->with('success', 'Empacotamento atualizado com sucesso!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Erro ao atualizar empacotamento: ' . $e->getMessage()]);
        }
    }

    /**
     * Concluir empacotamento
     */
    public function concluir($id)
    {
        $empacotamento = Empacotamento::findOrFail($id);

        // Verificar se pode ser concluído
        if ($empacotamento->status->nome !== 'Pronto para motorista') {
            return response()->json([
                'success' => false,
                'message' => 'Apenas empacotamentos "Pronto para motorista" podem ser concluídos.'
            ]);
        }

        DB::beginTransaction();
        try {
            // Empacotamento já está "Pronto para motorista", não precisa alterar status
            // O status só mudará quando o motorista confirmar a saída
            
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Empacotamento concluído e pronto para o motorista!'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao concluir empacotamento: ' . $e->getMessage()
            ]);
        }
    }
}
