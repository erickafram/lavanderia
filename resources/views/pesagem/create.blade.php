@extends('layouts.app')

@section('title', 'Nova Pesagem')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">
                <svg class="inline w-5 h-5 sm:w-6 sm:h-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16l3-1m-3 1l-3-1"></path>
                </svg>
                ⚖️ Nova Pesagem
            </h1>
            <p class="text-sm text-gray-600">Registrar nova pesagem de peças</p>
        </div>
        <div class="flex gap-2 mt-3 sm:mt-0">
            <a href="{{ route('pesagem.create-comparacao') }}"
               class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v11a2 2 0 002 2h5.586a1 1 0 00.707-.293l5.414-5.414a1 1 0 00.293-.707V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                Pesagem com Comparação
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Dados da Pesagem
                    </h3>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('pesagem.store-geral') }}" id="formPesagem">
                        @csrf

                        <div class="mb-4">
                            <label for="coleta_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Coleta <span class="text-red-500">*</span>
                            </label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm @error('coleta_id') border-red-500 @enderror"
                                    id="coleta_id" name="coleta_id" required>
                                <option value="">Selecione uma coleta</option>
                                @foreach($coletas as $coletaOption)
                                    <option value="{{ $coletaOption->id }}"
                                            {{ (old('coleta_id', $coleta?->id) == $coletaOption->id) ? 'selected' : '' }}
                                            data-estabelecimento="{{ $coletaOption->estabelecimento->razao_social }}">
                                        {{ $coletaOption->numero_coleta }} - {{ $coletaOption->estabelecimento->razao_social }}
                                    </option>
                                @endforeach
                            </select>
                            @error('coleta_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Campos de Pesagem -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <label for="peso" class="block text-sm font-medium text-gray-700 mb-2">
                                    Peso Total (kg) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" step="0.01" min="0.01" max="999.99"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm @error('peso') border-red-500 @enderror"
                                       id="peso" name="peso" value="{{ old('peso') }}"
                                       placeholder="0,00" required>
                                @error('peso')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="quantidade" class="block text-sm font-medium text-gray-700 mb-2">
                                    Quantidade Total <span class="text-red-500">*</span>
                                </label>
                                <input type="number" min="1" max="999"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm @error('quantidade') border-red-500 @enderror"
                                       id="quantidade" name="quantidade" value="{{ old('quantidade', 1) }}"
                                       required>
                                @error('quantidade')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Informações da Coleta -->
                        <div id="info-coleta-pesagem" style="display: none;" class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <h5 class="text-sm font-medium text-blue-900 mb-2">Informações da Coleta</h5>
                            <div id="dados-coleta-pesagem" class="text-sm text-blue-800"></div>
                            <div id="diferenca-peso" class="mt-2 text-sm font-medium"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <label for="data_pesagem" class="block text-sm font-medium text-gray-700 mb-2">
                                    Data/Hora da Pesagem <span class="text-red-500">*</span>
                                </label>
                                <input type="datetime-local"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm @error('data_pesagem') border-red-500 @enderror"
                                       id="data_pesagem" name="data_pesagem"
                                       value="{{ old('data_pesagem', now()->format('Y-m-d\TH:i')) }}"
                                       required>
                                @error('data_pesagem')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="local_pesagem" class="block text-sm font-medium text-gray-700 mb-2">Local da Pesagem</label>
                                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm @error('local_pesagem') border-red-500 @enderror"
                                       id="local_pesagem" name="local_pesagem"
                                       value="{{ old('local_pesagem') }}"
                                       placeholder="Ex: Balança 1, Setor A">
                                @error('local_pesagem')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="observacoes_gerais" class="block text-sm font-medium text-gray-700 mb-2">Observações Gerais</label>
                            <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm @error('observacoes_gerais') border-red-500 @enderror"
                                      id="observacoes_gerais" name="observacoes_gerais" rows="3"
                                      placeholder="Observações gerais sobre a pesagem...">{{ old('observacoes_gerais') }}</textarea>
                            @error('observacoes_gerais')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end space-x-3 mt-6">
                            <a href="{{ route('pesagem.index') }}"
                               class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancelar
                            </a>
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                </svg>
                                Salvar Pesagem
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6">
            <!-- Informações da Coleta Selecionada -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 hidden" id="infoColeta">
                <div class="p-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Informações da Coleta
                    </h3>
                </div>
                <div class="p-4" id="dadosColeta">
                    <!-- Dados serão carregados via JavaScript -->
                </div>
            </div>

            <!-- Dicas -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                        Dicas
                    </h3>
                </div>
                <div class="p-4">
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-sm text-gray-700">Certifique-se de que a balança está calibrada</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-sm text-gray-700">Registre o peso imediatamente após a pesagem</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-sm text-gray-700">Anote observações sobre peças danificadas</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-sm text-gray-700">Confira se o tipo de peça está correto</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Calculadora de Peso -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        Calculadora
                    </h3>
                </div>
                <div class="p-4 space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-700">Peso Total:</span>
                        <span id="calcPesoTotal" class="text-sm font-bold text-blue-600">0,00 kg</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-700">Peso Unitário:</span>
                        <span id="calcPesoUnitario" class="text-sm font-bold text-indigo-600">0,00 kg</span>
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
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const coletaSelect = document.getElementById('coleta_id');
    const pesoInput = document.getElementById('peso');
    const quantidadeInput = document.getElementById('quantidade');
    const infoColeta = document.getElementById('infoColeta');
    const dadosColeta = document.getElementById('dadosColeta');
    const infoColetaPesagem = document.getElementById('info-coleta-pesagem');
    const dadosColetaPesagem = document.getElementById('dados-coleta-pesagem');
    const diferencaPeso = document.getElementById('diferenca-peso');

    // URL base para as requisições
    const baseUrl = '{{ url("coletas") }}';

    // Dados da coleta atual
    let coletaAtual = null;

    // Função para calcular diferença de peso total
    function calcularDiferencaPesoTotal() {
        if (!coletaAtual) return;

        const pesoInserido = parseFloat(pesoInput.value) || 0;
        const pesoColeta = coletaAtual.peso_total || 0;

        if (pesoColeta > 0) {
            // Coleta tem peso - calcular diferença
            const diferenca = pesoInserido - pesoColeta;
            let htmlDiferenca = '';

            if (Math.abs(diferenca) > 0.01) {
                const sinal = diferenca > 0 ? '+' : '';
                const cor = diferenca > 0 ? 'text-green-600' : 'text-red-600';
                const texto = diferenca > 0 ? 'a mais' : 'a menos';
                htmlDiferenca = `<div class="${cor}">Diferença: ${sinal}${Math.abs(diferenca).toFixed(2)} kg ${texto}</div>`;
            } else {
                htmlDiferenca = '<div class="text-green-600">✓ Peso confere com a coleta</div>';
            }

            diferencaPeso.innerHTML = htmlDiferenca;
        } else {
            // Coleta não tem peso - só mostrar peso inserido
            if (pesoInserido > 0) {
                diferencaPeso.innerHTML = `<div class="text-blue-600">Peso da pesagem: ${pesoInserido.toFixed(2)} kg</div>`;
            } else {
                diferencaPeso.innerHTML = '';
            }
        }
    }

    // Função para carregar dados da coleta
    function carregarDadosColeta() {
        const coletaId = coletaSelect.value;
        if (!coletaId) {
            infoColeta.classList.add('hidden');
            infoColetaPesagem.style.display = 'none';
            coletaAtual = null;
            return;
        }

        // Fazer requisição AJAX para buscar dados da coleta
        fetch(`${baseUrl}/${coletaId}/pecas`)
            .then(response => response.json())
            .then(data => {
                coletaAtual = data.coleta;

                // Atualizar informações da coleta no card principal
                const coletaOption = coletaSelect.options[coletaSelect.selectedIndex];
                const estabelecimento = coletaOption.dataset.estabelecimento;

                dadosColeta.innerHTML = `
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm font-medium text-gray-700">Número:</span>
                            <div class="text-blue-600 font-semibold">${coletaOption.text.split(' - ')[0]}</div>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-700">Estabelecimento:</span>
                            <div class="text-gray-900 text-sm">${estabelecimento}</div>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-700">Status:</span>
                            <div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Disponível para Pesagem
                                </span>
                            </div>
                        </div>
                    </div>
                `;

                // Atualizar informações da coleta para pesagem
                let infoPesagem = '';
                if (data.coleta.peso_total > 0) {
                    infoPesagem = `<strong>Peso da Coleta:</strong> ${data.coleta.peso_total} kg`;
                } else {
                    infoPesagem = `<strong>Coleta por quantidade</strong> - Inserir peso da pesagem`;
                }

                if (data.pecas && data.pecas.length > 0) {
                    infoPesagem += `<br><strong>Tipos de peças:</strong> ${data.pecas.length}`;
                }

                dadosColetaPesagem.innerHTML = infoPesagem;

                infoColeta.classList.remove('hidden');
                infoColetaPesagem.style.display = 'block';

                // Calcular diferença inicial
                calcularDiferencaPesoTotal();
            })
            .catch(error => {
                console.error('Erro ao carregar dados da coleta:', error);
                infoColetaPesagem.style.display = 'none';
            });
    }

    // Event listeners
    coletaSelect.addEventListener('change', carregarDadosColeta);
    pesoInput.addEventListener('input', calcularDiferencaPesoTotal);

    // Carregar dados iniciais se houver coleta selecionada
    if (coletaSelect.value) {
        carregarDadosColeta();
    }
});
</script>
@endpush
