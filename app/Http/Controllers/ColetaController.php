<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coleta;
use App\Models\ColetaPeca;
use App\Models\Estabelecimento;
use App\Models\Status;
use App\Models\Tipo;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ColetaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Coleta::with(['estabelecimento', 'usuario', 'status'])
                      ->orderBy('created_at', 'desc');

        // Filtros
        if ($request->filled('estabelecimento_id')) {
            $query->where('estabelecimento_id', $request->estabelecimento_id);
        }

        if ($request->filled('status_id')) {
            $query->where('status_id', $request->status_id);
        }

        if ($request->filled('data_inicio')) {
            $query->whereDate('data_agendamento', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->whereDate('data_agendamento', '<=', $request->data_fim);
        }

        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function($q) use ($busca) {
                $q->where('numero_coleta', 'like', "%{$busca}%")
                  ->orWhereHas('estabelecimento', function($eq) use ($busca) {
                      $eq->where('razao_social', 'like', "%{$busca}%")
                         ->orWhere('nome_fantasia', 'like', "%{$busca}%");
                  });
            });
        }

        $coletas = $query->paginate(15);
        $estabelecimentos = Estabelecimento::ativos()->orderBy('razao_social')->get();
        $status = Status::where('tipo', 'coleta')->orderBy('ordem')->get();

        return view('coletas.index', compact('coletas', 'estabelecimentos', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $estabelecimentos = Estabelecimento::ativos()->orderBy('razao_social')->get();
        $tipos = Tipo::ativos()->orderBy('nome')->get();
        $status = Status::where('tipo', 'coleta')
                       ->where('nome', 'Agendada')
                       ->first();

        // Buscar usuários com nível de acesso "Motorista"
        $motoristas = Usuario::whereHas('nivelAcesso', function($query) {
                                $query->where('nome', 'Motorista');
                            })
                            ->where('ativo', true)
                            ->orderBy('nome')
                            ->get();

        return view('coletas.create', compact('estabelecimentos', 'tipos', 'status', 'motoristas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validações básicas
        $rules = [
            'estabelecimento_id' => 'required|exists:estabelecimentos,id',
            'tipo_coleta' => 'required|in:agendada,imediata',
            'observacoes' => 'nullable|string',
            'acompanhante_id' => 'nullable|exists:usuarios,id',
        ];

        $messages = [
            'estabelecimento_id.required' => 'Selecione um estabelecimento.',
            'estabelecimento_id.exists' => 'Estabelecimento inválido.',
            'tipo_coleta.required' => 'Selecione o tipo de coleta.',
            'tipo_coleta.in' => 'Tipo de coleta inválido.',
            'acompanhante_id.exists' => 'Motorista selecionado inválido.',
        ];

        // Adicionar validação de data apenas se for coleta agendada
        if ($request->tipo_coleta === 'agendada') {
            $rules['data_agendamento'] = 'required|date|after_or_equal:today';
            $messages['data_agendamento.required'] = 'A data de agendamento é obrigatória para coletas agendadas.';
            $messages['data_agendamento.date'] = 'Data de agendamento inválida.';
            $messages['data_agendamento.after_or_equal'] = 'A data deve ser hoje ou futura.';
        }

        $request->validate($rules, $messages);

        try {
            // Determinar status inicial baseado no tipo de coleta
            if ($request->tipo_coleta === 'agendada') {
                $statusInicial = Status::where('tipo', 'coleta')
                                      ->where('nome', 'Agendada')
                                      ->first();
                $dataAgendamento = $request->data_agendamento;
                $mensagemSucesso = 'Coleta agendada com sucesso! Você pode visualizar e gerenciar suas coletas na lista.';
            } else {
                // Para coleta imediata, usar status "Disponível para Coleta" ou similar
                $statusInicial = Status::where('tipo', 'coleta')
                                      ->where('nome', 'Coletado')
                                      ->first();
                
                // Se não encontrar status "Coletado", usar "Agendada" como fallback
                if (!$statusInicial) {
                    $statusInicial = Status::where('tipo', 'coleta')
                                          ->where('nome', 'Agendada')
                                          ->first();
                }
                
                $dataAgendamento = now(); // Data atual para coletas imediatas
                $mensagemSucesso = 'Coleta criada com sucesso! Esta coleta está disponível para execução imediata.';
            }

            // Buscar nome do motorista se selecionado
            $nomeAcompanhante = null;
            if ($request->acompanhante_id) {
                $motorista = Usuario::find($request->acompanhante_id);
                $nomeAcompanhante = $motorista ? $motorista->nome : null;
            }

            // Criar coleta
            $coleta = Coleta::create([
                'estabelecimento_id' => $request->estabelecimento_id,
                'usuario_id' => Auth::id(),
                'status_id' => $statusInicial->id,
                'data_agendamento' => $dataAgendamento,
                'observacoes' => $request->observacoes,
                'acompanhante' => $nomeAcompanhante,
            ]);

            return redirect()->route('coletas.index')
                           ->with('success', $mensagemSucesso);

        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Erro ao criar coleta: ' . $e->getMessage());
        }
    }

    /**
     * Show form to add pieces to collection
     */
    public function addPecas($id)
    {
        $coleta = Coleta::with(['estabelecimento', 'status', 'pecas.tipo'])->findOrFail($id);
        $tipos = Tipo::ativos()->orderBy('nome')->get();

        return view('coletas.add-pecas', compact('coleta', 'tipos'));
    }

    /**
     * Store pieces for collection
     */
    public function storePecas(Request $request, $id)
    {
        $coleta = Coleta::findOrFail($id);

        $request->validate([
            'pecas' => 'required|array|min:1',
            'pecas.*.tipo_id' => 'nullable|exists:tipos,id',
            'pecas.*.modo_coleta' => 'required|in:quantidade,peso',
            'pecas.*.quantidade' => 'nullable|integer|min:1',
            'pecas.*.peso' => 'nullable|numeric|min:0.01',
        ], [
            'pecas.required' => 'Adicione pelo menos uma peça.',
            'pecas.min' => 'Adicione pelo menos uma peça.',
            'pecas.*.tipo_id.exists' => 'Tipo de peça inválido.',
            'pecas.*.modo_coleta.required' => 'Selecione o modo de coleta.',
            'pecas.*.modo_coleta.in' => 'Modo de coleta inválido.',
            'pecas.*.quantidade.integer' => 'A quantidade deve ser um número inteiro.',
            'pecas.*.quantidade.min' => 'A quantidade deve ser pelo menos 1.',
            'pecas.*.peso.numeric' => 'O peso deve ser um número.',
            'pecas.*.peso.min' => 'O peso deve ser maior que 0.',
        ]);

        // Validação customizada baseada no modo de coleta
        foreach ($request->pecas as $index => $pecaData) {
            if ($pecaData['modo_coleta'] === 'quantidade') {
                if (empty($pecaData['quantidade'])) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(["pecas.{$index}.quantidade" => 'A quantidade é obrigatória no modo por quantidade.']);
                }
                if (empty($pecaData['tipo_id'])) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(["pecas.{$index}.tipo_id" => 'Selecione o tipo da peça.']);
                }
            }
            if ($pecaData['modo_coleta'] === 'peso' && empty($pecaData['peso'])) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(["pecas.{$index}.peso" => 'O peso é obrigatório no modo por peso.']);
            }
        }

        DB::beginTransaction();
        try {
            // Remover peças existentes se houver
            $coleta->pecas()->delete();

            // Criar peças da coleta
            foreach ($request->pecas as $pecaData) {
                // Definir valores baseados no modo de coleta
                $quantidade = $pecaData['modo_coleta'] === 'quantidade' ? $pecaData['quantidade'] : 0;
                $peso = $pecaData['modo_coleta'] === 'peso' ? $pecaData['peso'] : 0;

                // Se for coleta por peso, usar o tipo especial "Peso"
                $tipoId = $pecaData['modo_coleta'] === 'peso'
                    ? \App\Models\Tipo::getTipoPeso()->id
                    : $pecaData['tipo_id'];

                ColetaPeca::create([
                    'coleta_id' => $coleta->id,
                    'tipo_id' => $tipoId,
                    'quantidade' => $quantidade,
                    'peso' => $peso,
                    'observacoes' => $pecaData['observacoes'] ?? null,
                ]);
            }

            // Calcular totais da coleta após criar todas as peças
            $coleta->calcularTotais();

            DB::commit();

            return redirect()->route('coletas.show', $coleta->id)
                           ->with('success', 'Peças adicionadas com sucesso! Coleta finalizada.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Erro ao adicionar peças: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $coleta = Coleta::with(['estabelecimento', 'usuario', 'status', 'pecas.tipo', 'empacotamento'])
                       ->findOrFail($id);

        return view('coletas.show', compact('coleta'));
    }

    /**
     * Cancelar uma coleta
     */
    public function cancelar(Request $request, $id)
    {
        $request->validate([
            'motivo_cancelamento' => 'required|string|max:500',
        ], [
            'motivo_cancelamento.required' => 'O motivo do cancelamento é obrigatório.',
            'motivo_cancelamento.max' => 'O motivo deve ter no máximo 500 caracteres.',
        ]);

        $coleta = Coleta::findOrFail($id);

        if (!$coleta->podeSerCancelada()) {
            return redirect()->back()
                           ->with('error', 'Esta coleta não pode ser cancelada.');
        }

        $statusCancelada = Status::where('tipo', 'coleta')
                                ->where('nome', 'Cancelada')
                                ->first();

        $coleta->update([
            'status_id' => $statusCancelada->id,
            'motivo_cancelamento' => $request->motivo_cancelamento,
        ]);

        return redirect()->route('coletas.show', $coleta->id)
                       ->with('success', 'Coleta cancelada com sucesso.');
    }

    /**
     * Concluir uma coleta
     */
    public function concluir(Request $request, $id)
    {
        $coleta = Coleta::with('pecas')->findOrFail($id);

        // Verificar se a coleta pode ser concluída
        if (!$coleta->podeSerCancelada() || $coleta->status->nome === 'Concluída') {
            return redirect()->back()
                           ->with('error', 'Esta coleta não pode ser concluída.');
        }

        // Verificar se tem peças cadastradas
        if ($coleta->pecas->count() === 0) {
            // Se não tem peças e não foi forçada a conclusão, retornar erro
            if (!$request->has('forcar_conclusao')) {
                return redirect()->back()
                               ->with('warning', 'Esta coleta não possui peças cadastradas. Para concluir mesmo assim, confirme a ação.')
                               ->with('show_force_completion', true);
            }
        }

        $statusConcluida = Status::where('tipo', 'coleta')
                                ->where('nome', 'Concluída')
                                ->first();

        if (!$statusConcluida) {
            return redirect()->back()
                           ->with('error', 'Status "Concluída" não encontrado no sistema.');
        }

        $coleta->update([
            'status_id' => $statusConcluida->id,
            'data_coleta' => now(),
            'data_conclusao' => now(),
        ]);

        $mensagem = $coleta->pecas->count() === 0 
            ? 'Coleta concluída com sucesso (sem peças cadastradas).'
            : 'Coleta concluída com sucesso.';

        return redirect()->route('coletas.show', $coleta->id)
                       ->with('success', $mensagem);
    }

    /**
     * API: Buscar coletas por estabelecimento
     */
    public function getColetasPorEstabelecimento($estabelecimento_id)
    {
        $coletas = Coleta::where('estabelecimento_id', $estabelecimento_id)
                        ->with(['status', 'pecas.tipo'])
                        ->orderBy('created_at', 'desc')
                        ->get();

        return response()->json($coletas);
    }

    /**
     * API: Buscar peças de uma coleta
     */
    public function getPecasColeta($id)
    {
        $coleta = Coleta::with(['pecas.tipo'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'coleta' => [
                'id' => $coleta->id,
                'numero_coleta' => $coleta->numero_coleta,
                'peso_total' => $coleta->peso_total,
            ],
            'pecas' => $coleta->pecas->map(function($peca) {
                return [
                    'id' => $peca->id,
                    'tipo_id' => $peca->tipo_id,
                    'quantidade' => $peca->quantidade,
                    'peso' => $peca->peso,
                    'observacoes' => $peca->observacoes,
                    'tipo' => [
                        'id' => $peca->tipo->id,
                        'nome' => $peca->tipo->nome,
                        'categoria' => $peca->tipo->categoria,
                    ]
                ];
            })
        ]);
    }

    /**
     * API: Buscar detalhes de uma coleta
     */
    public function getDetalhesColeta($id)
    {
        $coleta = Coleta::with(['estabelecimento', 'usuario', 'status', 'pecas.tipo'])
                       ->findOrFail($id);

        return response()->json($coleta);
    }

    /**
     * API: Buscar tipos de peças
     */
    public function getTipos()
    {
        $tipos = Tipo::ativos()->orderBy('nome')->get();
        return response()->json($tipos);
    }

    /**
     * API: Buscar dados atualizados das coletas
     */
    public function getColetasAtualizadas(Request $request)
    {
        $query = Coleta::with(['estabelecimento', 'usuario', 'status'])
                      ->orderBy('created_at', 'desc');

        // Aplicar os mesmos filtros da index
        if ($request->filled('estabelecimento_id')) {
            $query->where('estabelecimento_id', $request->estabelecimento_id);
        }

        if ($request->filled('status_id')) {
            $query->where('status_id', $request->status_id);
        }

        if ($request->filled('data_inicio')) {
            $query->whereDate('data_agendamento', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->whereDate('data_agendamento', '<=', $request->data_fim);
        }

        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function($q) use ($busca) {
                $q->where('numero_coleta', 'like', "%{$busca}%")
                  ->orWhereHas('estabelecimento', function($eq) use ($busca) {
                      $eq->where('razao_social', 'like', "%{$busca}%")
                         ->orWhere('nome_fantasia', 'like', "%{$busca}%");
                  });
            });
        }

        $coletas = $query->paginate(15);

        // Calcular estatísticas
        $stats = [
            'total_coletas' => Coleta::count(),
            'em_andamento' => Coleta::whereHas('status', function($q) {
                $q->where('nome', 'Em andamento');
            })->count(),
            'concluidas' => Coleta::whereHas('status', function($q) {
                $q->where('nome', 'Concluída');
            })->count(),
            'mes_atual' => Coleta::whereMonth('created_at', now()->month)
                                ->whereYear('created_at', now()->year)
                                ->count()
        ];

        return response()->json([
            'coletas' => $coletas,
            'stats' => $stats,
            'timestamp' => now()->format('d/m/Y H:i:s')
        ]);
    }
}
