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

                        <!-- Seção de Peças da Coleta -->
                        <div id="secao-pecas-empacotamento" style="display: none;">
                            <div class="border-t border-gray-200 pt-4 mt-4">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v11a2 2 0 002 2h5.586a1 1 0 00.707-.293l5.414-5.414a1 1 0 00.293-.707V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <span id="titulo-secao-pecas">Peças da Coleta</span>
                                </h4>
                                <p id="descricao-secao-pecas" class="text-sm text-gray-600 mb-4"></p>

                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead id="cabecalho-tabela-empacotamento" class="bg-gray-50">
                                            <!-- Cabeçalho será definido via JavaScript -->
                                        </thead>
                                        <tbody id="tabela-pecas-empacotamento" class="bg-white divide-y divide-gray-200">
                                            <!-- Peças serão carregadas via JavaScript -->
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Botão Adicionar (só aparece para coletas por peso) -->
                                <div id="botao-adicionar-peca" style="display: none;" class="mt-4 text-center">
                                    <button type="button" onclick="adicionarLinhaPeca()"
                                            class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Adicionar Tipo de Peça
                                    </button>
                                </div>
                            </div>
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
                        <h4 class="text-sm font-medium text-blue-900 mb-2">Fluxo do Empacotamento</h4>
                        <ul class="text-xs text-blue-800 space-y-1">
                            <li>• Apenas coletas concluídas podem ser empacotadas</li>
                            <li>• Um código QR será gerado automaticamente</li>
                            <li>• Status inicial: "Pronto para motorista"</li>
                            <li>• Motorista fará a saída lendo o QR Code</li>
                            <li>• Cliente assinará o recebimento na entrega</li>
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
    const secaoPecasEmpacotamento = document.getElementById('secao-pecas-empacotamento');
    const tabelaPecasEmpacotamento = document.getElementById('tabela-pecas-empacotamento');
    const cabecalhoTabela = document.getElementById('cabecalho-tabela-empacotamento');
    const tituloSecao = document.getElementById('titulo-secao-pecas');
    const descricaoSecao = document.getElementById('descricao-secao-pecas');
    const botaoAdicionarPeca = document.getElementById('botao-adicionar-peca');

    // URL base para as requisições
    const baseUrl = '{{ url("coletas") }}';

    // Tipos de peças disponíveis
    const tiposDisponiveis = @json($tipos ?? []);
    
    // Função para carregar dados da coleta e peças
    function carregarDadosColeta() {
        const coletaId = coletaSelect.value;
        if (!coletaId) {
            infoColeta.style.display = 'none';
            secaoPecasEmpacotamento.style.display = 'none';
            return;
        }

        // Fazer requisição AJAX para buscar as peças da coleta
        fetch(`${baseUrl}/${coletaId}/pecas`)
            .then(response => response.json())
            .then(data => {
                if (data.pecas && data.pecas.length > 0) {
                    carregarTabelaPecasEmpacotamento(data.pecas);
                    secaoPecasEmpacotamento.style.display = 'block';
                } else {
                    secaoPecasEmpacotamento.style.display = 'none';
                }

                // Atualizar informações da coleta
                const selectedOption = coletaSelect.options[coletaSelect.selectedIndex];
                const estabelecimento = selectedOption.dataset.estabelecimento;
                const peso = selectedOption.dataset.peso;
                const valor = selectedOption.dataset.valor;
                const pecas = selectedOption.dataset.pecas;

                document.getElementById('estabelecimentoNome').textContent = estabelecimento;
                document.getElementById('pesoTotal').textContent = peso + ' kg';
                document.getElementById('valorTotal').textContent = 'R$ ' + parseFloat(valor).toFixed(2).replace('.', ',');
                document.getElementById('quantidadePecas').textContent = data.pecas.length + ' tipos';

                infoColeta.style.display = 'block';
            })
            .catch(error => {
                console.error('Erro ao carregar peças:', error);
                secaoPecasEmpacotamento.style.display = 'none';
            });
    }

    // Event listener para mudança de coleta
    coletaSelect.addEventListener('change', carregarDadosColeta);

    // Função para carregar tabela de peças do empacotamento
    function carregarTabelaPecasEmpacotamento(pecas) {
        // Separar peças por quantidade e por peso
        const pecasPorQuantidade = pecas.filter(peca => peca.quantidade > 0);
        const temPesoSemTipo = pecas.length === 0; // Coleta só tem peso total, sem tipos

        let html = '';
        let cabecalho = '';

        if (pecasPorQuantidade.length > 0) {
            // CONFERÊNCIA DE QUANTIDADE (coleta foi por quantidade)
            tituloSecao.textContent = 'Conferência de Quantidade de Peças';
            descricaoSecao.textContent = 'Confira se a quantidade empacotada confere com a quantidade coletada';

            cabecalho = `
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qtd. da Coleta</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qtd. Empacotada</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diferença</th>
                </tr>
            `;

            pecasPorQuantidade.forEach(function(peca) {
                html += `
                    <tr class="peca-row" data-peca-id="${peca.id}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">${peca.tipo.nome}</div>
                            <div class="text-sm text-gray-500">${peca.tipo.categoria}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                <strong>${peca.quantidade}</strong> peças
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Quantidade Empacotada</label>
                                <input type="number" min="0"
                                       name="pecas[${peca.id}][quantidade_empacotada]"
                                       value="${peca.quantidade}"
                                       class="quantidade-empacotada w-full px-3 py-2 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       data-original="${peca.quantidade}"
                                       required>
                                <input type="hidden" name="pecas[${peca.id}][peso_empacotado]" value="0">
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="diferenca-display text-sm">
                                <div class="text-green-600 font-medium">✓ Confere</div>
                            </div>
                        </td>
                    </tr>
                `;
            });

        } else {
            // CADASTRO DE TIPOS (coleta foi por peso)
            tituloSecao.textContent = 'Cadastro de Tipos de Peças';
            descricaoSecao.textContent = 'Informe os tipos, pesos e quantidades das peças empacotadas (coleta foi por peso total)';

            cabecalho = `
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo de Peça</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantidade</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                </tr>
            `;

            // Linha inicial para adicionar Itens
            html = criarLinhaNovaPeca(0);
        }

        cabecalhoTabela.innerHTML = cabecalho;
        tabelaPecasEmpacotamento.innerHTML = html;

        // Mostrar/esconder botão adicionar conforme o tipo de coleta
        if (pecasPorQuantidade.length > 0) {
            // Coleta por quantidade - esconder botão
            botaoAdicionarPeca.style.display = 'none';
            // Adicionar event listeners para calcular diferenças
            document.querySelectorAll('.quantidade-empacotada').forEach(function(input) {
                input.addEventListener('input', calcularDiferencasQuantidade);
            });
        } else {
            // Coleta por peso - mostrar botão
            botaoAdicionarPeca.style.display = 'block';
        }
    }

    // Função para calcular diferenças de quantidade (para empacotamento)
    function calcularDiferencasQuantidade() {
        document.querySelectorAll('.peca-row').forEach(function(row) {
            const quantidadeInput = row.querySelector('.quantidade-empacotada');
            const diferencaDisplay = row.querySelector('.diferenca-display');

            if (!quantidadeInput || !diferencaDisplay) return;

            const quantidadeOriginal = parseInt(quantidadeInput.dataset.original) || 0;
            const quantidadeEmpacotada = parseInt(quantidadeInput.value) || 0;
            const diferencaQuantidade = quantidadeEmpacotada - quantidadeOriginal;

            let htmlDiferenca = '';

            if (diferencaQuantidade !== 0) {
                const sinalQtd = diferencaQuantidade > 0 ? '+' : '';
                const corQtd = diferencaQuantidade > 0 ? 'text-green-600' : 'text-red-600';
                const textoQtd = diferencaQuantidade > 0 ? 'a mais' : 'a menos';
                htmlDiferenca = `<div class="${corQtd} font-medium text-sm">${sinalQtd}${Math.abs(diferencaQuantidade)} peças ${textoQtd}</div>`;
            } else {
                htmlDiferenca = '<div class="text-green-600 font-medium text-sm">✓ Confere</div>';
            }

            diferencaDisplay.innerHTML = htmlDiferenca;
        });
    }

    // Função para criar HTML de linha de nova peça
    function criarLinhaNovaPeca(index) {
        let opcoesSelect = '<option value="">Selecione um tipo</option>';
        tiposDisponiveis.forEach(function(tipo) {
            opcoesSelect += `<option value="${tipo.id}">${tipo.nome} (${tipo.categoria})</option>`;
        });

        return `
            <tr class="linha-nova-peca">
                <td class="px-6 py-4 whitespace-nowrap">
                    <select name="novas_pecas[${index}][tipo_id]" class="tipo-select w-full px-3 py-2 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        ${opcoesSelect}
                    </select>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <input type="number" min="1" name="novas_pecas[${index}][quantidade]"
                           class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="1" required>
                    <input type="hidden" name="novas_pecas[${index}][peso]" value="0">
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <button type="button" onclick="removerLinhaPeca(this)"
                            class="inline-flex items-center px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Remover
                    </button>
                </td>
            </tr>
        `;
    }

    // Função para adicionar nova linha de peça (para coletas por peso)
    window.adicionarLinhaPeca = function() {
        const tabela = tabelaPecasEmpacotamento;
        const linhas = tabela.querySelectorAll('.linha-nova-peca');
        const novoIndex = linhas.length;

        // Criar opções do select
        let opcoesSelect = '<option value="">Selecione um tipo</option>';
        tiposDisponiveis.forEach(function(tipo) {
            opcoesSelect += `<option value="${tipo.id}">${tipo.nome} (${tipo.categoria})</option>`;
        });

        // Criar nova linha
        const novaLinha = document.createElement('tr');
        novaLinha.className = 'linha-nova-peca';
        novaLinha.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap">
                <select name="novas_pecas[${novoIndex}][tipo_id]" class="tipo-select w-full px-3 py-2 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    ${opcoesSelect}
                </select>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <input type="number" min="1" name="novas_pecas[${novoIndex}][quantidade]"
                       class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="1" required>
                <input type="hidden" name="novas_pecas[${novoIndex}][peso]" value="0">
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <button type="button" onclick="removerLinhaPeca(this)"
                        class="inline-flex items-center px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Remover
                </button>
            </td>
        `;

        tabela.appendChild(novaLinha);
    };

    // Função para remover linha de peça
    window.removerLinhaPeca = function(botao) {
        const linha = botao.closest('tr');
        const tabela = tabelaPecasEmpacotamento;

        // Não permitir remover se for a única linha
        if (tabela.querySelectorAll('.linha-nova-peca').length > 1) {
            linha.remove();
        } else {
            alert('Deve haver pelo menos uma linha de peça.');
        }
    };

    // Carregar dados iniciais se houver coleta selecionada
    if (coletaSelect.value) {
        carregarDadosColeta();
    }
});
</script>
@endpush
@endsection
