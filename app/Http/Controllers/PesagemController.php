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
        $query = Pesagem::with(['coleta.estabelecimento', 'usuario', 'tipo', 'usuarioConferencia'])
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

        if ($request->filled('conferido')) {
            $query->where('conferido', $request->conferido === '1');
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
        $pesagensConferidas = Pesagem::where('conferido', true)->count();
        $pesoTotalHoje = Pesagem::whereDate('data_pesagem', today())->sum('peso');

        return view('pesagem.index', compact(
            'pesagens', 
            'coletas', 
            'tipos', 
            'usuarios',
            'totalPesagens',
            'pesagensHoje',
            'pesagensConferidas',
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
     * Store a newly created resource in storage.
     */
    public function store(PesagemRequest $request)
    {
        DB::beginTransaction();
        try {
            $pesagem = Pesagem::create([
                'coleta_id' => $request->coleta_id,
                'usuario_id' => Auth::id(),
                'tipo_id' => $request->tipo_id,
                'peso' => $request->peso,
                'quantidade' => $request->quantidade,
                'data_pesagem' => $request->data_pesagem,
                'local_pesagem' => $request->local_pesagem,
                'observacoes' => $request->observacoes,
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
     * Display the specified resource.
     */
    public function show($id)
    {
        $pesagem = Pesagem::with([
            'coleta.estabelecimento', 
            'coleta.pecas.tipo',
            'usuario', 
            'tipo', 
            'usuarioConferencia'
        ])->findOrFail($id);

        return view('pesagem.show', compact('pesagem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pesagem = Pesagem::with(['coleta.estabelecimento'])->findOrFail($id);

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
     * Conferir uma pesagem
     */
    public function conferir($id)
    {
        $pesagem = Pesagem::findOrFail($id);
        $pesagem->conferir(Auth::id());

        return redirect()->back()
                       ->with('success', 'Pesagem conferida com sucesso!');
    }

    /**
     * Desconferir uma pesagem
     */
    public function desconferir($id)
    {
        $pesagem = Pesagem::findOrFail($id);
        $pesagem->desconferir();

        return redirect()->back()
                       ->with('success', 'Conferência da pesagem removida!');
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
