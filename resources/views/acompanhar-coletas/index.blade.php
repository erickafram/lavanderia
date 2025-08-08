@extends('layouts.app')

@section('title', 'Acompanhar Coletas - Sistema de Gestão de Lavanderia')

@section('content')
<!-- Header da Página -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
    <div>
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1 flex items-center">
            <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-blue-700 rounded-lg flex items-center justify-center mr-2">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
            </div>
            Acompanhar Coletas
        </h1>
        <p class="text-sm text-gray-600">Monitore o progresso de todas as suas coletas</p>
    </div>
    <div class="flex items-center space-x-2 mt-3 sm:mt-0">
        <div class="flex items-center space-x-1">
            <div id="realtime-indicator" class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
            <span class="text-xs text-green-600 font-medium">Tempo Real</span>
        </div>
        <span id="last-update" class="text-xs text-gray-500">Última atualização: {{ now()->format('H:i:s') }}</span>
    </div>
</div>


<!-- Cards de Estatísticas -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <!-- Total de Coletas -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-lg p-4 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-xs font-medium">Total de Coletas</p>
                <p class="text-2xl font-bold" data-card="total-coletas">{{ number_format($totalColetas) }}</p>
            </div>
            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Em Andamento -->
    <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg shadow-lg p-4 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-orange-100 text-xs font-medium">Em Andamento</p>
                <p class="text-2xl font-bold" data-card="total-andamento">{{ number_format($totalAndamento) }}</p>
                <p class="text-orange-200 text-xs mt-1">{{ number_format($coletasAndamento->count()) }} este mês</p>
            </div>
            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Concluídas -->
    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-lg p-4 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-xs font-medium">Concluídas</p>
                <p class="text-2xl font-bold" data-card="total-concluidas">{{ number_format($totalConcluidas) }}</p>
                <p class="text-green-200 text-xs mt-1">{{ number_format($coletasConcluidas->count()) }} este mês</p>
            </div>
            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Seção de Busca -->
<div class="bg-white rounded-lg shadow-lg border border-gray-100 p-4 mb-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
        <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
        Buscar Coleta
    </h2>
    
    <div class="flex gap-3">
        <div class="flex-1 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input type="text" id="numeroColeta"
                   placeholder="Digite o número da coleta (ex: COL000001)"
                   class="w-full pl-10 pr-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
        </div>
        <button onclick="acompanharColeta()"
                class="px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm font-semibold rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg">
            <svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            Buscar
        </button>
    </div>
</div>

<!-- Resultado do Acompanhamento -->
<div id="resultadoAcompanhamento" class="hidden bg-white rounded-xl shadow-lg border border-gray-100 p-4 mb-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
            </svg>
            Detalhes da Coleta
        </h3>
        <button onclick="fecharResultado()" class="text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Conteúdo do resultado será inserido aqui -->
    <div id="conteudoResultado"></div>
</div>

