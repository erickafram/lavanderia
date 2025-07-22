@extends('layouts.app')

@section('title', 'Editar Pesagem')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">
                <svg class="inline w-5 h-5 sm:w-6 sm:h-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16l3-1m-3 1l-3-1"></path>
                </svg>
                ⚖️ Editar Pesagem
            </h1>
            <p class="text-sm text-gray-600">Editar dados da pesagem</p>
        </div>
        <div class="flex gap-2 mt-3 sm:mt-0">
            <a href="{{ route('pesagem.show', $pesagem->id) }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                Visualizar
            </a>
            <a href="{{ route('pesagem.index') }}"
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Dados da Pesagem
                    </h3>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('pesagem.update', $pesagem->id) }}" id="formPesagem">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="coleta_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Coleta <span class="text-red-500">*</span>
                                </label>
                                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm @error('coleta_id') border-red-500 @enderror"
                                        id="coleta_id" name="coleta_id" required>
                                    <option value="">Selecione uma coleta</option>
                                    @foreach($coletas as $coletaOption)
                                        <option value="{{ $coletaOption->id }}"
                                                {{ (old('coleta_id', $pesagem->coleta_id) == $coletaOption->id) ? 'selected' : '' }}
                                                data-estabelecimento="{{ $coletaOption->estabelecimento->razao_social }}">
                                            {{ $coletaOption->numero_coleta }} - {{ $coletaOption->estabelecimento->razao_social }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('coleta_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="tipo_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tipo de Peça <span class="text-red-500">*</span>
                                </label>
                                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm @error('tipo_id') border-red-500 @enderror"
                                        id="tipo_id" name="tipo_id" required>
                                    <option value="">Selecione um tipo</option>
                                    @foreach($tipos as $tipo)
                                        <option value="{{ $tipo->id }}"
                                                {{ old('tipo_id', $pesagem->tipo_id) == $tipo->id ? 'selected' : '' }}
                                                data-preco="{{ $tipo->preco_kg }}">
                                            {{ $tipo->nome }} (R$ {{ number_format($tipo->preco_kg, 2, ',', '.') }}/kg)
                                        </option>
                                    @endforeach
                                </select>
                                @error('tipo_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                            <div>
                                <label for="peso" class="block text-sm font-medium text-gray-700 mb-2">
                                    Peso (kg) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" step="0.01" min="0.01" max="999.99"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm @error('peso') border-red-500 @enderror"
                                       id="peso" name="peso" value="{{ old('peso', $pesagem->peso) }}"
                                       placeholder="0,00" required>
                                @error('peso')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="quantidade" class="block text-sm font-medium text-gray-700 mb-2">
                                    Quantidade <span class="text-red-500">*</span>
                                </label>
                                <input type="number" min="1" max="999"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm @error('quantidade') border-red-500 @enderror"
                                       id="quantidade" name="quantidade" value="{{ old('quantidade', $pesagem->quantidade) }}"
                                       required>
                                @error('quantidade')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="peso_unitario" class="block text-sm font-medium text-gray-700 mb-2">Peso Unitário (kg)</label>
                                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-sm"
                                       id="peso_unitario" readonly placeholder="Calculado automaticamente">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <label for="data_pesagem" class="block text-sm font-medium text-gray-700 mb-2">
                                    Data/Hora da Pesagem <span class="text-red-500">*</span>
                                </label>
                                <input type="datetime-local"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm @error('data_pesagem') border-red-500 @enderror"
                                       id="data_pesagem" name="data_pesagem"
                                       value="{{ old('data_pesagem', $pesagem->data_pesagem->format('Y-m-d\TH:i')) }}"
                                       required>
                                @error('data_pesagem')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="local_pesagem" class="block text-sm font-medium text-gray-700 mb-2">Local da Pesagem</label>
                                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm @error('local_pesagem') border-red-500 @enderror"
                                       id="local_pesagem" name="local_pesagem"
                                       value="{{ old('local_pesagem', $pesagem->local_pesagem) }}"
                                       placeholder="Ex: Balança 1, Setor A">
                                @error('local_pesagem')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="observacoes" class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
                            <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm @error('observacoes') border-red-500 @enderror"
                                      id="observacoes" name="observacoes" rows="3"
                                      placeholder="Observações sobre a pesagem...">{{ old('observacoes', $pesagem->observacoes) }}</textarea>
                            @error('observacoes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end space-x-3 mt-6">
                            <a href="{{ route('pesagem.show', $pesagem->id) }}"
                               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Visualizar
                            </a>
                            <a href="{{ route('pesagem.index') }}"
                               class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancelar
                            </a>
                            <button type="submit"
                                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                </svg>
                                Atualizar Pesagem
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6">
            <!-- Status da Pesagem -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Status da Pesagem
                    </h3>
                </div>
                <div class="p-4 space-y-3">
                    <div>
                        <span class="text-sm font-medium text-gray-700">Status:</span>
                        <div class="mt-1">
                            @if($pesagem->conferido)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Conferida
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Pendente
                                </span>
                            @endif
                        </div>
                    </div>

                    @if($pesagem->conferido)
                        <div>
                            <span class="text-sm font-medium text-gray-700">Conferida por:</span>
                            <div class="text-gray-900 text-sm">{{ $pesagem->usuarioConferencia->nome }}</div>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-700">Data da Conferência:</span>
                            <div class="text-gray-900 text-sm">{{ $pesagem->data_conferencia_formatada }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Informações da Coleta -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Coleta Atual
                    </h3>
                </div>
                <div class="p-4 space-y-3">
                    <div>
                        <span class="text-sm font-medium text-gray-700">Número:</span>
                        <div class="text-blue-600 font-semibold">{{ $pesagem->coleta->numero_coleta }}</div>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-700">Estabelecimento:</span>
                        <div class="text-gray-900 text-sm">{{ $pesagem->coleta->estabelecimento->razao_social }}</div>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-700">Status:</span>
                        <div class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                  style="background-color: {{ $pesagem->coleta->status->cor }}20; color: {{ $pesagem->coleta->status->cor }};">
                                {{ $pesagem->coleta->status->nome }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Histórico -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Histórico
                    </h3>
                </div>
                <div class="p-4 space-y-3">
                    <div>
                        <span class="text-sm font-medium text-gray-700">Criada por:</span>
                        <div class="text-gray-900 text-sm">{{ $pesagem->usuario->nome }}</div>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-700">Data de Criação:</span>
                        <div class="text-gray-900 text-sm">{{ $pesagem->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    @if($pesagem->updated_at != $pesagem->created_at)
                        <div>
                            <span class="text-sm font-medium text-gray-700">Última Atualização:</span>
                            <div class="text-gray-900 text-sm">{{ $pesagem->updated_at->format('d/m/Y H:i') }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Calculadora de Peso -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        Calculadora
                    </h3>
                </div>
                <div class="p-4 space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-700">Peso Total:</span>
                        <span id="calcPesoTotal" class="text-sm font-bold text-blue-600">{{ $pesagem->peso_formatado }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-700">Peso Unitário:</span>
                        <span id="calcPesoUnitario" class="text-sm font-bold text-indigo-600">{{ $pesagem->peso_unitario_formatado }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-700">Valor Estimado:</span>
                        <span id="calcValorEstimado" class="text-sm font-bold text-green-600">R$ 0,00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tipoSelect = document.getElementById('tipo_id');
    const pesoInput = document.getElementById('peso');
    const quantidadeInput = document.getElementById('quantidade');
    const pesoUnitarioInput = document.getElementById('peso_unitario');

    // Função para calcular peso unitário e valores
    function calcularValores() {
        const peso = parseFloat(pesoInput.value) || 0;
        const quantidade = parseInt(quantidadeInput.value) || 1;
        const tipoOption = tipoSelect.options[tipoSelect.selectedIndex];
        const precoKg = parseFloat(tipoOption.dataset.preco) || 0;

        const pesoUnitario = quantidade > 0 ? peso / quantidade : 0;
        const valorEstimado = peso * precoKg;

        pesoUnitarioInput.value = pesoUnitario.toFixed(2);

        // Atualizar calculadora
        document.getElementById('calcPesoTotal').textContent = peso.toFixed(2).replace('.', ',') + ' kg';
        document.getElementById('calcPesoUnitario').textContent = pesoUnitario.toFixed(2).replace('.', ',') + ' kg';
        document.getElementById('calcValorEstimado').textContent = 'R$ ' + valorEstimado.toFixed(2).replace('.', ',');
    }

    // Event listeners
    pesoInput.addEventListener('input', calcularValores);
    quantidadeInput.addEventListener('input', calcularValores);
    tipoSelect.addEventListener('change', calcularValores);

    // Calcular valores iniciais
    calcularValores();
});
</script>
@endpush
