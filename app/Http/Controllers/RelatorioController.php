<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coleta;
use App\Models\Empacotamento;
use App\Models\Estabelecimento;

class RelatorioController extends Controller
{
    /**
     * Página principal de relatórios
     */
    public function index()
    {
        return view('relatorios.index');
    }

    /**
     * Relatório de coletas
     */
    public function coletas(Request $request)
    {
        $query = Coleta::with(['estabelecimento', 'usuario']);

        // Filtros por data
        if ($request->filled('data_inicio')) {
            $query->whereDate('data_coleta', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->whereDate('data_coleta', '<=', $request->data_fim);
        }

        // Filtro por estabelecimento
        if ($request->filled('estabelecimento_id')) {
            $query->where('estabelecimento_id', $request->estabelecimento_id);
        }

        $coletas = $query->orderBy('data_coleta', 'desc')->paginate(20);
        $estabelecimentos = Estabelecimento::where('ativo', true)->get();

        return view('relatorios.coletas', compact('coletas', 'estabelecimentos'));
    }

    /**
     * Relatório de empacotamentos
     */
    public function empacotamentos(Request $request)
    {
        $query = Empacotamento::with(['coleta.estabelecimento', 'usuario']);

        // Filtros por data
        if ($request->filled('data_inicio')) {
            $query->whereDate('data_empacotamento', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->whereDate('data_empacotamento', '<=', $request->data_fim);
        }

        $empacotamentos = $query->orderBy('data_empacotamento', 'desc')->paginate(20);

        return view('relatorios.empacotamentos', compact('empacotamentos'));
    }

    /**
     * Relatório de produtividade
     */
    public function produtividade(Request $request)
    {
        $dataInicio = $request->filled('data_inicio') ? $request->data_inicio : now()->startOfMonth()->format('Y-m-d');
        $dataFim = $request->filled('data_fim') ? $request->data_fim : now()->format('Y-m-d');

        // Estatísticas gerais
        $totalColetas = Coleta::whereBetween('data_coleta', [$dataInicio, $dataFim])->count();
        $totalEmpacotamentos = Empacotamento::whereBetween('data_empacotamento', [$dataInicio, $dataFim])->count();

        return view('relatorios.produtividade', compact('totalColetas', 'totalEmpacotamentos', 'dataInicio', 'dataFim'));
    }
}
