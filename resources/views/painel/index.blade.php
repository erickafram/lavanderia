@extends('layouts.app')

@section('title', 'Dashboard - Sistema de Gestão de Lavanderia')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
    <div>
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">
            <svg class="inline w-5 h-5 sm:w-6 sm:h-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v3H8V5z"></path>
            </svg>
            Dashboard
        </h1>
        <p class="text-sm text-gray-600">Visão geral do sistema de gestão de lavanderia</p>
    </div>
    <div class="flex items-center bg-white px-3 py-2 rounded-lg shadow-sm border mt-3 sm:mt-0">
        <svg class="w-4 h-4 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1M8 7h8m-8 0H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V9a2 2 0 00-2-2h-2"></path>
        </svg>
        <span class="text-sm text-gray-700 font-medium">{{ date('d/m/Y') }}</span>
    </div>
</div>

<!-- Cards de estatísticas do dia -->
<div class="mb-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Estatísticas de Hoje</h2>
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        <!-- Coletas Hoje -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 sm:p-4 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-medium text-gray-600 uppercase tracking-wide truncate">Coletas Hoje</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900 mt-1">{{ $coletasHoje }}</p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-blue-100 rounded-lg flex items-center justify-center ml-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Empacotamentos Hoje -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 sm:p-4 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-medium text-gray-600 uppercase tracking-wide truncate">Empacotamentos</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900 mt-1">{{ $empacotamentosHoje }}</p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-green-100 rounded-lg flex items-center justify-center ml-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Peso Total Hoje -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 sm:p-4 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-medium text-gray-600 uppercase tracking-wide truncate">Peso (kg)</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900 mt-1">{{ number_format($pesoTotalHoje, 1, ',', '.') }}</p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-purple-100 rounded-lg flex items-center justify-center ml-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16l3-1m-3 1l-3-1"></path>
                    </svg>
                </div>
            </div>
        </div>
        <!-- Pesagens Hoje -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 sm:p-4 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-medium text-gray-600 uppercase tracking-wide truncate">Pesagens</p>
                    <p class="text-lg sm:text-xl font-bold text-gray-900 mt-1">{{ $pesagensHoje }}</p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-yellow-100 rounded-lg flex items-center justify-center ml-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cards de estatísticas do mês -->
