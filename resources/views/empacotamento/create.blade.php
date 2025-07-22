@extends('layouts.app')

@section('title', 'Novo Empacotamento')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">
                <svg class="inline w-5 h-5 sm:w-6 sm:h-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                📦 Novo Empacotamento
            </h1>
            <p class="text-sm text-gray-600">Criar um novo empacotamento para entrega</p>
        </div>
        <div class="flex gap-2 mt-3 sm:mt-0">
            <a href="{{ route('empacotamento.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Voltar
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Dados do Empacotamento
                    </h3>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('empacotamento.store') }}" id="formEmpacotamento">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="coleta_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Coleta <span class="text-red-500">*</span>
                                </label>
                                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm @error('coleta_id') border-red-500 @enderror" 
                                        id="coleta_id" name="coleta_id" required>
                                    <option value="">Selecione uma coleta</option>
                                    @foreach($coletas as $coleta)
                                        <option value="{{ $coleta->id }}" 
                                                {{ old('coleta_id') == $coleta->id ? 'selected' : '' }}
                                                data-estabelecimento="{{ $coleta->estabelecimento->razao_social }}"
                                                data-peso="{{ $coleta->peso_total }}"
                                                data-valor="{{ $coleta->valor_total }}"
                                                data-pecas="{{ $coleta->pecas->count() }}">
                                            {{ $coleta->numero_coleta }} - {{ $coleta->estabelecimento->razao_social }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('coleta_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="motorista_id" class="block text-sm font-medium text-gray-700 mb-2">Motorista</label>
                                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm @error('motorista_id') border-red-500 @enderror" 
                                        id="motorista_id" name="motorista_id">
                                    <option value="">Selecione um motorista</option>
                                    @foreach($motoristas as $motorista)
                                        <option value="{{ $motorista->id }}" {{ old('motorista_id') == $motorista->id ? 'selected' : '' }}>
                                            {{ $motorista->nome }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('motorista_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="data_empacotamento" class="block text-sm font-medium text-gray-700 mb-2">
                                Data/Hora do Empacotamento <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm @error('data_empacotamento') border-red-500 @enderror" 
                                   id="data_empacotamento" name="data_empacotamento" 
                                   value="{{ old('data_empacotamento', now()->format('Y-m-d\TH:i')) }}" 
                                   required>
                            @error('data_empacotamento')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="observacoes_empacotamento" class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
                            <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm @error('observacoes_empacotamento') border-red-500 @enderror" 
                                      id="observacoes_empacotamento" name="observacoes_empacotamento" rows="3" 
                                      placeholder="Observações sobre o empacotamento...">{{ old('observacoes_empacotamento') }}</textarea>
                            @error('observacoes_empacotamento')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end space-x-3 mt-6">
                            <a href="{{ route('empacotamento.index') }}" 
                               class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                </svg>
                                Criar Empacotamento
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6">
            <!-- Informações da Coleta Selecionada -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100" id="infoColeta" style="display: none;">
                <div class="p-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Informações da Coleta
                    </h3>
                </div>
                <div class="p-4 space-y-3">
                    <div>
                        <span class="text-sm font-medium text-gray-700">Estabelecimento:</span>
                        <div id="estabelecimentoNome" class="text-gray-900 text-sm"></div>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-700">Peso Total:</span>
                        <div id="pesoTotal" class="text-gray-900 text-sm font-medium"></div>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-700">Valor Total:</span>
                        <div id="valorTotal" class="text-gray-900 text-sm font-medium"></div>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-700">Quantidade de Peças:</span>
                        <div id="quantidadePecas" class="text-gray-900 text-sm"></div>
                    </div>
                </div>
            </div>

            <!-- Dicas -->
            <div class="bg-blue-50 rounded-xl border border-blue-200 p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="text-sm font-medium text-blue-900 mb-2">Dicas para Empacotamento</h4>
                        <ul class="text-xs text-blue-800 space-y-1">
                            <li>• Apenas coletas concluídas podem ser empacotadas</li>
                            <li>• Um código QR será gerado automaticamente</li>
                            <li>• O motorista pode ser definido posteriormente</li>
                            <li>• Verifique todas as peças antes de empacotar</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const coletaSelect = document.getElementById('coleta_id');
    const infoColeta = document.getElementById('infoColeta');
    
    coletaSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (selectedOption.value) {
            const estabelecimento = selectedOption.dataset.estabelecimento;
            const peso = selectedOption.dataset.peso;
            const valor = selectedOption.dataset.valor;
            const pecas = selectedOption.dataset.pecas;
            
            document.getElementById('estabelecimentoNome').textContent = estabelecimento;
            document.getElementById('pesoTotal').textContent = peso + ' kg';
            document.getElementById('valorTotal').textContent = 'R$ ' + parseFloat(valor).toFixed(2).replace('.', ',');
            document.getElementById('quantidadePecas').textContent = pecas + ' tipos';
            
            infoColeta.style.display = 'block';
        } else {
            infoColeta.style.display = 'none';
        }
    });
});
</script>
@endpush
@endsection
