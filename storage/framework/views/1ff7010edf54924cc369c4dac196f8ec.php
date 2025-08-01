

<?php $__env->startSection('title', 'Adicionar Peças - Sistema de Gestão de Lavanderia'); ?>

<?php $__env->startSection('content'); ?>
<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
    <div>
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">
            <svg class="inline w-5 h-5 sm:w-6 sm:h-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
            Adicionar Peças à Coleta
        </h1>
        <p class="text-sm text-gray-600">Coleta <?php echo e($coleta->numero_coleta); ?> - <?php echo e($coleta->estabelecimento->razao_social); ?></p>
    </div>
    <div class="flex gap-2 mt-3 sm:mt-0">
        <a href="<?php echo e(route('coletas.show', $coleta->id)); ?>" 
           class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition-colors duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Voltar
        </a>
    </div>
</div>

<!-- Informações da Coleta -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
        <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        Informações da Coleta
    </h3>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-500 mb-1">Número da Coleta</label>
            <p class="text-gray-900 font-semibold"><?php echo e($coleta->numero_coleta); ?></p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-500 mb-1">Estabelecimento</label>
            <p class="text-gray-900"><?php echo e($coleta->estabelecimento->razao_social); ?></p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-500 mb-1">Data Agendada</label>
            <p class="text-gray-900"><?php echo e($coleta->data_agendamento->format('d/m/Y H:i')); ?></p>
        </div>
    </div>

    <?php if($coleta->observacoes): ?>
    <div class="mt-4">
        <label class="block text-sm font-medium text-gray-500 mb-1">Observações</label>
        <p class="text-gray-900"><?php echo e($coleta->observacoes); ?></p>
    </div>
    <?php endif; ?>
</div>

