@extends('layouts.app')

@section('title', 'Dashboard - Sistema de Gestão de Lavanderia')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-calendar me-1"></i>{{ date('d/m/Y') }}
            </button>
        </div>
    </div>
</div>

<!-- Cards de estatísticas do dia -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Coletas Hoje
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $coletasHoje }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-truck fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Empacotamentos Hoje
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $empacotamentosHoje }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Peso Total Hoje (kg)
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($pesoTotalHoje, 2, ',', '.') }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-weight fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Faturamento Hoje
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">R$ {{ number_format($valorTotalHoje, 2, ',', '.') }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cards de estatísticas do mês -->
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-3">Estatísticas do Mês</h4>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                            Coletas do Mês
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $coletasMes }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                            Empacotamentos do Mês
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $empacotamentosMes }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-boxes fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                            Peso Total do Mês (kg)
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($pesoTotalMes, 2, ',', '.') }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-balance-scale fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                            Faturamento do Mês
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">R$ {{ number_format($valorTotalMes, 2, ',', '.') }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabelas de dados recentes -->
<div class="row">
    <!-- Coletas Recentes -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Coletas Recentes</h6>
                <a href="{{ route('coletas.index') }}" class="btn btn-sm btn-primary">Ver Todas</a>
            </div>
            <div class="card-body">
                @if($coletasRecentes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Número</th>
                                    <th>Estabelecimento</th>
                                    <th>Status</th>
                                    <th>Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($coletasRecentes as $coleta)
                                <tr>
                                    <td>{{ $coleta->numero_coleta }}</td>
                                    <td>{{ Str::limit($coleta->estabelecimento->razao_social, 20) }}</td>
                                    <td>
                                        <span class="badge" style="background-color: {{ $coleta->status->cor }}">
                                            {{ $coleta->status->nome }}
                                        </span>
                                    </td>
                                    <td>{{ $coleta->created_at->format('d/m H:i') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center">Nenhuma coleta encontrada.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Empacotamentos Pendentes -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Empacotamentos Pendentes</h6>
                <a href="{{ route('empacotamento.index') }}" class="btn btn-sm btn-primary">Ver Todos</a>
            </div>
            <div class="card-body">
                @if($empacotamentosPendentes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Código QR</th>
                                    <th>Estabelecimento</th>
                                    <th>Status</th>
                                    <th>Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($empacotamentosPendentes as $empacotamento)
                                <tr>
                                    <td>{{ $empacotamento->codigo_qr }}</td>
                                    <td>{{ Str::limit($empacotamento->coleta->estabelecimento->razao_social, 20) }}</td>
                                    <td>
                                        <span class="badge" style="background-color: {{ $empacotamento->status->cor }}">
                                            {{ $empacotamento->status->nome }}
                                        </span>
                                    </td>
                                    <td>{{ $empacotamento->created_at->format('d/m H:i') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center">Nenhum empacotamento pendente.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
.text-xs {
    font-size: 0.7rem;
}
</style>
@endsection