<!-- Grid de Coletas Recentes -->
<div class="bg-white rounded-lg shadow-lg border border-gray-100 p-4">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-900 flex items-center">
            <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
            Coletas do Mês
        </h2>
        <div class="flex items-center space-x-1 text-xs text-gray-500">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1M8 7h8m-8 0H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V9a2 2 0 00-2-2h-2"></path>
            </svg>
            <span>{{ now()->format('M/Y') }}</span>
        </div>
    </div>

    <!-- Tabs para filtrar por status -->
    <div class="mb-4">
        <nav class="flex space-x-3" aria-label="Tabs">
            <button onclick="mostrarAba('andamento')" id="tab-andamento"
                    class="tab-coletas active px-3 py-2 text-xs font-medium rounded-lg bg-orange-100 text-orange-700 border border-orange-200">
                <svg class="w-3 h-3 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Em Andamento ({{ $coletasAndamento->count() }})
            </button>
            <button onclick="mostrarAba('concluidas')" id="tab-concluidas"
                    class="tab-coletas px-3 py-2 text-xs font-medium rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 border border-gray-200">
                <svg class="w-3 h-3 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Concluídas ({{ $coletasConcluidas->count() }})
            </button>
        </nav>
    </div>

    <!-- Aba: Em Andamento -->
    <div id="aba-andamento" class="tab-content">
        @if($coletasAndamento->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4" id="coletas-grid-andamento">
                @foreach($coletasAndamento as $coleta)
                @php
                    // Calcular progresso e tempos
                    $dataColeta = $coleta->created_at;
                    $dataPesagem = $coleta->pesagens->first()?->created_at;
                    $dataEmpacotamento = $coleta->empacotamento?->data_empacotamento;
                    $dataEntrega = $coleta->empacotamento?->entrega?->data_entrega;

                    // Verificar status do empacotamento e entrega
                    $statusEmpacotamento = $coleta->empacotamento?->status->nome;
                    $entrega = $coleta->empacotamento?->entrega;
                    $statusEntrega = $entrega?->status->nome;
                    
                    // Considerar entrega concluída quando está em trânsito ou entregue
                    $entregaConcluida = false;
                    if ($statusEmpacotamento && in_array($statusEmpacotamento, ['Em trânsito', 'Entregue'])) {
                        $entregaConcluida = true;
                    } elseif ($entrega && in_array($statusEntrega, ['Em trânsito', 'Entregue', 'Confirmado pelo Cliente'])) {
                        $entregaConcluida = true;
                    }
                    
                    $confirmacaoConcluida = $entrega && in_array($statusEntrega, ['Entregue', 'Confirmado pelo Cliente']);

                    $progresso = [
                        'coleta' => ['concluida' => true],
                        'pesagem' => ['concluida' => $coleta->pesagens->count() > 0],
                        'empacotamento' => ['concluida' => $coleta->empacotamento !== null],
                        'entrega' => ['concluida' => $entregaConcluida],
                        'confirmacao_cliente' => ['concluida' => $confirmacaoConcluida]
                    ];
                    $etapasConcluidas = collect($progresso)->where('concluida', true)->count();
                    $percentual = round(($etapasConcluidas / 5) * 100);

                    // Calcular tempo total
                    $tempoTotal = null;
                    $dataConfirmacao = $entrega?->data_confirmacao_recebimento;

                    if ($dataConfirmacao) {
                        $diffMinutes = $dataColeta->diffInMinutes($dataConfirmacao);
                    } elseif ($entrega && $entrega->data_entrega) {
                        $diffMinutes = $dataColeta->diffInMinutes($entrega->data_entrega);
                    } else {
                        $diffMinutes = $dataColeta->diffInMinutes(now());
                    }

                    if ($diffMinutes < 60) {
                        $tempoTotal = $diffMinutes . 'm';
                    } elseif ($diffMinutes < 1440) {
                        $horas = floor($diffMinutes / 60);
                        $minutos = $diffMinutes % 60;
                        $tempoTotal = $horas . 'h ' . $minutos . 'm';
                    } else {
                        $dias = floor($diffMinutes / 1440);
                        $horasRestantes = floor(($diffMinutes % 1440) / 60);
                        $tempoTotal = $dias . 'd ' . $horasRestantes . 'h';
                    }
                @endphp

                                    <div class="bg-gradient-to-br from-gray-50 to-white border border-gray-200 rounded-xl p-4 hover:shadow-lg transition-all duration-300 cursor-pointer transform hover:scale-105"
                     data-coleta-id="{{ $coleta->id }}"
                     onclick="acompanharColetaPorId('{{ $coleta->numero_coleta }}')">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h3 class="text-base font-bold text-gray-900">{{ $coleta->numero_coleta }}</h3>
                            <p class="text-sm text-gray-600">{{ Str::limit($coleta->estabelecimento->razao_social, 25) }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $coleta->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200" data-percentual>
                                {{ $percentual }}%
                            </span>
                        </div>
                    </div>

                    <!-- Status Atual -->
                    <div class="mb-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium"
                              data-status
                              style="background-color: {{ $coleta->status->cor }}20; color: {{ $coleta->status->cor }};">
                            {{ $coleta->status->nome }}
                        </span>
                    </div>

                    <!-- Tempo Total -->
                    @if($tempoTotal)
                    <div class="mb-3 flex items-center text-xs text-blue-600 bg-blue-50 rounded-lg p-2">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium">{{ $tempoTotal }}</span>
                    </div>
                    @endif

                    <!-- Barra de Progresso -->
                    <div class="mb-3">
                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                            <span>Progresso</span>
                            <span data-etapas>{{ $etapasConcluidas }}/5</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full transition-all duration-500" style="width: {{ $percentual }}%"></div>
                        </div>
                    </div>

                    <!-- Mini Etapas -->
                    <div class="grid grid-cols-5 gap-1">
                        <div class="flex flex-col items-center text-xs {{ $progresso['coleta']['concluida'] ? 'text-green-600' : 'text-gray-400' }}">
                            <div class="w-5 h-5 rounded-full flex items-center justify-center {{ $progresso['coleta']['concluida'] ? 'bg-green-100' : 'bg-gray-100' }} mb-1" data-etapa="coleta">
                                <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-xs">Col.</span>
                        </div>
                        <div class="flex flex-col items-center text-xs {{ $progresso['pesagem']['concluida'] ? 'text-green-600' : 'text-gray-400' }}">
                            <div class="w-5 h-5 rounded-full flex items-center justify-center {{ $progresso['pesagem']['concluida'] ? 'bg-green-100' : 'bg-gray-100' }} mb-1" data-etapa="pesagem">
                                <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-xs">Pes.</span>
                        </div>
                        <div class="flex flex-col items-center text-xs {{ $progresso['empacotamento']['concluida'] ? 'text-green-600' : 'text-gray-400' }}">
                            <div class="w-5 h-5 rounded-full flex items-center justify-center {{ $progresso['empacotamento']['concluida'] ? 'bg-green-100' : 'bg-gray-100' }} mb-1" data-etapa="empacotamento">
                                <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-xs">Emp.</span>
                        </div>
                        <div class="flex flex-col items-center text-xs {{ $progresso['entrega']['concluida'] ? 'text-green-600' : 'text-gray-400' }}">
                            <div class="w-5 h-5 rounded-full flex items-center justify-center {{ $progresso['entrega']['concluida'] ? 'bg-green-100' : 'bg-gray-100' }} mb-1" data-etapa="entrega">
                                <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-xs">Trân.</span>
                        </div>
                        <div class="flex flex-col items-center text-xs {{ $progresso['confirmacao_cliente']['concluida'] ? 'text-green-600' : 'text-gray-400' }}">
                            <div class="w-5 h-5 rounded-full flex items-center justify-center {{ $progresso['confirmacao_cliente']['concluida'] ? 'bg-green-100' : 'bg-gray-100' }} mb-1" data-etapa="confirmacao_cliente">
                                <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-xs">Entr.</span>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-orange-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Nenhuma coleta em andamento</h3>
                <p class="text-gray-500">Não há coletas em andamento este mês.</p>
            </div>
        @endif
    </div>

    <!-- Aba: Concluídas -->
    <div id="aba-concluidas" class="tab-content hidden">
        @if($coletasConcluidas->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4" id="coletas-grid-concluidas">
                @foreach($coletasConcluidas as $coleta)
                    @php
                        // Calcular progresso e tempos
                        $dataColeta = $coleta->created_at;
                        $dataPesagem = $coleta->pesagens->first()?->created_at;
                        $dataEmpacotamento = $coleta->empacotamento?->data_empacotamento;
                        $dataEntrega = $coleta->empacotamento?->entrega?->data_entrega;

                        // Verificar status do empacotamento e entrega
                        $statusEmpacotamento = $coleta->empacotamento?->status->nome;
                        $entrega = $coleta->empacotamento?->entrega;
                        $statusEntrega = $entrega?->status->nome;
                        
                        // Considerar entrega concluída quando empacotamento está pronto, em trânsito ou entregue
                        $entregaConcluida = false;
                        if ($statusEmpacotamento && in_array($statusEmpacotamento, ['Pronto para entrega', 'Em trânsito', 'Entregue'])) {
                            $entregaConcluida = true;
                        } elseif ($entrega && in_array($statusEntrega, ['Em trânsito', 'Entregue', 'Confirmado pelo Cliente'])) {
                            $entregaConcluida = true;
                        }
                        
                        $confirmacaoConcluida = $entrega && in_array($statusEntrega, ['Entregue', 'Confirmado pelo Cliente']);

                        $progresso = [
                            'coleta' => ['concluida' => true],
                            'pesagem' => ['concluida' => $coleta->pesagens->count() > 0],
                            'empacotamento' => ['concluida' => $coleta->empacotamento !== null],
                            'entrega' => ['concluida' => $entregaConcluida],
                            'confirmacao_cliente' => ['concluida' => $confirmacaoConcluida]
                        ];
                        $etapasConcluidas = collect($progresso)->where('concluida', true)->count();
                        $percentual = round(($etapasConcluidas / 5) * 100);

                        // Calcular tempo total
                        $tempoTotal = null;
                        $dataConfirmacao = $entrega?->data_confirmacao_recebimento;

                        if ($dataConfirmacao) {
                            $diffMinutes = $dataColeta->diffInMinutes($dataConfirmacao);
                        } elseif ($entrega && $entrega->data_entrega) {
                            $diffMinutes = $dataColeta->diffInMinutes($entrega->data_entrega);
                        } else {
                            $diffMinutes = $dataColeta->diffInMinutes(now());
                        }

                        if ($diffMinutes < 60) {
                            $tempoTotal = $diffMinutes . 'm';
                        } elseif ($diffMinutes < 1440) {
                            $horas = floor($diffMinutes / 60);
                            $minutos = $diffMinutes % 60;
                            $tempoTotal = $horas . 'h ' . $minutos . 'm';
                        } else {
                            $dias = floor($diffMinutes / 1440);
                            $horasRestantes = floor(($diffMinutes % 1440) / 60);
                            $tempoTotal = $dias . 'd ' . $horasRestantes . 'h';
                        }
                    @endphp

                    <div class="bg-gradient-to-br from-green-50 to-white border border-green-200 rounded-xl p-4 hover:shadow-lg transition-all duration-300 cursor-pointer transform hover:scale-105"
                         data-coleta-id="{{ $coleta->id }}"
                         onclick="acompanharColetaPorId('{{ $coleta->numero_coleta }}')">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="text-base font-bold text-gray-900">{{ $coleta->numero_coleta }}</h3>
                                <p class="text-sm text-gray-600">{{ Str::limit($coleta->estabelecimento->razao_social, 25) }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $coleta->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                    <svg class="w-2.5 h-2.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Concluída
                                </span>
                            </div>
                        </div>

                        <!-- Status Atual -->
                        <div class="mb-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium"
                                  style="background-color: {{ $coleta->status->cor }}20; color: {{ $coleta->status->cor }};">
                                {{ $coleta->status->nome }}
                            </span>
                        </div>

                        <!-- Tempo Total -->
                        @if($tempoTotal)
                        <div class="mb-3 flex items-center text-xs text-green-600 bg-green-50 rounded-lg p-2">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium">{{ $tempoTotal }}</span>
                        </div>
                        @endif

                        <!-- Barra de Progresso Completa -->
                        <div class="mb-3">
                            <div class="flex justify-between text-xs text-gray-600 mb-1">
                                <span>Processo Completo</span>
                                <span>100%</span>
                            </div>
                            <div class="w-full bg-green-200 rounded-full h-2">
                                <div class="bg-gradient-to-r from-green-500 to-green-600 h-2 rounded-full transition-all duration-500" style="width: 100%"></div>
                            </div>
                        </div>

                        <!-- Mini Etapas -->
                        <div class="grid grid-cols-5 gap-1">
                            <div class="flex flex-col items-center text-xs text-green-600">
                                <div class="w-5 h-5 rounded-full flex items-center justify-center bg-green-100 mb-1">
                                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <span class="text-xs">Col.</span>
                            </div>
                            <div class="flex flex-col items-center text-xs text-green-600">
                                <div class="w-5 h-5 rounded-full flex items-center justify-center bg-green-100 mb-1">
                                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <span class="text-xs">Pes.</span>
                            </div>
                            <div class="flex flex-col items-center text-xs text-green-600">
                                <div class="w-5 h-5 rounded-full flex items-center justify-center bg-green-100 mb-1">
                                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <span class="text-xs">Emp.</span>
                            </div>
                            <div class="flex flex-col items-center text-xs text-green-600">
                                <div class="w-5 h-5 rounded-full flex items-center justify-center bg-green-100 mb-1">
                                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <span class="text-xs">Trân.</span>
                            </div>
                            <div class="flex flex-col items-center text-xs text-green-600">
                                <div class="w-5 h-5 rounded-full flex items-center justify-center bg-green-100 mb-1">
                                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <span class="text-xs">Entr.</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-green-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Nenhuma coleta concluída</h3>
                <p class="text-gray-500">Não há coletas concluídas este mês.</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
// Função para acompanhar coleta por busca
function acompanharColeta() {
    const numeroColeta = document.getElementById('numeroColeta').value.trim();

    if (!numeroColeta) {
        alert('Digite o número da coleta');
        return;
    }

    acompanharColetaPorId(numeroColeta);
}

// Função principal para acompanhar coleta
function acompanharColetaPorId(numeroColeta) {
    // Mostrar loading
    const resultado = document.getElementById('resultadoAcompanhamento');
    const conteudo = document.getElementById('conteudoResultado');
    
    conteudo.innerHTML = `
        <div class="flex items-center justify-center py-12">
            <div class="text-center">
                <svg class="animate-spin -ml-1 mr-3 h-8 w-8 text-blue-600 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="text-gray-600">Buscando informações da coleta...</p>
            </div>
        </div>
    `;
    
    resultado.classList.remove('hidden');
    
    // Scroll suave para o resultado
    resultado.scrollIntoView({ behavior: 'smooth', block: 'start' });

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
            conteudo.innerHTML = `
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-red-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Coleta não encontrada</h3>
                    <p class="text-gray-600">${data.message}</p>
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        conteudo.innerHTML = `
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-red-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Erro na busca</h3>
                <p class="text-gray-600">Ocorreu um erro ao buscar a coleta. Tente novamente.</p>
            </div>
        `;
    });
}

// Função para fechar resultado
function fecharResultado() {
    document.getElementById('resultadoAcompanhamento').classList.add('hidden');
}

// Função para mostrar progresso detalhado
function mostrarProgresso(coleta, progresso) {
    const conteudo = document.getElementById('conteudoResultado');
    
    // Calcular progresso
    let etapasConcluidas = 0;
    if (progresso.coleta.concluida) etapasConcluidas++;
    if (progresso.pesagem.concluida) etapasConcluidas++;
    if (progresso.empacotamento.concluida) etapasConcluidas++;
    if (progresso.entrega.concluida) etapasConcluidas++;
    if (progresso.confirmacao_cliente.concluida) etapasConcluidas++;
    
    const percentual = Math.round((etapasConcluidas / 5) * 100);
    
    conteudo.innerHTML = `
        <!-- Informações da Coleta -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-3 mb-3">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <div>
                    <h3 class="text-lg font-bold text-blue-900 mb-1">${coleta.numero_coleta}</h3>
                    <p class="text-blue-700 text-sm mb-1">${coleta.estabelecimento.razao_social}</p>
                    <p class="text-xs text-blue-600">Criada em: ${new Date(coleta.created_at).toLocaleDateString('pt-BR', {
                        day: '2-digit',
                        month: '2-digit', 
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    })}</p>
                </div>
                <div class="text-center">
                    <div class="text-xl font-bold text-blue-700 mb-1">${percentual}%</div>
                    <div class="text-xs text-blue-600">Concluído</div>
                    <div class="text-xs text-blue-500">${etapasConcluidas} de 5 etapas</div>
                </div>
                <div class="text-right">
                    ${progresso.tempo_total ? `
                        <div class="bg-white/60 rounded-lg p-2">
                            <div class="text-sm font-bold text-blue-800">${progresso.tempo_total}</div>
                            <div class="text-xs text-blue-600">desde o início</div>
                        </div>
                    ` : ''}
                </div>
            </div>
            
            <!-- Barra de Progresso -->
            <div class="mt-3">
                <div class="w-full bg-blue-200 rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 h-2 rounded-full transition-all duration-1000" style="width: ${percentual}%"></div>
                </div>
            </div>
        </div>

        <!-- Timeline das Etapas -->
        <div class="space-y-2">
            ${renderizarEtapa('Coleta Realizada', progresso.coleta, 'blue')}
            ${renderizarEtapa('Pesagem', progresso.pesagem, 'green')}
            ${renderizarEtapa('Empacotamento', progresso.empacotamento, 'purple')}
            ${renderizarEtapa('Em Trânsito', progresso.entrega, 'orange')}
            ${renderizarEtapa('Entregue', progresso.confirmacao_cliente, 'emerald', coleta)}
        </div>
    `;
}

// Função para renderizar cada etapa
function renderizarEtapa(titulo, etapa, cor, coleta = null) {
    const concluida = etapa.concluida;
    const dataFormatada = etapa.data ? new Date(etapa.data).toLocaleDateString('pt-BR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    }) : null;
    
    // Verificar se é a etapa "Entregue" e se tem assinatura
    const isEntregueWithSignature = titulo === 'Entregue' && concluida && coleta && 
                                    coleta.empacotamento && coleta.empacotamento.entrega && 
                                    coleta.empacotamento.entrega.assinatura_recebedor;
    
    return `
        <div class="flex items-center space-x-2 p-3 rounded-lg border transition-all duration-300 ${concluida ? 'bg-' + cor + '-50 border-' + cor + '-200' : 'bg-gray-50 border-gray-200'}">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 rounded-full flex items-center justify-center ${concluida ? 'bg-' + cor + '-500 text-white' : 'bg-gray-300 text-gray-500'}">
                    ${concluida ? `
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    ` : `
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    `}
                </div>
            </div>
            <div class="flex-1">
                <h4 class="text-sm font-semibold ${concluida ? 'text-' + cor + '-900' : 'text-gray-500'}">${titulo}</h4>
                <p class="text-xs ${concluida ? 'text-' + cor + '-700' : 'text-gray-500'}">
                    ${concluida ? (dataFormatada || 'Concluído') : 'Pendente'}
                </p>
                ${etapa.tempo_desde_inicio ? `
                    <p class="text-xs ${concluida ? 'text-' + cor + '-600' : 'text-gray-400'} mt-1">
                        ${etapa.tempo_desde_inicio} desde o início
                    </p>
                ` : ''}
                ${isEntregueWithSignature ? `
                    <button onclick="visualizarAssinatura('${coleta.empacotamento.entrega.assinatura_recebedor}', '${coleta.empacotamento.entrega.nome_recebedor || 'N/A'}')" 
                            class="mt-1 inline-flex items-center px-2 py-1 bg-${cor}-100 hover:bg-${cor}-200 text-${cor}-700 text-xs font-medium rounded-full transition-colors duration-200">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                        Ver Assinatura
                    </button>
                ` : ''}
            </div>
            <div class="flex-shrink-0">
                <div class="w-5 h-5 rounded-full ${concluida ? 'bg-' + cor + '-100' : 'bg-gray-100'} flex items-center justify-center">
                    ${concluida ? `
                        <svg class="w-3 h-3 text-${cor}-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    ` : `
                        <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                    `}
                </div>
            </div>
        </div>
    `;
}

// Função para controlar as abas
function mostrarAba(aba) {
    // Esconder todas as abas
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });

    // Remover classe active de todos os botões
    document.querySelectorAll('.tab-coletas').forEach(button => {
        button.classList.remove('active', 'bg-orange-100', 'text-orange-700', 'border-orange-200', 'bg-green-100', 'text-green-700', 'border-green-200');
        button.classList.add('text-gray-500', 'hover:text-gray-700', 'hover:bg-gray-100', 'border-gray-200');
    });

    // Mostrar aba selecionada
    document.getElementById('aba-' + aba).classList.remove('hidden');

    // Ativar botão da aba selecionada
    const activeButton = document.getElementById('tab-' + aba);
    activeButton.classList.remove('text-gray-500', 'hover:text-gray-700', 'hover:bg-gray-100', 'border-gray-200');
    
    if (aba === 'andamento') {
        activeButton.classList.add('active', 'bg-orange-100', 'text-orange-700', 'border-orange-200');
    } else {
        activeButton.classList.add('active', 'bg-green-100', 'text-green-700', 'border-green-200');
    }

    // Animar entrada dos cards
    const cards = document.querySelectorAll('#aba-' + aba + ' .grid > div');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.4s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 50);
    });
}

// Função para visualizar assinatura
function visualizarAssinatura(assinatura, nomeRecebedor) {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 flex items-center justify-center p-4';
    modal.innerHTML = `
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Assinatura do Recebedor</h3>
                    <button onclick="this.closest('.fixed').remove()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="text-center">
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-2">Recebido por:</p>
                        <p class="font-semibold text-gray-900">${nomeRecebedor}</p>
                    </div>
                    
                    <div class="border-2 border-gray-300 rounded-lg p-4 bg-gray-50">
                        <img src="${assinatura}" 
                             alt="Assinatura do recebedor" 
                             class="max-w-full max-h-32 mx-auto"
                             style="filter: invert(1) brightness(0);">
                    </div>
                    
                    <button onclick="this.closest('.fixed').remove()" 
                            class="mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    `;
    document.body.appendChild(modal);

    // Fechar com ESC
    modal.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            modal.remove();
        }
    });

    // Fechar clicando fora
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.remove();
        }
    });
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Enter no campo de busca
    document.getElementById('numeroColeta').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            acompanharColeta();
        }
    });

    // Real-time updates
    let realtimeInterval;

    function startRealtimeUpdates() {
        updateLastUpdateTime();
        realtimeInterval = setInterval(() => {
            updateLastUpdateTime();
            flashRealtimeIndicator();
        }, 30000);
    }

    function flashRealtimeIndicator() {
        const indicator = document.getElementById('realtime-indicator');
        if (indicator) {
            indicator.classList.remove('animate-pulse');
            indicator.classList.add('animate-ping');
            setTimeout(() => {
                indicator.classList.remove('animate-ping');
                indicator.classList.add('animate-pulse');
            }, 1000);
        }
    }

    function updateLastUpdateTime() {
        const lastUpdate = document.getElementById('last-update');
        if (lastUpdate) {
            const now = new Date();
            lastUpdate.textContent = 'Atualizado: ' + now.toLocaleTimeString('pt-BR');
        }
    }

    startRealtimeUpdates();

    // Animações de entrada
    const cards = document.querySelectorAll('#coletas-grid > div');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.4s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 50);
    });
});

