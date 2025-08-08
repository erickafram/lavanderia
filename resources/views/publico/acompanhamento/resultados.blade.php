@extends('layouts.public')

@section('title', 'Resultados da Busca')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50/30 to-purple-50/30">
    <!-- Header - Modern Design -->
    <div class="bg-white/80 backdrop-blur-sm shadow-lg border-b border-white/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between space-y-4 md:space-y-0">
                <div class="space-y-2">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                        </div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Resultados da Busca</h1>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="flex items-center space-x-2 bg-blue-100 rounded-full px-3 py-1">
                            <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                            <span class="text-sm font-medium text-blue-700">
                                {{ $coletas->count() }} coleta(s) encontrada(s)
                            </span>
                        </div>
                        <span class="text-gray-400">•</span>
                        <span class="text-gray-600 text-sm">
                            Termo: <strong class="text-gray-900">"{{ $termoBusca }}"</strong>
                        </span>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('acompanhamento.index') }}" 
                       class="glass-effect text-gray-700 hover:bg-white hover:bg-opacity-100 px-6 py-3 rounded-xl transition-all duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:scale-105">
                        <span class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <span>Nova Busca</span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Results -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($coletas as $coleta)
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-blue-200 transform hover:scale-[1.02] overflow-hidden">
                    <!-- Header do Card -->
                    <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-blue-50/30">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2 mb-2">
                                    <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg flex items-center justify-center">
                                        <span class="text-white text-xs font-bold">#</span>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900">
                                        {{ $coleta->numero_coleta }}
                                    </h3>
                                </div>
                                <p class="text-gray-600 text-sm font-medium">
                                    {{ $coleta->estabelecimento->razao_social }}
                                </p>
                            </div>
                            <div class="flex flex-col items-end space-y-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold shadow-sm"
                                      style="background-color: {{ $coleta->status->cor }}20; color: {{ $coleta->status->cor }};">
                                    {{ $coleta->status->nome }}
                                </span>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        @php
                            // Usar mesmo sistema de 5 etapas (20% cada)
                            $progressoEtapas = [
                                'coleta' => true, // Sempre concluída se existe
                                'pesagem' => $coleta->pesagens->count() > 0,
                                'empacotamento' => $coleta->empacotamentos->isNotEmpty(),
                                'entrega' => false,
                                'confirmacao_cliente' => false
                            ];

                            // Verificar entrega e confirmação
                            if($coleta->empacotamentos->isNotEmpty()) {
                                $statusEmpacotamento = $coleta->empacotamentos->first()->status->nome;
                                
                                // Entrega concluída se empacotamento está pronto, em trânsito ou entregue
                                if(in_array($statusEmpacotamento, ['Pronto para motorista', 'Em trânsito', 'Entregue'])) {
                                    $progressoEtapas['entrega'] = true;
                                }
                                
                                // Confirmação concluída se está entregue
                                if($statusEmpacotamento === 'Entregue') {
                                    $progressoEtapas['confirmacao_cliente'] = true;
                                }
                            }

                            // Calcular percentual: cada etapa vale 20%
                            $etapasConcluidas = collect($progressoEtapas)->filter()->count();
                            $progresso = round(($etapasConcluidas / 5) * 100);
                        @endphp

                        <div class="w-full bg-gray-200 rounded-full h-1.5 mb-2">
                            <div class="bg-gradient-to-r from-blue-500 to-green-500 h-1.5 rounded-full transition-all duration-500" 
                                 style="width: {{ $progresso }}%"></div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500 mb-2">
                            <span>{{ $etapasConcluidas }}/5 etapas</span>
                            <span class="font-medium">{{ $progresso }}%</span>
                        </div>
                        <!-- Mini etapas -->
                        <div class="grid grid-cols-5 gap-1">
                            <div class="flex flex-col items-center">
                                <div class="w-4 h-4 rounded-full {{ $progressoEtapas['coleta'] ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center">
                                    @if($progressoEtapas['coleta'])
                                        <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </div>
                                <span class="text-xs mt-1 {{ $progressoEtapas['coleta'] ? 'text-green-600' : 'text-gray-400' }}">Col.</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="w-4 h-4 rounded-full {{ $progressoEtapas['pesagem'] ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center">
                                    @if($progressoEtapas['pesagem'])
                                        <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </div>
                                <span class="text-xs mt-1 {{ $progressoEtapas['pesagem'] ? 'text-green-600' : 'text-gray-400' }}">Pes.</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="w-4 h-4 rounded-full {{ $progressoEtapas['empacotamento'] ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center">
                                    @if($progressoEtapas['empacotamento'])
                                        <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </div>
                                <span class="text-xs mt-1 {{ $progressoEtapas['empacotamento'] ? 'text-green-600' : 'text-gray-400' }}">Emp.</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="w-4 h-4 rounded-full {{ $progressoEtapas['entrega'] ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center">
                                    @if($progressoEtapas['entrega'])
                                        <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </div>
                                <span class="text-xs mt-1 {{ $progressoEtapas['entrega'] ? 'text-green-600' : 'text-gray-400' }}">Trân.</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="w-4 h-4 rounded-full {{ $progressoEtapas['confirmacao_cliente'] ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center">
                                    @if($progressoEtapas['confirmacao_cliente'])
                                        <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </div>
                                <span class="text-xs mt-1 {{ $progressoEtapas['confirmacao_cliente'] ? 'text-green-600' : 'text-gray-400' }}">Entr.</span>
                            </div>
                        </div>
                    </div>

                    <!-- Informações da Coleta -->
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 gap-4">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-500 font-medium">Data da Coleta</span>
                                        <p class="font-bold text-gray-900">{{ $coleta->created_at->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-500 font-medium">CNPJ</span>
                                        <p class="font-bold text-gray-900 text-sm">{{ $coleta->estabelecimento->cnpj_formatado ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($coleta->pesagens->isNotEmpty())
                            <div class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl p-4 border border-blue-100">
                                <div class="flex items-center space-x-3 mb-2">
                                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-bold text-blue-900 text-sm">Pesagem</h4>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="text-center">
                                        <p class="text-blue-800 font-bold text-lg">{{ number_format($coleta->pesagens->sum('peso'), 2, ',', '.') }}</p>
                                        <p class="text-blue-600 text-xs font-medium">kg</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-blue-800 font-bold text-lg">{{ $coleta->pesagens->sum('quantidade') }}</p>
                                        <p class="text-blue-600 text-xs font-medium">peças</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($coleta->empacotamentos->isNotEmpty())
                            @php $empacotamento = $coleta->empacotamentos->first(); @endphp
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-4 border border-green-100">
                                <div class="flex items-center space-x-3 mb-3">
                                    <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-bold text-green-900 text-sm">Empacotamento</h4>
                                </div>
                                <div class="space-y-2">
                                    <div class="bg-white rounded-lg p-2">
                                        <p class="text-green-800 font-mono text-xs">{{ $empacotamento->codigo_qr }}</p>
                                    </div>
                                    <p class="text-green-600 text-xs font-medium">
                                        {{ $empacotamento->data_empacotamento->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                            </div>

                            @if($empacotamento->entrega && $empacotamento->entrega->data_entrega)
                                <div class="bg-gradient-to-r from-emerald-50 to-green-50 rounded-xl p-4 border border-emerald-100">
                                    <div class="flex items-center space-x-3 mb-3">
                                        <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <h4 class="font-bold text-emerald-900 text-sm">Entregue</h4>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-emerald-800 font-medium text-sm">
                                            {{ $empacotamento->entrega->data_entrega->format('d/m/Y H:i') }}
                                        </p>
                                        <p class="text-emerald-600 text-xs">
                                            Recebido por: {{ $empacotamento->entrega->nome_recebedor ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                            @elseif($empacotamento->entrega && $empacotamento->entrega->data_saida)
                                <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl p-4 border border-yellow-100">
                                    <div class="flex items-center space-x-3 mb-3">
                                        <div class="w-8 h-8 bg-yellow-500 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                            </svg>
                                        </div>
                                        <h4 class="font-bold text-yellow-900 text-sm">Em Trânsito</h4>
                                    </div>
                                    <p class="text-yellow-800 font-medium text-sm">
                                        Saiu: {{ $empacotamento->entrega->data_saida->format('d/m/Y H:i') }}
                                    </p>
                                    <div class="mt-2 flex items-center space-x-2">
                                        <div class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></div>
                                        <span class="text-yellow-600 text-xs font-medium">A caminho do destino</span>
                                    </div>
                                </div>
                            @endif
                        @endif

                        <!-- Botão Ver Detalhes -->
                        <div class="pt-4 border-t border-gray-100">
                            <a href="{{ route('acompanhamento.detalhes', $coleta->id) }}" 
                               class="w-full bg-gradient-to-r from-blue-600 via-purple-600 to-cyan-600 hover:from-blue-700 hover:via-purple-700 hover:to-cyan-700 text-white text-center py-3 px-6 rounded-xl transition-all duration-300 inline-block font-semibold shadow-lg hover:shadow-xl transform hover:scale-[1.02] active:scale-[0.98]">
                                <span class="flex items-center justify-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <span>Ver Detalhes Completos</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($coletas->isEmpty())
            <div class="text-center py-20">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 bg-gradient-to-r from-blue-100 to-purple-100 rounded-3xl flex items-center justify-center mx-auto mb-8">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Nenhuma coleta encontrada</h3>
                    <p class="text-gray-600 mb-8 leading-relaxed">
                        Não encontramos coletas para <strong>"{{ $termoBusca }}"</strong>.<br>
                        Verifique se o CNPJ ou número da coleta estão corretos.
                    </p>
                    
                    <!-- Dicas de busca -->
                    <div class="bg-blue-50 rounded-2xl p-6 mb-8 text-left">
                        <h4 class="font-semibold text-blue-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Dicas de busca:
                        </h4>
                        <ul class="text-blue-800 text-sm space-y-2">
                            <li class="flex items-center space-x-2">
                                <div class="w-1.5 h-1.5 bg-blue-500 rounded-full"></div>
                                <span>Use o CNPJ completo: XX.XXX.XXX/XXXX-XX</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <div class="w-1.5 h-1.5 bg-blue-500 rounded-full"></div>
                                <span>Ou o número da coleta: COL-2024-XXX</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <div class="w-1.5 h-1.5 bg-blue-500 rounded-full"></div>
                                <span>Verifique se não há espaços extras</span>
                            </li>
                        </ul>
                    </div>
                    
                    <a href="{{ route('acompanhamento.index') }}" 
                       class="inline-flex items-center space-x-2 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-4 rounded-2xl transition-all duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span>Fazer Nova Busca</span>
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

