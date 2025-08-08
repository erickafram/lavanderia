@extends('layouts.app')

@section('title', 'Editar Empacotamento')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">
                <svg class="inline w-5 h-5 sm:w-6 sm:h-6 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Editar Empacotamento {{ $empacotamento->codigo_qr }}
            </h1>
            <p class="text-sm text-gray-600">Modificar dados do empacotamento</p>
        </div>
        <div class="flex gap-2 mt-3 sm:mt-0">
            <a href="{{ route('empacotamento.show', $empacotamento->id) }}"
               class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Voltar
            </a>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <h4 class="font-medium mb-2">Corrija os seguintes erros:</h4>
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('empacotamento.update', $empacotamento->id) }}">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <!-- Informações Básicas -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
                    <div class="p-4 border-b border-gray-100 bg-gradient-to-r from-yellow-50 to-orange-50">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Informações do Empacotamento
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Data de Empacotamento -->
                            <div>
                                <label for="data_empacotamento" class="block text-sm font-medium text-gray-700 mb-2">
                                    Data e Hora do Empacotamento *
                                </label>
                                <input type="datetime-local" 
                                       id="data_empacotamento" 
                                       name="data_empacotamento" 
                                       value="{{ old('data_empacotamento', $empacotamento->data_empacotamento->format('Y-m-d\TH:i')) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 text-sm @error('data_empacotamento') border-red-500 @enderror"
                                       required>
                                @error('data_empacotamento')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status Atual (só visualização) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Status Atual
                                </label>
                                <div class="px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-sm font-medium"
                                          style="background-color: {{ $empacotamento->status->cor }}20; color: {{ $empacotamento->status->cor }};">
                                        <div class="w-2 h-2 rounded-full mr-2" style="background-color: {{ $empacotamento->status->cor }};"></div>
                                        {{ $empacotamento->status->nome }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Observações -->
                        <div class="mt-6">
                            <label for="observacoes_empacotamento" class="block text-sm font-medium text-gray-700 mb-2">
                                Observações do Empacotamento
                            </label>
                            <textarea id="observacoes_empacotamento"
                                      name="observacoes_empacotamento"
                                      rows="4"
                                      placeholder="Observações sobre o empacotamento..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 text-sm @error('observacoes_empacotamento') border-red-500 @enderror">{{ old('observacoes_empacotamento', $empacotamento->observacoes_empacotamento) }}</textarea>
                            @error('observacoes_empacotamento')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Peças da Coleta -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="p-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Peças da Coleta
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Ajuste as quantidades empacotadas e adicione novas peças se necessário</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Qtd. Coletada</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Qtd. Empacotada</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Peso (kg)</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody id="tabela-pecas-empacotamento" class="bg-white divide-y divide-gray-200">
                                @foreach($empacotamento->coleta->pecas as $peca)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                                                <div class="text-sm font-medium text-gray-900">{{ $peca->tipo ? $peca->tipo->nome : 'Tipo não definido' }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                {{ $peca->quantidade }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <input type="number" 
                                                   name="pecas[{{ $peca->id }}][quantidade_empacotada]"
                                                   value="{{ old('pecas.'.$peca->id.'.quantidade_empacotada', $peca->quantidade_empacotada ?: $peca->quantidade) }}"
                                                   min="0" 
                                                   max="{{ $peca->quantidade }}"
                                                   class="w-20 px-2 py-1 text-center border border-gray-300 rounded text-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <input type="number" 
                                                   name="pecas[{{ $peca->id }}][peso_empacotado]"
                                                   value="{{ old('pecas.'.$peca->id.'.peso_empacotado', $peca->peso_empacotado ?: $peca->peso) }}"
                                                   step="0.01"
                                                   min="0"
                                                   class="w-20 px-2 py-1 text-center border border-gray-300 rounded text-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="text-gray-400 text-sm">Original</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Botão Adicionar Nova Peça -->
                    <div class="p-4 border-t border-gray-200 bg-gray-50">
                        <button type="button" onclick="adicionarLinhaPeca()"
                                class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Adicionar Nova Peça
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar com informações da coleta -->
            <div class="lg:col-span-1">
                <!-- Informações da Coleta -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
                    <div class="p-4 border-b border-gray-100 bg-gradient-to-r from-green-50 to-emerald-50">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Informações da Coleta
                        </h3>
                    </div>
                    <div class="p-4">
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm text-gray-600">Número:</span>
                                <span class="text-sm font-medium text-gray-900 ml-2">{{ $empacotamento->coleta->numero_coleta }}</span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600">Estabelecimento:</span>
                                <span class="text-sm font-medium text-gray-900 ml-2">{{ $empacotamento->coleta->estabelecimento->razao_social }}</span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600">Peso Total:</span>
                                <span class="text-sm font-medium text-gray-900 ml-2">{{ number_format($empacotamento->coleta->peso_total, 2, ',', '.') }} kg</span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600">Responsável:</span>
                                <span class="text-sm font-medium text-gray-900 ml-2">{{ $empacotamento->usuarioEmpacotamento->nome }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aviso sobre edição -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="text-sm font-semibold text-yellow-800 mb-1">Atenção</h4>
                            <p class="text-sm text-yellow-700">
                                Alterações nas quantidades empacotadas afetarão os cálculos de valor e peso total do empacotamento. 
                                Certifique-se de que os dados estão corretos antes de salvar.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botões de Ação -->
        <div class="flex flex-col sm:flex-row gap-3 sm:justify-end mt-6">
            <a href="{{ route('empacotamento.show', $empacotamento->id) }}" 
               class="inline-flex items-center justify-center px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-700 text-sm font-medium rounded-xl transition-colors duration-200">
                Cancelar
            </a>
            <button type="submit" 
                    class="inline-flex items-center justify-center px-6 py-3 bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Salvar Alterações
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
// Tipos de peças disponíveis
const tiposDisponiveis = @json($tipos);
let contadorNovasPecas = 0;

// Função para adicionar nova linha de peça
function adicionarLinhaPeca() {
    const tabela = document.getElementById('tabela-pecas-empacotamento');
    
    // Criar opções do select
    let opcoesSelect = '<option value="">Selecione um tipo</option>';
    tiposDisponiveis.forEach(function(tipo) {
        opcoesSelect += `<option value="${tipo.id}">${tipo.nome} (${tipo.categoria})</option>`;
    });

    // Criar nova linha
    const novaLinha = document.createElement('tr');
    novaLinha.className = 'linha-nova-peca hover:bg-gray-50';
    novaLinha.innerHTML = `
        <td class="px-6 py-4 whitespace-nowrap">
            <select name="novas_pecas[${contadorNovasPecas}][tipo_id]" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500" 
                    required>
                ${opcoesSelect}
            </select>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-center">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                Nova
            </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-center">
            <input type="number" 
                   name="novas_pecas[${contadorNovasPecas}][quantidade]"
                   min="1" 
                   placeholder="1"
                   class="w-20 px-2 py-1 text-center border border-gray-300 rounded text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500"
                   required>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-center">
            <input type="number" 
                   name="novas_pecas[${contadorNovasPecas}][peso]"
                   step="0.01" 
                   min="0"
                   placeholder="0.00"
                   class="w-20 px-2 py-1 text-center border border-gray-300 rounded text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-center">
            <button type="button" 
                    onclick="removerLinhaPeca(this)"
                    class="inline-flex items-center px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded transition-colors duration-200">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Remover
            </button>
        </td>
    `;

    // Adicionar a linha à tabela
    tabela.appendChild(novaLinha);
    contadorNovasPecas++;
}

// Função para remover linha de peça
function removerLinhaPeca(botao) {
    const linha = botao.closest('tr');
    if (linha.classList.contains('linha-nova-peca')) {
        linha.remove();
    }
}
</script>
@endpush