// ============================================
// SISTEMA DE ATUALIZAÇÃO EM TEMPO REAL
// ============================================

let realtimeUpdateInterval;
let isUpdating = false;
let lastUpdateHash = '';

// Inicializar sistema de tempo real quando a página carregar
document.addEventListener('DOMContentLoaded', function() {
    iniciarAtualizacaoTempoReal();
    
    // Parar atualizações quando a página não estiver visível
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            pararAtualizacaoTempoReal();
        } else {
            iniciarAtualizacaoTempoReal();
        }
    });
});

// Função para iniciar atualizações automáticas
function iniciarAtualizacaoTempoReal() {
    if (realtimeUpdateInterval) {
        clearInterval(realtimeUpdateInterval);
    }
    
    // Atualizar a cada 10 segundos para detectar mudanças mais rapidamente
    realtimeUpdateInterval = setInterval(() => {
        atualizarDadosTempoReal();
    }, 10000);
    
    console.log('✅ Sistema de tempo real iniciado - Atualizações a cada 10s');
    atualizarIndicadorStatus('online');
    
    // Fazer primeira atualização imediatamente
    setTimeout(() => {
        atualizarDadosTempoReal();
    }, 1000);
}

// Função para parar atualizações automáticas
function pararAtualizacaoTempoReal() {
    if (realtimeUpdateInterval) {
        clearInterval(realtimeUpdateInterval);
        realtimeUpdateInterval = null;
    }
    console.log('⏸️ Sistema de tempo real pausado');
    atualizarIndicadorStatus('offline');
}

