<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PesagemRequest;
use App\Models\Pesagem;
use App\Models\Coleta;
use App\Models\Tipo;
use App\Models\Usuario;
use App\Models\ColetaPeca;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PesagemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pesagem::with(['coleta.estabelecimento', 'usuario', 'tipo'])
                        ->orderBy('data_pesagem', 'desc');

        // Filtros
        if ($request->filled('coleta_id')) {
            $query->where('coleta_id', $request->coleta_id);
        }

        if ($request->filled('tipo_id')) {
            $query->where('tipo_id', $request->tipo_id);
        }

        if ($request->filled('usuario_id')) {
            $query->where('usuario_id', $request->usuario_id);
        }



        if ($request->filled('data_inicio')) {
            $query->whereDate('data_pesagem', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->whereDate('data_pesagem', '<=', $request->data_fim);
        }

        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function($q) use ($busca) {
                $q->whereHas('coleta', function($cq) use ($busca) {
                    $cq->where('numero_coleta', 'like', "%{$busca}%")
                       ->orWhereHas('estabelecimento', function($eq) use ($busca) {
                           $eq->where('razao_social', 'like', "%{$busca}%")
                              ->orWhere('nome_fantasia', 'like', "%{$busca}%");
                       });
                })
                ->orWhereHas('tipo', function($tq) use ($busca) {
                    $tq->where('nome', 'like', "%{$busca}%");
                })
                ->orWhereHas('usuario', function($uq) use ($busca) {
                    $uq->where('nome', 'like', "%{$busca}%");
                });
            });
        }

        $pesagens = $query->paginate(15);
        
        // Dados para filtros
        $coletas = Coleta::with('estabelecimento')->orderBy('numero_coleta', 'desc')->limit(50)->get();
        $tipos = Tipo::ativos()->orderBy('nome')->get();
        $usuarios = Usuario::ativos()->orderBy('nome')->get();

        // Estatísticas
        $totalPesagens = Pesagem::count();
        $pesagensHoje = Pesagem::whereDate('data_pesagem', today())->count();
        $pesoTotalHoje = Pesagem::whereDate('data_pesagem', today())->sum('peso');

        return view('pesagem.index', compact(
            'pesagens',
            'coletas',
            'tipos',
            'usuarios',
            'totalPesagens',
            'pesagensHoje',
            'pesoTotalHoje'
        ));
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

        $coletas = Coleta::with('estabelecimento')
                        ->whereHas('status', function($q) {
                            $q->whereIn('nome', ['Concluída', 'Em Andamento']);
                        })
                        ->orderBy('numero_coleta', 'desc')
                        ->get();

        $tipos = Tipo::ativos()->orderBy('nome')->get();

        return view('pesagem.create', compact('coletas', 'tipos', 'coleta'));
    }

    /**
     * Show the form for creating pesagem with pieces comparison
     */
    public function createComparacao(Request $request)
    {
        $coletaId = $request->get('coleta_id');

        if (!$coletaId) {
            return redirect()->route('pesagem.create')
                           ->with('error', 'Selecione uma coleta para fazer a pesagem.');
        }

        $coleta = Coleta::with(['estabelecimento', 'pecas.tipo'])->findOrFail($coletaId);

        // Verificar se a coleta tem peças
        if ($coleta->pecas->isEmpty()) {
            return redirect()->route('pesagem.create')
                           ->with('error', 'Esta coleta não possui peças cadastradas.');
        }

        return view('pesagem.create-comparacao', compact('coleta'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PesagemRequest $request)
    {
        DB::beginTransaction();
        try {
            $pesagem = Pesagem::create([
                'coleta_id' => $request->coleta_id,
                'usuario_id' => Auth::id(),
                'tipo_id' => null, // Pesagem geral, sem tipo específico
                'peso' => $request->peso,
                'quantidade' => $request->quantidade,
                'data_pesagem' => $request->data_pesagem,
                'local_pesagem' => $request->local_pesagem,
                'observacoes' => $request->observacoes_gerais,
            ]);

            DB::commit();

            return redirect()->route('pesagem.index')
                           ->with('success', 'Pesagem registrada com sucesso!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Erro ao registrar pesagem: ' . $e->getMessage());
        }
    }

    /**
     * Store pesagem geral (sem tipo específico)
     */
    public function storeGeral(Request $request)
    {
        $request->validate([
            'coleta_id' => 'required|exists:coletas,id',
            'peso' => 'required|numeric|min:0.01|max:999.99',
            'quantidade' => 'required|integer|min:1|max:999',
            'data_pesagem' => 'required|date|before_or_equal:now',
            'local_pesagem' => 'nullable|string|max:255',
            'observacoes_gerais' => 'nullable|string|max:1000',
        ], [
            'coleta_id.required' => 'Coleta é obrigatória.',
            'peso.required' => 'Peso é obrigatório.',
            'peso.numeric' => 'Peso deve ser um número.',
            'peso.min' => 'Peso deve ser maior que 0.',
            'quantidade.required' => 'Quantidade é obrigatória.',
            'quantidade.integer' => 'Quantidade deve ser um número inteiro.',
            'quantidade.min' => 'Quantidade deve ser pelo menos 1.',
            'data_pesagem.required' => 'Data da pesagem é obrigatória.',
            'data_pesagem.before_or_equal' => 'Data da pesagem não pode ser futura.',
        ]);

        DB::beginTransaction();
        try {
            $pesagem = Pesagem::create([
                'coleta_id' => $request->coleta_id,
                'usuario_id' => Auth::id(),
                'tipo_id' => null, // Pesagem geral, sem tipo específico
                'peso' => $request->peso,
                'quantidade' => $request->quantidade,
                'data_pesagem' => $request->data_pesagem,
                'local_pesagem' => $request->local_pesagem,
                'observacoes' => $request->observacoes_gerais,
            ]);

            DB::commit();

            return redirect()->route('pesagem.index')
                           ->with('success', 'Pesagem registrada com sucesso!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Erro ao registrar pesagem: ' . $e->getMessage());
        }
    }

    /**
     * Store pesagem with pieces comparison
     */
    public function storeComparacao(Request $request)
    {
        $request->validate([
            'coleta_id' => 'required|exists:coletas,id',
            'data_pesagem' => 'required|date',
            'local_pesagem' => 'nullable|string|max:255',
            'observacoes_gerais' => 'nullable|string',
            'pecas' => 'required|array|min:1',
            'pecas.*.peso_pesagem' => 'required|numeric|min:0',
            'pecas.*.quantidade_pesagem' => 'required|integer|min:0',
        ], [
            'coleta_id.required' => 'Coleta é obrigatória.',
            'data_pesagem.required' => 'Data da pesagem é obrigatória.',
            'pecas.required' => 'Pelo menos uma peça deve ser pesada.',
            'pecas.*.peso_pesagem.required' => 'Peso da pesagem é obrigatório.',
            'pecas.*.quantidade_pesagem.required' => 'Quantidade da pesagem é obrigatória.',
        ]);

        DB::beginTransaction();
        try {
            $coleta = Coleta::with('pecas')->findOrFail($request->coleta_id);

            // Criar pesagens para cada peça
            foreach ($request->pecas as $pecaId => $dadosPesagem) {
                $coletaPeca = $coleta->pecas->find($pecaId);

                if ($coletaPeca) {
                    Pesagem::create([
                        'coleta_id' => $request->coleta_id,
                        'usuario_id' => Auth::id(),
                        'tipo_id' => $coletaPeca->tipo_id,
                        'peso' => $dadosPesagem['peso_pesagem'],
                        'quantidade' => $dadosPesagem['quantidade_pesagem'],
                        'data_pesagem' => $request->data_pesagem,
                        'local_pesagem' => $request->local_pesagem,
                        'observacoes' => $request->observacoes_gerais,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('pesagem.index')
                           ->with('success', 'Pesagem com comparação registrada com sucesso!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Erro ao registrar pesagem: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pesagem = Pesagem::with([
            'coleta.estabelecimento',
            'coleta.pecas.tipo',
            'usuario',
            'tipo'
        ])->findOrFail($id);

        return view('pesagem.show', compact('pesagem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pesagem = Pesagem::with(['coleta.estabelecimento', 'coleta.pecas.tipo'])->findOrFail($id);

        if (!$pesagem->podeSerEditada()) {
            return redirect()->route('pesagem.index')
                           ->with('error', 'Esta pesagem não pode ser editada.');
        }

        $coletas = Coleta::with('estabelecimento')
                        ->whereHas('status', function($q) {
                            $q->whereIn('nome', ['Concluída', 'Em Andamento']);
                        })
                        ->orderBy('numero_coleta', 'desc')
                        ->get();

        $tipos = Tipo::ativos()->orderBy('nome')->get();

        return view('pesagem.edit', compact('pesagem', 'coletas', 'tipos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PesagemRequest $request, $id)
    {
        $pesagem = Pesagem::findOrFail($id);

        if (!$pesagem->podeSerEditada()) {
            return redirect()->route('pesagem.index')
                           ->with('error', 'Esta pesagem não pode ser editada.');
        }

        DB::beginTransaction();
        try {
            $pesagem->update([
                'coleta_id' => $request->coleta_id,
                'tipo_id' => $request->tipo_id,
                'peso' => $request->peso,
                'quantidade' => $request->quantidade,
                'data_pesagem' => $request->data_pesagem,
                'local_pesagem' => $request->local_pesagem,
                'observacoes' => $request->observacoes,
            ]);

            DB::commit();

            return redirect()->route('pesagem.index')
                           ->with('success', 'Pesagem atualizada com sucesso!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Erro ao atualizar pesagem: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pesagem = Pesagem::findOrFail($id);

        if (!$pesagem->podeSerEditada()) {
            return redirect()->route('pesagem.index')
                           ->with('error', 'Esta pesagem não pode ser excluída.');
        }

        $pesagem->delete();

        return redirect()->route('pesagem.index')
                       ->with('success', 'Pesagem excluída com sucesso!');
    }



    /**
     * API: Buscar pesagens por coleta
     */
    public function getPesagensPorColeta($coletaId)
    {
        $pesagens = Pesagem::where('coleta_id', $coletaId)
                          ->with(['tipo', 'usuario'])
                          ->orderBy('data_pesagem', 'desc')
                          ->get();

        return response()->json($pesagens);
    }

    /**
     * API: Buscar resumo de pesagens por coleta
     */
    public function getResumoPesagemColeta($coletaId)
    {
        $resumo = Pesagem::where('coleta_id', $coletaId)
                        ->selectRaw('
                            tipo_id,
                            SUM(peso) as peso_total,
                            SUM(quantidade) as quantidade_total,
                            COUNT(*) as total_pesagens
                        ')
                        ->with('tipo')
                        ->groupBy('tipo_id')
                        ->get();

        return response()->json($resumo);
    }
}
