@extends('layouts.app')

@section('title', 'Empacotamentos')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">
                <svg class="inline w-5 h-5 sm:w-6 sm:h-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                📦 Empacotamentos
            </h1>
            <p class="text-sm text-gray-600">Gerencie o empacotamento e entrega das peças</p>
        </div>
        <div class="flex gap-2 mt-3 sm:mt-0">
            <a href="{{ route('empacotamento.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Novo Empacotamento
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
        <div class="p-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Filtros</h3>
        </div>
        <div class="p-4">
            <form method="GET" action="{{ route('empacotamento.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label for="status_id" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status_id" id="status_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                            <option value="">Todos os status</option>
                            @foreach($status as $st)
                                <option value="{{ $st->id }}" {{ request('status_id') == $st->id ? 'selected' : '' }}>
                                    {{ $st->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="motorista_id" class="block text-sm font-medium text-gray-700 mb-2">Motorista</label>
                        <select name="motorista_id" id="motorista_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                            <option value="">Todos os motoristas</option>
                            @foreach($motoristas as $motorista)
                                <option value="{{ $motorista->id }}" {{ request('motorista_id') == $motorista->id ? 'selected' : '' }}>
                                    {{ $motorista->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="data_inicio" class="block text-sm font-medium text-gray-700 mb-2">Data Início</label>
                        <input type="date" name="data_inicio" id="data_inicio" value="{{ request('data_inicio') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                    </div>
                    <div>
                        <label for="data_fim" class="block text-sm font-medium text-gray-700 mb-2">Data Fim</label>
                        <input type="date" name="data_fim" id="data_fim" value="{{ request('data_fim') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="busca" class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                        <input type="text" name="busca" id="busca" value="{{ request('busca') }}" 
                               placeholder="Código QR, número da coleta ou estabelecimento..."
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" 
                                class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Filtrar
                        </button>
                        <a href="{{ route('empacotamento.index') }}" 
                           class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-200">
                            Limpar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de Empacotamentos -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-4 border-b border-gray-100">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">
                    Empacotamentos ({{ $empacotamentos->total() }})
                </h3>
            </div>
        </div>

        @if($empacotamentos->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código QR</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Coleta</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estabelecimento</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motorista</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($empacotamentos as $empacotamento)
                            <tr class="hover:bg-gray-50 cursor-pointer transition-colors duration-200" 
                                onclick="window.location.href='{{ route('empacotamento.show', $empacotamento->id) }}'"
                                title="Clique para ver detalhes">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="text-sm font-medium text-gray-900">{{ $empacotamento->codigo_qr }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($empacotamento->coleta)
                                        <div class="text-sm text-gray-900">{{ $empacotamento->coleta->numero_coleta }}</div>
                                    @else
                                        <div class="text-sm text-red-600">Coleta não encontrada</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($empacotamento->coleta && $empacotamento->coleta->estabelecimento)
                                        <div class="text-sm text-gray-900">{{ $empacotamento->coleta->estabelecimento->razao_social }}</div>
                                        @if($empacotamento->coleta->estabelecimento->nome_fantasia)
                                            <div class="text-xs text-gray-500">{{ $empacotamento->coleta->estabelecimento->nome_fantasia }}</div>
                                        @endif
                                    @else
                                        <div class="text-sm text-red-600">Estabelecimento não encontrado</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" 
                                          style="background-color: {{ $empacotamento->status->cor }}20; color: {{ $empacotamento->status->cor }};">
                                        {{ $empacotamento->status->nome }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $empacotamento->motorista->nome ?? 'Não definido' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $empacotamento->data_empacotamento->format('d/m/Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $empacotamento->data_empacotamento->format('H:i') }}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginação -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $empacotamentos->withQueryString()->links() }}
            </div>
        @else
            <div class="p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhum empacotamento encontrado</h3>
                <p class="mt-1 text-sm text-gray-500">Comece criando um novo empacotamento.</p>
                <div class="mt-6">
                    <a href="{{ route('empacotamento.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Novo Empacotamento
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