<!-- Formulário de Peças -->
<form method="POST" action="<?php echo e(route('coletas.store-pecas', $coleta->id)); ?>" class="space-y-6">
    <?php echo csrf_field(); ?>
    
    <!-- Peças da Coleta -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                Peças Coletadas
            </h3>
        </div>

        <div id="pecas-container">
            <?php if($coleta->pecas->count() > 0): ?>
                <?php $__currentLoopData = $coleta->pecas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $peca): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <!-- Peça existente -->
                <div class="peca-item border border-gray-200 rounded-lg p-4 mb-4">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="text-sm font-medium text-gray-700">
                        <?php if($coleta->pecas->count() > 0): ?>
                            Peça <?php echo e($loop->iteration); ?>

                        <?php else: ?>
                            Peça 1
                        <?php endif; ?>
                    </h4>
                    <button type="button"
                            class="remove-peca text-red-600 hover:text-red-800 transition-colors duration-200"
                            style="display: none;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Modo de Coleta -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Modo de Coleta *</label>
                    <div class="flex space-x-4">
                        <?php
                            $currentIndex = $coleta->pecas->count() > 0 ? $index : 0;
                            $currentPeca = $coleta->pecas->count() > 0 ? $peca : null;
                            $modoColeta = $currentPeca ? ($currentPeca->quantidade > 0 ? 'quantidade' : 'peso') : 'quantidade';
                        ?>
                        <label class="flex items-center">
                            <input type="radio"
                                   name="pecas[<?php echo e($currentIndex); ?>][modo_coleta]"
                                   value="quantidade"
                                   class="modo-coleta-radio text-primary-600 focus:ring-primary-500"
                                   <?php echo e($modoColeta === 'quantidade' ? 'checked' : ''); ?>>
                            <span class="ml-2 text-sm text-gray-700">Por Quantidade de Peças</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio"
                                   name="pecas[<?php echo e($currentIndex); ?>][modo_coleta]"
                                   value="peso"
                                   class="modo-coleta-radio text-primary-600 focus:ring-primary-500"
                                   <?php echo e($modoColeta === 'peso' ? 'checked' : ''); ?>>
                            <span class="ml-2 text-sm text-gray-700">Por Peso (kg)</span>
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Tipo -->
                    <div class="campo-tipo">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo *</label>
                        <select name="pecas[<?php echo e($currentIndex); ?>][tipo_id]"
                                class="tipo-select w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm"
                                required>
                            <option value="">Selecione</option>
                            <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($tipo->id); ?>" <?php echo e($currentPeca && $currentPeca->tipo_id == $tipo->id ? 'selected' : ''); ?>>
                                    <?php echo e($tipo->nome); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <div class="tipo-peso-info mt-1 text-xs text-gray-500" style="display: none;">
                            Tipo será definido automaticamente como "Peso" para coletas por peso
                        </div>
                    </div>

                    <!-- Quantidade (visível apenas no modo quantidade) -->
                    <div class="campo-quantidade" style="<?php echo e($modoColeta === 'peso' ? 'display: none;' : ''); ?>">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantidade de Peças *</label>
                        <input type="number"
                               name="pecas[<?php echo e($currentIndex); ?>][quantidade]"
                               min="1"
                               step="1"
                               value="<?php echo e($currentPeca && $currentPeca->quantidade > 0 ? $currentPeca->quantidade : ''); ?>"
                               class="quantidade-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm"
                               required>
                    </div>

                    <!-- Peso (visível apenas no modo peso) -->
                    <div class="campo-peso" style="<?php echo e($modoColeta === 'quantidade' ? 'display: none;' : ''); ?>">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Peso (kg) *</label>
                        <input type="number"
                               name="pecas[<?php echo e($currentIndex); ?>][peso]"
                               min="0.01"
                               step="0.01"
                               value="<?php echo e($currentPeca && $currentPeca->peso > 0 ? $currentPeca->peso : ''); ?>"
                               class="peso-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                    </div>

                    <!-- Resumo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Resumo</label>
                        <input type="text"
                               class="subtotal-display w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg text-sm"
                               readonly
                               placeholder="0 peças">
                    </div>
                </div>

                <!-- Observações da Peça -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Observações</label>
                    <input type="text"
                           name="pecas[<?php echo e($currentIndex); ?>][observacoes]"
                           value="<?php echo e($currentPeca ? $currentPeca->observacoes : ''); ?>"
                           placeholder="Observações específicas desta peça..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                </div>
            </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
            <!-- Primeira peça (template) -->
            <div class="peca-item border border-gray-200 rounded-lg p-4 mb-4">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="text-sm font-medium text-gray-700">Peça 1</h4>
                    <button type="button"
                            class="remove-peca text-red-600 hover:text-red-800 transition-colors duration-200"
                            style="display: none;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modo de Coleta -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Modo de Coleta *</label>
                    <div class="flex space-x-4">
                        <label class="flex items-center">
                            <input type="radio"
                                   name="pecas[0][modo_coleta]"
                                   value="quantidade"
                                   class="modo-coleta-radio text-primary-600 focus:ring-primary-500"
                                   checked>
                            <span class="ml-2 text-sm text-gray-700">Por Quantidade de Peças</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio"
                                   name="pecas[0][modo_coleta]"
                                   value="peso"
                                   class="modo-coleta-radio text-primary-600 focus:ring-primary-500">
                            <span class="ml-2 text-sm text-gray-700">Por Peso (kg)</span>
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Tipo -->
                    <div class="campo-tipo">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo *</label>
                        <select name="pecas[0][tipo_id]"
                                class="tipo-select w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm"
                                required>
                            <option value="">Selecione</option>
                            <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($tipo->id); ?>">
                                    <?php echo e($tipo->nome); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <div class="tipo-peso-info mt-1 text-xs text-gray-500" style="display: none;">
                            Tipo será definido automaticamente como "Peso" para coletas por peso
                        </div>
                    </div>

                    <!-- Quantidade (visível apenas no modo quantidade) -->
                    <div class="campo-quantidade">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantidade de Peças *</label>
                        <input type="number"
                               name="pecas[0][quantidade]"
                               min="1"
                               step="1"
                               class="quantidade-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm"
                               required>
                    </div>

                    <!-- Peso (visível apenas no modo peso) -->
                    <div class="campo-peso" style="display: none;">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Peso (kg) *</label>
                        <input type="number"
                               name="pecas[0][peso]"
                               min="0.01"
                               step="0.01"
                               class="peso-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                    </div>

                    <!-- Resumo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Resumo</label>
                        <input type="text"
                               class="subtotal-display w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg text-sm"
                               readonly
                               placeholder="0 peças">
                    </div>
                </div>

                <!-- Observações da Peça -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Observações</label>
                    <input type="text"
                           name="pecas[0][observacoes]"
                           placeholder="Observações específicas desta peça..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Botão Adicionar Peça -->
        <div class="text-center mt-4">
            <button type="button"
                    id="add-peca"
                    class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Adicionar Peça
            </button>
        </div>

        <?php $__errorArgs = ['pecas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-red-600 text-sm mt-2"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <!-- Totais -->
        <div class="border-t border-gray-200 pt-4 mt-4">
            <div class="flex justify-between items-center text-lg font-semibold">
                <span class="text-gray-700">Total:</span>
                <div class="text-right">
                    <div id="total-peso" class="text-gray-900" style="display: none;">Peso: <span id="peso-total">0,00</span> kg</div>
                    <div id="total-pecas" class="text-blue-600" style="display: none;">Peças: <span id="pecas-total">0</span> unidades</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botões -->
    <div class="flex flex-col sm:flex-row gap-3 sm:justify-end">
        <a href="<?php echo e(route('coletas.show', $coleta->id)); ?>" 
           class="inline-flex items-center justify-center px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-700 text-sm font-medium rounded-xl transition-colors duration-200">
            Cancelar
        </a>
        <button type="submit" 
                class="inline-flex items-center justify-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Finalizar Coleta
        </button>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let pecaCount = 1;
    
    // Adicionar nova peça
    document.getElementById('add-peca').addEventListener('click', function() {
        addPecaField();
    });
    
    // Remover peça
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-peca')) {
            e.target.closest('.peca-item').remove();
            updatePecaNumbers();
            updateRemoveButtons();
            calculateTotals();
        }
    });
    
    // Calcular subtotais quando quantidade ou peso mudar
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('quantidade-input') || e.target.classList.contains('peso-input')) {
            calculateSubtotal(e.target.closest('.peca-item'));
        }
    });

    // Alternar modo de coleta
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('modo-coleta-radio')) {
            toggleModoColeta(e.target.closest('.peca-item'));
        }
    });
    
    function addPecaField() {
        const container = document.getElementById('pecas-container');
        const template = container.querySelector('.peca-item').cloneNode(true);

        // Limpar valores
        template.querySelectorAll('input, select').forEach(input => {
            if (input.type === 'text' || input.type === 'number') {
                input.value = '';
            } else if (input.tagName === 'SELECT') {
                input.selectedIndex = 0;
            } else if (input.type === 'radio') {
                input.checked = input.value === 'quantidade'; // Padrão: quantidade
            }
        });

        // Atualizar nomes dos campos
        const index = pecaCount;
        template.querySelectorAll('[name^="pecas[0]"]').forEach(input => {
            input.name = input.name.replace('pecas[0]', `pecas[${index}]`);
        });

        // Configurar modo padrão (quantidade)
        toggleModoColeta(template);

        container.appendChild(template);
        pecaCount++;
        updatePecaNumbers();
        updateRemoveButtons();
    }
    
    function updatePecaNumbers() {
        document.querySelectorAll('.peca-item').forEach((item, index) => {
            item.querySelector('h4').textContent = `Peça ${index + 1}`;
        });
    }
    
    function updateRemoveButtons() {
        const items = document.querySelectorAll('.peca-item');
        items.forEach(item => {
            const removeBtn = item.querySelector('.remove-peca');
            if (items.length > 1) {
                removeBtn.style.display = 'block';
            } else {
                removeBtn.style.display = 'none';
            }
        });
    }
    
    function toggleModoColeta(pecaItem) {
        const modoRadio = pecaItem.querySelector('input[name*="[modo_coleta]"]:checked');
        const campoQuantidade = pecaItem.querySelector('.campo-quantidade');
        const campoPeso = pecaItem.querySelector('.campo-peso');
        const campoTipo = pecaItem.querySelector('.campo-tipo');
        const tipoSelect = pecaItem.querySelector('.tipo-select');
        const tipoPesoInfo = pecaItem.querySelector('.tipo-peso-info');
        const quantidadeInput = pecaItem.querySelector('.quantidade-input');
        const pesoInput = pecaItem.querySelector('.peso-input');

        if (modoRadio.value === 'quantidade') {
            // Modo quantidade
            campoQuantidade.style.display = 'block';
            campoPeso.style.display = 'none';
            quantidadeInput.required = true;
            pesoInput.required = false;
            pesoInput.value = ''; // Limpar valor do peso

            // Habilitar campo tipo
            tipoSelect.disabled = false;
            tipoSelect.required = true;
            campoTipo.style.opacity = '1';
            tipoPesoInfo.style.display = 'none';
        } else {
            // Modo peso
            campoQuantidade.style.display = 'none';
            campoPeso.style.display = 'block';
            quantidadeInput.required = false;
            pesoInput.required = true;
            quantidadeInput.value = ''; // Limpar valor da quantidade

            // Desabilitar campo tipo
            tipoSelect.disabled = true;
            tipoSelect.required = false;
            tipoSelect.value = ''; // Limpar seleção
            campoTipo.style.opacity = '0.5';
            tipoPesoInfo.style.display = 'block';
        }

        calculateSubtotal(pecaItem);
    }

    function calculateSubtotal(pecaItem) {
        const modoRadio = pecaItem.querySelector('input[name*="[modo_coleta]"]:checked');
        const quantidadeInput = pecaItem.querySelector('.quantidade-input');
        const pesoInput = pecaItem.querySelector('.peso-input');
        const subtotalDisplay = pecaItem.querySelector('.subtotal-display');

        if (modoRadio.value === 'quantidade') {
            const quantidade = parseInt(quantidadeInput.value || 0);
            subtotalDisplay.value = quantidade > 0 ? `${quantidade} peça${quantidade > 1 ? 's' : ''}` : '0 peças';
        } else {
            const peso = parseFloat(pesoInput.value || 0);
            subtotalDisplay.value = peso > 0 ? `${peso.toFixed(2).replace('.', ',')} kg` : '0,00 kg';
        }

        calculateTotals();
    }
    
    function calculateTotals() {
        let pesoTotal = 0;
        let pecasTotal = 0;
        let temPeso = false;
        let temQuantidade = false;

        document.querySelectorAll('.peca-item').forEach(item => {
            const modoRadio = item.querySelector('input[name*="[modo_coleta]"]:checked');
            const quantidadeInput = item.querySelector('.quantidade-input');
            const pesoInput = item.querySelector('.peso-input');

            if (modoRadio && modoRadio.value === 'peso') {
                const peso = parseFloat(pesoInput.value || 0);
                if (peso > 0) {
                    pesoTotal += peso;
                    temPeso = true;
                }
            } else {
                // Para modo quantidade
                const quantidade = parseInt(quantidadeInput.value || 0);
                if (quantidade > 0) {
                    pecasTotal += quantidade;
                    temQuantidade = true;
                }
            }
        });

        // Mostrar apenas o total relevante
        const totalPeso = document.getElementById('total-peso');
        const totalPecas = document.getElementById('total-pecas');

        if (temPeso && !temQuantidade) {
            // Só tem peso
            totalPeso.style.display = 'block';
            totalPecas.style.display = 'none';
            document.getElementById('peso-total').textContent = pesoTotal.toFixed(2).replace('.', ',');
        } else if (temQuantidade && !temPeso) {
            // Só tem quantidade
            totalPeso.style.display = 'none';
            totalPecas.style.display = 'block';
            document.getElementById('pecas-total').textContent = pecasTotal;
        } else if (temPeso && temQuantidade) {
            // Tem ambos - mostrar os dois
            totalPeso.style.display = 'block';
            totalPecas.style.display = 'block';
            document.getElementById('peso-total').textContent = pesoTotal.toFixed(2).replace('.', ',');
            document.getElementById('pecas-total').textContent = pecasTotal;
        } else {
            // Não tem nada - esconder ambos
            totalPeso.style.display = 'none';
            totalPecas.style.display = 'none';
        }
    }
    
    // Inicializar
    updateRemoveButtons();

    // Aplicar lógica de modo de coleta para todas as peças existentes
    document.querySelectorAll('.peca-item').forEach(item => {
        toggleModoColeta(item);
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\lavanderia\resources\views/coletas/add-pecas.blade.php ENDPATH**/ ?>