<div class="mb-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Estatísticas do Mês</h2>
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        <!-- Coletas do Mês -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 sm:p-4 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-medium text-gray-600 uppercase tracking-wide truncate">Coletas Mês</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900 mt-1">{{ $coletasMes }}</p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-indigo-100 rounded-lg flex items-center justify-center ml-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1M8 7h8m-8 0H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V9a2 2 0 00-2-2h-2"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Empacotamentos do Mês -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 sm:p-4 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-medium text-gray-600 uppercase tracking-wide truncate">Empac. Mês</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900 mt-1">{{ $empacotamentosMes }}</p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-teal-100 rounded-lg flex items-center justify-center ml-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Peso Total do Mês -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 sm:p-4 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-medium text-gray-600 uppercase tracking-wide truncate">Peso Mês</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900 mt-1">{{ number_format($pesoTotalMes, 1, ',', '.') }}</p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-pink-100 rounded-lg flex items-center justify-center ml-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16l3-1m-3 1l-3-1"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Faturamento do Mês -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 sm:p-4 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-medium text-gray-600 uppercase tracking-wide truncate">Pesag. Mês</p>
                    <p class="text-lg sm:text-xl font-bold text-gray-900 mt-1">{{ $pesagensMes }}</p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-emerald-100 rounded-lg flex items-center justify-center ml-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Tabelas de dados recentes -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
    <!-- Coletas Recentes -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between p-4 border-b border-gray-100">
            <h3 class="text-base font-semibold text-gray-900">Coletas Recentes</h3>
            <a href="{{ route('coletas.index') }}" class="inline-flex items-center px-3 py-1.5 bg-primary-600 hover:bg-primary-700 text-white text-xs font-medium rounded-lg transition-colors duration-200">
                Ver Todas
                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
        <div class="p-4">
            @if($coletasRecentes->count() > 0)
                <div class="space-y-3">
                    @foreach($coletasRecentes as $coleta)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-900 truncate">#{{ $coleta->numero_coleta }}</p>
                                    <p class="text-xs text-gray-600 truncate">{{ Str::limit($coleta->estabelecimento->razao_social, 20) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-right ml-2">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium" style="background-color: {{ $coleta->status->cor }}20; color: {{ $coleta->status->cor }}">
                                {{ Str::limit($coleta->status->nome, 10) }}
                            </span>
                            <p class="text-xs text-gray-500 mt-1">{{ $coleta->created_at->format('d/m') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-6">
                    <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm text-gray-500">Nenhuma coleta encontrada</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Empacotamentos Pendentes -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between p-4 border-b border-gray-100">
            <h3 class="text-base font-semibold text-gray-900">Empacotamentos Pendentes</h3>
            <a href="{{ route('empacotamento.index') }}" class="inline-flex items-center px-3 py-1.5 bg-primary-600 hover:bg-primary-700 text-white text-xs font-medium rounded-lg transition-colors duration-200">
                Ver Todos
                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
        <div class="p-4">
            @if($empacotamentosPendentes->count() > 0)
                <div class="space-y-3">
                    @foreach($empacotamentosPendentes as $empacotamento)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $empacotamento->codigo_qr }}</p>
                                    <p class="text-xs text-gray-600 truncate">{{ Str::limit($empacotamento->coleta->estabelecimento->razao_social, 20) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-right ml-2">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium" style="background-color: {{ $empacotamento->status->cor }}20; color: {{ $empacotamento->status->cor }}">
                                {{ Str::limit($empacotamento->status->nome, 10) }}
                            </span>
                            <p class="text-xs text-gray-500 mt-1">{{ $empacotamento->created_at->format('d/m') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-6">
                    <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <p class="text-sm text-gray-500">Nenhum empacotamento pendente</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Acompanhamento de Coleta -->
<div class="mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
            </svg>
            Acompanhar Coleta
        </h2>

        <!-- Tabs -->
        <div class="mb-4">
            <nav class="flex space-x-4" aria-label="Tabs">
                <button onclick="mostrarTabAcompanhamento('lista')" id="tab-lista"
                        class="tab-acompanhamento active px-3 py-2 text-sm font-medium rounded-md bg-blue-100 text-blue-700">
                    Lista de Coletas
                </button>
                <button onclick="mostrarTabAcompanhamento('busca')" id="tab-busca"
                        class="tab-acompanhamento px-3 py-2 text-sm font-medium rounded-md text-gray-500 hover:text-gray-700">
                    Buscar por Número
                </button>
            </nav>
        </div>

        <!-- Tab: Lista de Coletas -->
        <div id="content-lista" class="tab-acompanhamento-content">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                @foreach($coletasAcompanhamento as $coleta)
                    @php
                        $progresso = [
                            'coleta' => ['concluida' => true],
                            'pesagem' => ['concluida' => $coleta->pesagens->count() > 0],
                            'empacotamento' => ['concluida' => $coleta->empacotamento !== null],
                            'entrega' => ['concluida' => $coleta->empacotamento && $coleta->empacotamento->status->nome === 'Entregue']
                        ];
                        $etapasConcluidas = collect($progresso)->where('concluida', true)->count();
                        $percentual = round(($etapasConcluidas / 4) * 100);
                    @endphp

                    <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow cursor-pointer"
                         onclick="acompanharColetaPorId('{{ $coleta->numero_coleta }}')">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $coleta->numero_coleta }}</h3>
                                <p class="text-sm text-gray-600">{{ Str::limit($coleta->estabelecimento->razao_social, 30) }}</p>
                                <p class="text-xs text-gray-500">{{ $coleta->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                  style="background-color: {{ $coleta->status->cor }}20; color: {{ $coleta->status->cor }};">
                                {{ $coleta->status->nome }}
                            </span>
                        </div>

                        <!-- Mini Progress Bar -->
                        <div class="mb-2">
                            <div class="flex justify-between text-xs text-gray-600 mb-1">
                                <span>Progresso</span>
                                <span>{{ $percentual }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentual }}%"></div>
                            </div>
                        </div>

                        <!-- Mini Status Icons -->
                        <div class="flex justify-between">
                            <div class="flex items-center text-xs {{ $progresso['coleta']['concluida'] ? 'text-green-600' : 'text-gray-400' }}">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Coleta
                            </div>
                            <div class="flex items-center text-xs {{ $progresso['pesagem']['concluida'] ? 'text-green-600' : 'text-gray-400' }}">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Pesagem
                            </div>
                            <div class="flex items-center text-xs {{ $progresso['empacotamento']['concluida'] ? 'text-green-600' : 'text-gray-400' }}">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Empac.
                            </div>
                            <div class="flex items-center text-xs {{ $progresso['entrega']['concluida'] ? 'text-green-600' : 'text-gray-400' }}">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Entrega
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Tab: Buscar por Número -->
        <div id="content-busca" class="tab-acompanhamento-content hidden">
            <div class="flex gap-4 mb-4">
                <div class="flex-1">
                    <input type="text" id="numeroColeta"
                           placeholder="Digite o número da coleta (ex: COL000001)"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <button onclick="acompanharColeta()"
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Buscar
                </button>
            </div>
        </div>

        <!-- Resultado do Acompanhamento -->
        <div id="resultadoAcompanhamento" style="display: none;" class="border-t pt-4">
            <div id="infoColeta" class="mb-4">
                <!-- Informações da coleta serão inseridas aqui -->
            </div>

            <!-- Progress Bar -->
            <div class="mb-4">
                <div class="flex items-center justify-between text-sm font-medium text-gray-700 mb-2">
                    <span>Progresso da Coleta</span>
                    <span id="progressoPercentual">0%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div id="barraProgresso" class="bg-blue-600 h-2 rounded-full transition-all duration-500" style="width: 0%"></div>
                </div>
            </div>

            <!-- Etapas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div id="etapa-coleta" class="etapa-item">
                    <div class="flex items-center p-3 rounded-lg border">
                        <div class="etapa-icon w-8 h-8 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-sm">Coleta</p>
                            <p class="text-xs text-gray-500" id="data-coleta">-</p>
                        </div>
                    </div>
                </div>

                <div id="etapa-pesagem" class="etapa-item">
                    <div class="flex items-center p-3 rounded-lg border">
                        <div class="etapa-icon w-8 h-8 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-sm">Pesagem</p>
                            <p class="text-xs text-gray-500" id="data-pesagem">-</p>
                        </div>
                    </div>
                </div>

                <div id="etapa-empacotamento" class="etapa-item">
                    <div class="flex items-center p-3 rounded-lg border">
                        <div class="etapa-icon w-8 h-8 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-sm">Empacotamento</p>
                            <p class="text-xs text-gray-500" id="data-empacotamento">-</p>
                        </div>
                    </div>
                </div>

                <div id="etapa-entrega" class="etapa-item">
                    <div class="flex items-center p-3 rounded-lg border">
                        <div class="etapa-icon w-8 h-8 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-sm">Entrega</p>
                            <p class="text-xs text-gray-500" id="data-entrega">-</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Função para mostrar tabs do acompanhamento
function mostrarTabAcompanhamento(tabName) {
    // Esconder todos os conteúdos
    document.querySelectorAll('.tab-acompanhamento-content').forEach(content => {
        content.classList.add('hidden');
    });

    // Remover classe active de todos os botões
    document.querySelectorAll('.tab-acompanhamento').forEach(button => {
        button.classList.remove('active', 'bg-blue-100', 'text-blue-700');
        button.classList.add('text-gray-500');
    });

    // Mostrar conteúdo da tab selecionada
    document.getElementById('content-' + tabName).classList.remove('hidden');

    // Ativar botão da tab selecionada
    const activeButton = document.getElementById('tab-' + tabName);
    activeButton.classList.add('active', 'bg-blue-100', 'text-blue-700');
    activeButton.classList.remove('text-gray-500');
}

// Função para acompanhar coleta por ID (clique no card)
function acompanharColetaPorId(numeroColeta) {
    fetch('{{ route("acompanhar-coleta") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ numero_coleta: numeroColeta })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarProgresso(data.coleta, data.progresso);
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao buscar coleta');
    });
}

// Função para acompanhar coleta por busca manual
function acompanharColeta() {
    const numeroColeta = document.getElementById('numeroColeta').value.trim();

    if (!numeroColeta) {
        alert('Digite o número da coleta');
        return;
    }

    fetch('{{ route("acompanhar-coleta") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ numero_coleta: numeroColeta })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarProgresso(data.coleta, data.progresso);
        } else {
            alert(data.message);
            document.getElementById('resultadoAcompanhamento').style.display = 'none';
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao buscar coleta');
    });
}

function mostrarProgresso(coleta, progresso) {
    // Mostrar seção de resultado
    document.getElementById('resultadoAcompanhamento').style.display = 'block';

    // Informações da coleta
    document.getElementById('infoColeta').innerHTML = `
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h3 class="font-semibold text-blue-900">${coleta.numero_coleta}</h3>
            <p class="text-blue-700">${coleta.estabelecimento.razao_social}</p>
            <p class="text-sm text-blue-600">Peso: ${coleta.peso_total}kg | Status: ${coleta.status.nome}</p>
        </div>
    `;

    // Calcular progresso
    let etapasConcluidas = 0;
    const totalEtapas = 4;

    // Atualizar etapas
    atualizarEtapa('coleta', progresso.coleta.concluida, progresso.coleta.data);
    if (progresso.coleta.concluida) etapasConcluidas++;

    atualizarEtapa('pesagem', progresso.pesagem.concluida, progresso.pesagem.data);
    if (progresso.pesagem.concluida) etapasConcluidas++;

    atualizarEtapa('empacotamento', progresso.empacotamento.concluida, progresso.empacotamento.data);
    if (progresso.empacotamento.concluida) etapasConcluidas++;

    atualizarEtapa('entrega', progresso.entrega.concluida, progresso.entrega.data);
    if (progresso.entrega.concluida) etapasConcluidas++;

    // Atualizar barra de progresso
    const percentual = Math.round((etapasConcluidas / totalEtapas) * 100);
    document.getElementById('progressoPercentual').textContent = percentual + '%';
    document.getElementById('barraProgresso').style.width = percentual + '%';
}

function atualizarEtapa(etapa, concluida, data) {
    const elemento = document.getElementById('etapa-' + etapa);
    const icone = elemento.querySelector('.etapa-icon');
    const dataElemento = document.getElementById('data-' + etapa);

    if (concluida) {
        icone.classList.add('bg-green-100', 'text-green-600');
        icone.classList.remove('bg-gray-100', 'text-gray-400');
        elemento.classList.add('border-green-200');
        elemento.classList.remove('border-gray-200');

        if (data) {
            const dataFormatada = new Date(data).toLocaleDateString('pt-BR', {
                day: '2-digit',
                month: '2-digit',
                hour: '2-digit',
                minute: '2-digit'
            });
            dataElemento.textContent = dataFormatada;
        } else {
            dataElemento.textContent = 'Concluído';
        }
    } else {
        icone.classList.add('bg-gray-100', 'text-gray-400');
        icone.classList.remove('bg-green-100', 'text-green-600');
        elemento.classList.add('border-gray-200');
        elemento.classList.remove('border-green-200');
        dataElemento.textContent = 'Pendente';
    }
}

// Event listener para Enter no campo de busca
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('numeroColeta').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            acompanharColeta();
        }
    });
});
</script>

<style>
.etapa-item {
    transition: all 0.3s ease;
}

.etapa-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.tab-acompanhamento {
    transition: all 0.2s ease;
}

.tab-acompanhamento:hover {
    background-color: #f3f4f6;
}

.tab-acompanhamento.active {
    background-color: #dbeafe !important;
    color: #1d4ed8 !important;
}

/* Cards de coleta hover */
.bg-white:hover {
    transform: translateY(-1px);
}
</style>
@endpush
