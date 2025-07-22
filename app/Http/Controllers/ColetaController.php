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

        return view('coletas.create', compact('estabelecimentos', 'tipos', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'estabelecimento_id' => 'required|exists:estabelecimentos,id',
            'data_agendamento' => 'required|date|after_or_equal:today',
            'observacoes' => 'nullable|string',
        ], [
            'estabelecimento_id.required' => 'Selecione um estabelecimento.',
            'estabelecimento_id.exists' => 'Estabelecimento inválido.',
            'data_agendamento.required' => 'A data de agendamento é obrigatória.',
            'data_agendamento.date' => 'Data de agendamento inválida.',
            'data_agendamento.after_or_equal' => 'A data deve ser hoje ou futura.',
        ]);

        try {
            // Buscar status inicial
            $statusInicial = Status::where('tipo', 'coleta')
                                  ->where('nome', 'Agendada')
                                  ->first();

            // Criar coleta
            $coleta = Coleta::create([
                'estabelecimento_id' => $request->estabelecimento_id,
                'usuario_id' => Auth::id(),
                'status_id' => $statusInicial->id,
                'data_agendamento' => $request->data_agendamento,
                'observacoes' => $request->observacoes,
            ]);

            return redirect()->route('coletas.add-pecas', $coleta->id)
                           ->with('success', 'Coleta criada com sucesso! Agora adicione as peças coletadas.');

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
        $coleta = Coleta::with(['estabelecimento', 'status'])->findOrFail($id);
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
            'pecas.*.tipo_id' => 'required|exists:tipos,id',
            'pecas.*.quantidade' => 'required|integer|min:1',
            'pecas.*.peso' => 'required|numeric|min:0.01',
        ], [
            'pecas.required' => 'Adicione pelo menos uma peça.',
            'pecas.min' => 'Adicione pelo menos uma peça.',
            'pecas.*.tipo_id.required' => 'Selecione o tipo da peça.',
            'pecas.*.tipo_id.exists' => 'Tipo de peça inválido.',
            'pecas.*.quantidade.required' => 'Informe a quantidade.',
            'pecas.*.quantidade.integer' => 'A quantidade deve ser um número inteiro.',
            'pecas.*.quantidade.min' => 'A quantidade deve ser pelo menos 1.',
            'pecas.*.peso.required' => 'Informe o peso.',
            'pecas.*.peso.numeric' => 'O peso deve ser um número.',
            'pecas.*.peso.min' => 'O peso deve ser maior que 0.',
        ]);

        DB::beginTransaction();
        try {
            // Remover peças existentes se houver
            $coleta->pecas()->delete();

            // Criar peças da coleta
            foreach ($request->pecas as $pecaData) {
                $tipo = Tipo::find($pecaData['tipo_id']);

                ColetaPeca::create([
                    'coleta_id' => $coleta->id,
                    'tipo_id' => $pecaData['tipo_id'],
                    'quantidade' => $pecaData['quantidade'],
                    'peso' => $pecaData['peso'],
                    'preco_unitario' => $tipo->preco_kg,
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
    public function concluir($id)
    {
        $coleta = Coleta::findOrFail($id);

        $statusConcluida = Status::where('tipo', 'coleta')
                                ->where('nome', 'Concluída')
                                ->first();

        $coleta->update([
            'status_id' => $statusConcluida->id,
            'data_coleta' => now(),
            'data_conclusao' => now(),
        ]);

        return redirect()->route('coletas.show', $coleta->id)
                       ->with('success', 'Coleta concluída com sucesso.');
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
        $pecas = ColetaPeca::where('coleta_id', $id)
                          ->with('tipo')
                          ->get();

        return response()->json($pecas);
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
}
