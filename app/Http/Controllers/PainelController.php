<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coleta;
use App\Models\Empacotamento;
use App\Models\Estabelecimento;
use App\Models\Usuario;
use Carbon\Carbon;

class PainelController extends Controller
{
    /**
     * Exibe o dashboard principal
     */
    public function index()
    {
        $hoje = Carbon::today();
        $mesAtual = Carbon::now()->startOfMonth();
        
        // Estatísticas do dia
        $coletasHoje = Coleta::whereDate('created_at', $hoje)->count();
        $empacotamentosHoje = Empacotamento::whereDate('created_at', $hoje)->count();
        $pesoTotalHoje = Coleta::whereDate('created_at', $hoje)->sum('peso_total');
        $valorTotalHoje = Coleta::whereDate('created_at', $hoje)->sum('valor_total');
        
        // Estatísticas do mês
        $coletasMes = Coleta::where('created_at', '>=', $mesAtual)->count();
        $empacotamentosMes = Empacotamento::where('created_at', '>=', $mesAtual)->count();
        $pesoTotalMes = Coleta::where('created_at', '>=', $mesAtual)->sum('peso_total');
        $valorTotalMes = Coleta::where('created_at', '>=', $mesAtual)->sum('valor_total');
        
        // Coletas recentes
        $coletasRecentes = Coleta::with(['estabelecimento', 'status'])
                                ->orderBy('created_at', 'desc')
                                ->limit(5)
                                ->get();
        
        // Empacotamentos pendentes
        $empacotamentosPendentes = Empacotamento::with(['coleta.estabelecimento', 'status'])
                                               ->whereHas('status', function($query) {
                                                   $query->whereIn('nome', ['Aguardando empacotamento', 'Em empacotamento', 'Pronto para entrega']);
                                               })
                                               ->orderBy('created_at', 'asc')
                                               ->limit(5)
                                               ->get();
        
        // Estatísticas gerais
        $totalEstabelecimentos = Estabelecimento::where('ativo', true)->count();
        $totalUsuarios = Usuario::where('ativo', true)->count();
        
        return view('painel.index', compact(
            'coletasHoje',
            'empacotamentosHoje',
            'pesoTotalHoje',
            'valorTotalHoje',
            'coletasMes',
            'empacotamentosMes',
            'pesoTotalMes',
            'valorTotalMes',
            'coletasRecentes',
            'empacotamentosPendentes',
            'totalEstabelecimentos',
            'totalUsuarios'
        ));
    }
}