// Função principal de atualização
async function atualizarDadosTempoReal() {
    if (isUpdating) return; // Evitar múltiplas atualizações simultâneas
    
    isUpdating = true;
    atualizarIndicadorStatus('updating');
    
    try {
        const response = await fetch('{{ route("acompanhar-coletas") }}?ajax=1&_token={{ csrf_token() }}', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}`);
        }
        
        const data = await response.json();
        
        // Verificar mudanças mais específicas
        const hasChanges = verificarMudancasProgresso(data);
        if (hasChanges) {
            await atualizarInterface(data);
            console.log('🔄 Progresso das coletas atualizado');
            mostrarNotificacaoAtualizacao();
        }
        
        atualizarIndicadorStatus('online');
        atualizarTimestamp();
        
    } catch (error) {
        console.error('❌ Erro na atualização em tempo real:', error);
        atualizarIndicadorStatus('error');
    } finally {
        isUpdating = false;
    }
}

// Função para verificar mudanças específicas no progresso
function verificarMudancasProgresso(novosDados) {
    const coletasAtuais = document.querySelectorAll('[data-coleta-id]');
    
    // Se não há coletas na tela, sempre atualizar
    if (coletasAtuais.length === 0) return true;
    
    let temMudancas = false;
    
    // Verificar mudanças nas coletas em andamento
    if (novosDados.coletasAndamento) {
        for (const coleta of novosDados.coletasAndamento) {
            const cardExistente = document.querySelector(`[data-coleta-id="${coleta.id}"]`);
            if (cardExistente) {
                // Verificar percentual
                const percentualAtual = cardExistente.querySelector('[data-percentual]')?.textContent || '0%';
                const novoPercentual = `${coleta.percentual}%`;
                
                // Verificar etapas
                const etapasAtuais = cardExistente.querySelector('[data-etapas]')?.textContent || '0/5';
                const novasEtapas = `${coleta.etapas_concluidas}/5`;
                
                // Verificar status
                const statusAtual = cardExistente.querySelector('[data-status]')?.textContent?.trim() || '';
                const novoStatus = coleta.status;
                
                if (percentualAtual !== novoPercentual || etapasAtuais !== novasEtapas || statusAtual !== novoStatus) {
                    console.log(`📊 Mudança detectada na coleta ${coleta.numero_coleta}:`, {
                        percentual: { atual: percentualAtual, novo: novoPercentual },
                        etapas: { atual: etapasAtuais, novo: novasEtapas },
                        status: { atual: statusAtual, novo: novoStatus }
                    });
                    temMudancas = true;
                    break;
                }
            } else {
                // Nova coleta adicionada
                temMudancas = true;
                break;
            }
        }
    }
    
    // Verificar mudanças nas coletas concluídas
    if (!temMudancas && novosDados.coletasConcluidas) {
        const coletasConcluidas = novosDados.coletasConcluidas.length;
        const coletasConcluidasAtuais = document.querySelectorAll('#aba-concluidas [data-coleta-id]').length;
        
        if (coletasConcluidas !== coletasConcluidasAtuais) {
            console.log(`📋 Mudança no número de coletas concluídas: ${coletasConcluidasAtuais} → ${coletasConcluidas}`);
            temMudancas = true;
        }
    }
    
    return temMudancas;
}

// Função para atualizar a interface com novos dados
async function atualizarInterface(data) {
    // Atualizar cards de estatísticas com animação
    await atualizarCards(data);
    
    // Atualizar abas de coletas
    await atualizarAbasColetas(data);
    
    // Animar mudanças
    adicionarAnimacaoAtualizacao();
}

// Atualizar cards de estatísticas
function atualizarCards(data) {
    return new Promise(resolve => {
        const cards = [
            { id: 'total-coletas', valor: data.totalColetas },
            { id: 'total-andamento', valor: data.totalAndamento },
            { id: 'total-concluidas', valor: data.totalConcluidas }
        ];
        
        cards.forEach((card, index) => {
            setTimeout(() => {
                const elemento = document.querySelector(`[data-card="${card.id}"]`) || 
                                document.querySelector('.text-2xl.font-bold');
                if (elemento) {
                    elemento.style.transform = 'scale(1.05)';
                    setTimeout(() => {
                        elemento.textContent = new Intl.NumberFormat('pt-BR').format(card.valor);
                        elemento.style.transform = 'scale(1)';
                    }, 150);
                }
            }, index * 100);
        });
        
        setTimeout(resolve, 500);
    });
}

// Atualizar abas de coletas
function atualizarAbasColetas(data) {
    return new Promise(resolve => {
        // Atualizar contadores das tabs
        const tabAndamento = document.getElementById('tab-andamento');
        const tabConcluidas = document.getElementById('tab-concluidas');
        
        if (tabAndamento) {
            const textoAtual = tabAndamento.textContent;
            const novoTexto = textoAtual.replace(/\(\d+\)/, `(${data.coletasAndamento.length})`);
            tabAndamento.innerHTML = tabAndamento.innerHTML.replace(/\(\d+\)/, `(${data.coletasAndamento.length})`);
        }
        
        if (tabConcluidas) {
            const textoAtual = tabConcluidas.textContent;
            const novoTexto = textoAtual.replace(/\(\d+\)/, `(${data.coletasConcluidas.length})`);
            tabConcluidas.innerHTML = tabConcluidas.innerHTML.replace(/\(\d+\)/, `(${data.coletasConcluidas.length})`);
        }
        
        // Atualizar grids se necessário
        atualizarGridColetas('andamento', data.coletasAndamento);
        atualizarGridColetas('concluidas', data.coletasConcluidas);
        
        resolve();
    });
}

// Atualizar grid específico de coletas
function atualizarGridColetas(tipo, coletas) {
    const grid = document.getElementById(`coletas-grid-${tipo}`);
    if (!grid) return;
    
    // Verificar se há mudanças nos dados
    const coletasAtuais = grid.querySelectorAll('[data-coleta-id]');
    const idsAtuais = Array.from(coletasAtuais).map(el => el.getAttribute('data-coleta-id'));
    const idsNovos = coletas.map(c => c.id.toString());
    
    // Verificar mudanças de progresso/status mesmo se os IDs são os mesmos
    let temMudancas = idsAtuais.length !== idsNovos.length || 
                      !idsAtuais.every(id => idsNovos.includes(id));
    
    // Verificar mudanças no progresso das coletas existentes
    if (!temMudancas) {
        for (const coleta of coletas) {
            const cardExistente = grid.querySelector(`[data-coleta-id="${coleta.id}"]`);
            if (cardExistente) {
                const progressoAtual = cardExistente.querySelector('.bg-gradient-to-r')?.style?.width || '0%';
                const novoProgresso = `${coleta.percentual}%`;
                if (progressoAtual !== novoProgresso) {
                    temMudancas = true;
                    break;
                }
            }
        }
    }
    
    if (temMudancas) {
        console.log(`🔄 Atualizando grid ${tipo} - ${coletas.length} coletas`);
        
        // Atualizar cada coleta individualmente
        coletas.forEach(coleta => {
            let card = grid.querySelector(`[data-coleta-id="${coleta.id}"]`);
            
            if (card) {
                // Atualizar card existente
                atualizarCardColeta(card, coleta);
            } else {
                // Criar novo card
                const novoCard = criarCardColeta(coleta, tipo);
                grid.appendChild(novoCard);
                // Animação de entrada
                novoCard.style.opacity = '0';
                novoCard.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    novoCard.style.transition = 'all 0.3s ease';
                    novoCard.style.opacity = '1';
                    novoCard.style.transform = 'translateY(0)';
                }, 10);
            }
        });
        
        // Remover coletas que não estão mais na lista
        coletasAtuais.forEach(card => {
            const id = card.getAttribute('data-coleta-id');
            if (!idsNovos.includes(id)) {
                card.style.transition = 'all 0.3s ease';
                card.style.opacity = '0';
                card.style.transform = 'translateY(-20px)';
                setTimeout(() => card.remove(), 300);
            }
        });
    }
}

// Atualizar card existente com novos dados
function atualizarCardColeta(card, coleta) {
    console.log(`🔄 Atualizando card da coleta ${coleta.numero_coleta}`, coleta);
    
    // Atualizar barra de progresso
    const barraProgresso = card.querySelector('.bg-gradient-to-r');
    if (barraProgresso) {
        barraProgresso.style.width = `${coleta.percentual}%`;
        barraProgresso.style.transition = 'width 0.8s ease-in-out';
    }
    
    // Atualizar percentual
    const percentualElement = card.querySelector('[data-percentual]');
    if (percentualElement) {
        const percentualAnterior = percentualElement.textContent;
        percentualElement.textContent = `${coleta.percentual}%`;
        
        // Destacar mudança se houver
        if (percentualAnterior !== `${coleta.percentual}%`) {
            percentualElement.style.background = '#10B981';
            percentualElement.style.color = 'white';
            setTimeout(() => {
                percentualElement.style.background = '';
                percentualElement.style.color = '';
            }, 2000);
        }
    }
    
    // Atualizar etapas concluídas
    const etapasElement = card.querySelector('[data-etapas]');
    if (etapasElement) {
        etapasElement.textContent = `${coleta.etapas_concluidas}/5`;
    }
    
    // Atualizar status
    const statusElement = card.querySelector('[data-status]');
    if (statusElement) {
        statusElement.textContent = coleta.status;
        statusElement.style.backgroundColor = `${coleta.status_cor}20`;
        statusElement.style.color = coleta.status_cor;
    }
    
    // Atualizar mini etapas
    const miniEtapas = ['coleta', 'pesagem', 'empacotamento', 'entrega', 'confirmacao_cliente'];
    miniEtapas.forEach((etapa, index) => {
        const etapaElement = card.querySelector(`[data-etapa="${etapa}"]`);
        if (etapaElement) {
            const concluida = coleta.progresso[etapa];
            const estavaConcluida = etapaElement.classList.contains('bg-green-100');
            
            if (concluida && !estavaConcluida) {
                // Nova etapa concluída - animação especial
                etapaElement.className = 'w-5 h-5 rounded-full bg-green-100 flex items-center justify-center text-green-600 transition-all duration-500';
                etapaElement.innerHTML = '<svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>';
                
                // Efeito de pulso
                etapaElement.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    etapaElement.style.transform = 'scale(1)';
                }, 300);
            } else if (concluida) {
                etapaElement.className = 'w-5 h-5 rounded-full bg-green-100 flex items-center justify-center text-green-600';
                etapaElement.innerHTML = '<svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>';
            } else {
                etapaElement.className = 'w-5 h-5 rounded-full bg-gray-100 flex items-center justify-center text-gray-400';
                etapaElement.innerHTML = '<svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>';
            }
        }
    });
    
    // Animação de atualização sutil
    card.style.transition = 'all 0.3s ease';
    card.style.transform = 'scale(0.98)';
    setTimeout(() => {
        card.style.transform = 'scale(1)';
    }, 200);
}

// Criar novo card de coleta
function criarCardColeta(coleta, tipo) {
    const corFundo = tipo === 'concluidas' ? 'bg-gradient-to-br from-green-50 to-white border-green-200' : 'bg-white border-gray-200';
    
    const card = document.createElement('div');
    card.className = `${corFundo} rounded-xl shadow-sm border p-6 hover:shadow-md transition-all duration-300`;
    card.setAttribute('data-coleta-id', coleta.id);
    
    const miniEtapasHtml = ['coleta', 'pesagem', 'empacotamento', 'entrega', 'confirmacao_cliente'].map((etapa, index) => {
        const concluida = coleta.progresso[etapa];
        const classes = concluida 
            ? 'w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white text-xs font-medium'
            : 'w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-xs font-medium';
        const conteudo = concluida ? '✓' : (index + 1);
        return `<div class="${classes}" data-etapa="${etapa}">${conteudo}</div>`;
    }).join('');
    
    card.innerHTML = `
        <!-- Cabeçalho da Coleta -->
        <div class="flex justify-between items-start mb-4">
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">${coleta.numero_coleta}</h3>
                <p class="text-sm text-gray-600">${coleta.estabelecimento}</p>
                <p class="text-xs text-gray-500">${coleta.created_at}</p>
            </div>
            <div class="text-right">
                <div class="text-2xl font-bold text-blue-600 mb-1" data-percentual>${coleta.percentual}%</div>
                <div class="text-xs text-gray-500">Concluído</div>
            </div>
        </div>

        <!-- Status Atual -->
        <div class="mb-4">
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium" 
                  data-status 
                  style="background-color: ${coleta.status_cor}20; color: ${coleta.status_cor};">
                ${coleta.status}
            </span>
        </div>

        <!-- Barra de Progresso -->
        <div class="mb-4">
            <div class="flex justify-between text-xs text-gray-600 mb-2">
                <span>Progresso</span>
                <span data-etapas>${coleta.etapas_concluidas}/5</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2.5 rounded-full transition-all duration-500" style="width: ${coleta.percentual}%"></div>
            </div>
        </div>

        <!-- Mini Etapas -->
        <div class="grid grid-cols-5 gap-1">
            ${miniEtapasHtml}
        </div>
    `;
    
    return card;
}

// Atualizar indicador de status
function atualizarIndicadorStatus(status) {
    const indicador = document.getElementById('realtime-indicator');
    const texto = indicador?.nextElementSibling;
    
    if (!indicador) return;
    
    switch (status) {
        case 'online':
            indicador.className = 'w-2 h-2 bg-green-500 rounded-full animate-pulse';
            if (texto) texto.textContent = 'Tempo Real';
            break;
        case 'updating':
            indicador.className = 'w-2 h-2 bg-blue-500 rounded-full animate-spin';
            if (texto) texto.textContent = 'Atualizando...';
            break;
        case 'error':
            indicador.className = 'w-2 h-2 bg-red-500 rounded-full animate-pulse';
            if (texto) texto.textContent = 'Erro';
            break;
        case 'offline':
            indicador.className = 'w-2 h-2 bg-gray-400 rounded-full';
            if (texto) texto.textContent = 'Offline';
            break;
    }
}

// Atualizar timestamp
function atualizarTimestamp() {
    const timestamp = document.getElementById('last-update');
    if (timestamp) {
        const agora = new Date();
        const hora = agora.toLocaleTimeString('pt-BR', { 
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit' 
        });
        timestamp.textContent = `Última atualização: ${hora}`;
    }
}

// Adicionar animação de atualização
function adicionarAnimacaoAtualizacao() {
    const container = document.querySelector('.bg-white.rounded-lg.shadow-lg');
    if (container) {
        container.style.transform = 'scale(0.98)';
        container.style.transition = 'transform 0.2s ease';
        setTimeout(() => {
            container.style.transform = 'scale(1)';
        }, 200);
    }
}

// Função para forçar atualização manual
function forcarAtualizacao() {
    console.log('🔄 Atualização manual solicitada');
    atualizarDadosTempoReal();
}

// Função de debug para monitorar estado das coletas
function debugEstadoColetas() {
    const coletasAtuais = document.querySelectorAll('[data-coleta-id]');
    console.log('📊 Estado atual das coletas na tela:');
    coletasAtuais.forEach(card => {
        const id = card.getAttribute('data-coleta-id');
        const numero = card.querySelector('h3')?.textContent;
        const percentual = card.querySelector('[data-percentual]')?.textContent;
        const etapas = card.querySelector('[data-etapas]')?.textContent;
        const status = card.querySelector('[data-status]')?.textContent;
        
        console.log(`  • ${numero} (ID: ${id}): ${percentual} - ${etapas} etapas - Status: ${status}`);
    });
}

// Função para mostrar notificação de atualização
function mostrarNotificacaoAtualizacao() {
    // Remover notificação anterior se existir
    const notificacaoExistente = document.getElementById('notificacao-atualizacao');
    if (notificacaoExistente) {
        notificacaoExistente.remove();
    }
    
    // Criar nova notificação
    const notificacao = document.createElement('div');
    notificacao.id = 'notificacao-atualizacao';
    notificacao.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 flex items-center space-x-2 animate-pulse';
    notificacao.innerHTML = `
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
        </svg>
        <span class="text-sm font-medium">Coletas atualizadas</span>
    `;
    
    document.body.appendChild(notificacao);
    
    // Remover automaticamente após 3 segundos
    setTimeout(() => {
        if (notificacao && notificacao.parentNode) {
            notificacao.style.transition = 'all 0.3s ease';
            notificacao.style.opacity = '0';
            notificacao.style.transform = 'translateX(100%)';
            setTimeout(() => {
                notificacao.remove();
            }, 300);
        }
    }, 3000);
}

// Adicionar comando global para debug
window.debugColetas = debugEstadoColetas;
window.forcarAtualizacao = forcarAtualizacao;

// Adicionar botão de atualização manual (opcional)
window.addEventListener('load', function() {
    const headerDiv = document.querySelector('h2');
    if (headerDiv && headerDiv.textContent.includes('Coletas do Mês')) {
        const botaoAtualizar = document.createElement('button');
        botaoAtualizar.innerHTML = '🔄';
        botaoAtualizar.className = 'ml-2 p-1 text-xs text-gray-500 hover:text-blue-600 transition-colors';
        botaoAtualizar.title = 'Atualizar agora';
        botaoAtualizar.onclick = forcarAtualizacao;
        headerDiv.appendChild(botaoAtualizar);
    }
});

</script>

<style>
/* Animações customizadas */
#coletas-grid > div {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

#coletas-grid > div:hover {
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Gradiente animado */
.bg-gradient-to-r {
    background-size: 200% 100%;
    animation: gradient-shift 6s ease infinite;
}

@keyframes gradient-shift {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

/* Scrollbar customizada */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
}

::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Estilos das abas */
.tab-coletas {
    transition: all 0.2s ease;
}

.tab-coletas:hover {
    transform: translateY(-1px);
}

.tab-coletas.active {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Animação das abas */
.tab-content {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Cards das coletas concluídas */
#aba-concluidas .bg-gradient-to-br {
    background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%);
    border-color: #bbf7d0;
}

#aba-concluidas .bg-gradient-to-br:hover {
    background: linear-gradient(135deg, #ecfdf5 0%, #f9fafb 100%);
    border-color: #86efac;
}

/* Modal de assinatura */
.fixed.inset-0 {
    animation: modalFadeIn 0.3s ease-out;
}

@keyframes modalFadeIn {
    from {
        opacity: 0;
        backdrop-filter: blur(0px);
    }
    to {
        opacity: 1;
        backdrop-filter: blur(8px);
    }
}

/* Responsividade */
@media (max-width: 768px) {
    #coletas-grid-andamento,
    #coletas-grid-concluidas {
        grid-template-columns: 1fr;
    }
    
    .tab-coletas {
        font-size: 0.875rem;
        padding: 0.5rem 0.75rem;
    }
}
</style>
@endpush
