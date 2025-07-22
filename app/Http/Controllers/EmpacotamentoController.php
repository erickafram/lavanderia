<?php

namespace App\Http\Controllers;

use App\Models\Empacotamento;
use App\Models\Coleta;
use App\Models\Usuario;
use App\Models\Status;
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
        $query = Empacotamento::with(['coleta.estabelecimento', 'usuarioEmpacotamento', 'motorista', 'status']);

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
    public function create()
    {
        // Buscar coletas que podem ser empacotadas (concluídas e não empacotadas)
        $coletas = Coleta::with(['estabelecimento', 'pecas.tipo'])
                        ->whereHas('status', function($q) {
                            $q->where('nome', 'Concluída');
                        })
                        ->whereDoesntHave('empacotamento')
                        ->orderBy('numero_coleta', 'desc')
                        ->get();

        $motoristas = Usuario::where('ativo', true)
                            ->orderBy('nome')
                            ->get();

        $statusEmpacotamento = Status::where('nome', 'Em empacotamento')->first();

        return view('empacotamento.create', compact('coletas', 'motoristas', 'statusEmpacotamento'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'coleta_id' => 'required|exists:coletas,id',
            'motorista_id' => 'nullable|exists:usuarios,id',
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

            // Buscar status "Em empacotamento"
            $statusEmpacotamento = Status::where('nome', 'Em empacotamento')->first();
            if (!$statusEmpacotamento) {
                return back()->withErrors(['status' => 'Status "Em empacotamento" não encontrado.']);
            }

            // Criar empacotamento
            $empacotamento = Empacotamento::create([
                'coleta_id' => $request->coleta_id,
                'usuario_empacotamento_id' => Auth::id(),
                'motorista_id' => $request->motorista_id,
                'status_id' => $statusEmpacotamento->id,
                'data_empacotamento' => $request->data_empacotamento,
                'observacoes_empacotamento' => $request->observacoes_empacotamento
            ]);

            // Atualizar status da coleta para "Empacotada"
            $statusEmpacotada = Status::where('nome', 'Empacotada')->first();
            if ($statusEmpacotada) {
                $empacotamento->coleta->update(['status_id' => $statusEmpacotada->id]);
            }

            DB::commit();

            return redirect()->route('empacotamento.show', $empacotamento->id)
                           ->with('success', 'Empacotamento criado com sucesso!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Erro ao criar empacotamento: ' . $e->getMessage()]);
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
}
