<?php $__env->startSection('title', 'Coleta Express - Sistema de Gestão de Lavanderia'); ?>

<?php $__env->startSection('content'); ?>
<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
    <div>
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">
            <svg class="inline w-5 h-5 sm:w-6 sm:h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
            Coleta Express
        </h1>
        <p class="text-sm text-gray-600">Registre uma coleta completa de forma rápida e objetiva</p>
        <p class="text-xs text-gray-500 mt-1">
            <kbd class="px-1 py-0.5 bg-gray-100 rounded text-xs">Ctrl+N</kbd> Adicionar peça •
            <kbd class="px-1 py-0.5 bg-gray-100 rounded text-xs">Ctrl+Enter</kbd> Finalizar
        </p>
    </div>
    <div class="flex gap-2 mt-3 sm:mt-0">
        <a href="<?php echo e(route('coletas.index')); ?>" 
           class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition-colors duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Voltar
        </a>
    </div>
</div>

<!-- Formulário Express -->
<form method="POST" action="<?php echo e(route('coletas.store-express')); ?>" class="space-y-6" id="coleta-express-form">
    <?php echo csrf_field(); ?>
    
    <!-- Informações Básicas - Compactas -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Dados da Coleta
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Estabelecimento -->
            <div>
                <label for="estabelecimento_id" class="block text-sm font-medium text-gray-700 mb-1">
                    Estabelecimento *
                </label>
                <select id="estabelecimento_id" 
                        name="estabelecimento_id" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm <?php $__errorArgs = ['estabelecimento_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        required>
                    <option value="">Selecione um estabelecimento</option>
                    <?php $__currentLoopData = $estabelecimentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estabelecimento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($estabelecimento->id); ?>" <?php echo e(old('estabelecimento_id') == $estabelecimento->id ? 'selected' : ''); ?>>
                            <?php echo e($estabelecimento->razao_social); ?>

                            <?php if($estabelecimento->nome_fantasia): ?>
                                (<?php echo e($estabelecimento->nome_fantasia); ?>)
                            <?php endif; ?>
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['estabelecimento_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Data de Agendamento -->
            <div>
                <label for="data_agendamento" class="block text-sm font-medium text-gray-700 mb-1">
                    Data e Hora *
                </label>
                <input type="datetime-local" 
                       id="data_agendamento" 
                       name="data_agendamento" 
                       value="<?php echo e(old('data_agendamento', now()->format('Y-m-d\TH:i'))); ?>"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm <?php $__errorArgs = ['data_agendamento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       required>
                <?php $__errorArgs = ['data_agendamento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <!-- Motorista/Acompanhante -->
            <div>
                <label for="acompanhante_id" class="block text-sm font-medium text-gray-700 mb-1">
                    Motorista/Acompanhante
                </label>
                <select id="acompanhante_id" 
                        name="acompanhante_id" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                    <option value="">Nenhum</option>
                    <?php $__currentLoopData = $motoristas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $motorista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($motorista->id); ?>" <?php echo e(old('acompanhante_id') == $motorista->id ? 'selected' : ''); ?>>
                            <?php echo e($motorista->nome); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <!-- Observações -->
            <div>
                <label for="observacoes" class="block text-sm font-medium text-gray-700 mb-1">
                    Observações
                </label>
                <input type="text" 
                       id="observacoes" 
                       name="observacoes" 
                       value="<?php echo e(old('observacoes')); ?>"
                       placeholder="Observações gerais da coleta..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
            </div>
        </div>
    </div>

    <!-- Peças da Coleta -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                Peças Coletadas
            </h3>
            <button type="button"
                    id="add-peca-btn"
                    class="inline-flex items-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Adicionar
            </button>
        </div>

        <div id="pecas-container">
            <!-- Template da primeira peça será inserido via JavaScript -->
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

        <!-- Resumo dos Totais -->
        <div class="border-t border-gray-200 pt-4 mt-4">
            <div class="bg-gray-50 rounded-lg p-3">
                <div class="flex justify-between items-center text-sm">
                    <span class="font-medium text-gray-700">Resumo:</span>
                    <div class="text-right">
                        <div id="total-pecas" class="text-green-600 font-semibold" style="display: none;">
                            <span id="pecas-count">0</span> peças
                        </div>
                        <div id="total-peso" class="text-blue-600 font-semibold" style="display: none;">
                            <span id="peso-total">0,00</span> kg
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botões de Ação -->
    <div class="flex flex-col sm:flex-row gap-3 sm:justify-end">
        <a href="<?php echo e(route('coletas.index')); ?>" 
           class="inline-flex items-center justify-center px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-700 text-sm font-medium rounded-xl transition-colors duration-200">
            Cancelar
        </a>
        <button type="submit"
                id="submit-btn"
                class="inline-flex items-center justify-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
            <svg class="w-4 h-4 mr-2 submit-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <svg class="w-4 h-4 mr-2 loading-icon animate-spin hidden" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="submit-text">Finalizar Coleta</span>
        </button>
    </div>
</form>

<!-- Template da Peça (Hidden) -->
<template id="peca-template">
    <div class="peca-item border border-gray-200 rounded-lg p-3 mb-3 bg-gray-50">
        <div class="flex items-center justify-between mb-3">
            <h4 class="text-sm font-medium text-gray-700 peca-title">Peça 1</h4>
            <button type="button"
                    class="remove-peca text-red-600 hover:text-red-800 transition-colors duration-200"
                    style="display: none;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <!-- Tipo -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo *</label>
                <select name="pecas[0][tipo_id]"
                        class="tipo-select w-full px-2 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm"
                        required>
                    <option value="">Selecione</option>
                    <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($tipo->id); ?>"><?php echo e($tipo->nome); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <!-- Modo de Coleta -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Modo *</label>
                <select name="pecas[0][modo_coleta]" class="modo-coleta-select w-full px-2 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm" required>
                    <option value="quantidade">Quantidade</option>
                    <option value="peso">Peso (kg)</option>
                </select>
            </div>

            <!-- Quantidade/Peso -->
            <div class="valor-container">
                <label class="block text-sm font-medium text-gray-700 mb-1 valor-label">Quantidade *</label>
                <input type="number"
                       name="pecas[0][quantidade]"
                       min="1"
                       step="1"
                       class="valor-input w-full px-2 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm"
                       required>
                <input type="number"
                       name="pecas[0][peso]"
                       min="0.01"
                       step="0.01"
                       class="valor-input w-full px-2 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm"
                       style="display: none;">
            </div>

            <!-- Observações -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Obs.</label>
                <input type="text"
                       name="pecas[0][observacoes]"
                       placeholder="Observações..."
                       class="w-full px-2 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
            </div>
        </div>
    </div>
</template>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let pecaCount = 0;

    // Adicionar primeira peça automaticamente
    addPeca();

    // Event listeners
    document.getElementById('add-peca-btn').addEventListener('click', addPeca);

    // Atalhos de teclado
    document.addEventListener('keydown', function(e) {
        // Ctrl + Enter para submeter o formulário
        if (e.ctrlKey && e.key === 'Enter') {
            e.preventDefault();
            document.getElementById('coleta-express-form').submit();
        }
        // Ctrl + N para adicionar nova peça
        if (e.ctrlKey && e.key === 'n') {
            e.preventDefault();
            addPeca();
        }
    });

    // Delegação de eventos para elementos dinâmicos
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-peca')) {
            removePeca(e.target.closest('.peca-item'));
        }
    });

    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('modo-coleta-select')) {
            toggleModoColeta(e.target.closest('.peca-item'));
        }
        if (e.target.classList.contains('valor-input') || e.target.classList.contains('tipo-select')) {
            calculateTotals();
        }
    });

    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('valor-input')) {
            calculateTotals();
        }
    });

    function addPeca() {
        const template = document.getElementById('peca-template');
        const container = document.getElementById('pecas-container');
        const clone = template.content.cloneNode(true);

        // Atualizar índices e nomes
        const index = pecaCount;
        clone.querySelectorAll('[name^="pecas[0]"]').forEach(input => {
            input.name = input.name.replace('pecas[0]', `pecas[${index}]`);
        });

        // Atualizar título
        clone.querySelector('.peca-title').textContent = `Peça ${index + 1}`;

        container.appendChild(clone);
        pecaCount++;

        updateRemoveButtons();
        calculateTotals();
    }

    function removePeca(pecaItem) {
        if (document.querySelectorAll('.peca-item').length > 1) {
            pecaItem.remove();
            updatePecaTitles();
            updateRemoveButtons();
            calculateTotals();
        }
    }

    function updatePecaTitles() {
        document.querySelectorAll('.peca-item').forEach((item, index) => {
            item.querySelector('.peca-title').textContent = `Peça ${index + 1}`;
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
        const modoSelect = pecaItem.querySelector('.modo-coleta-select');
        const valorLabel = pecaItem.querySelector('.valor-label');
        const quantidadeInput = pecaItem.querySelector('input[name*="[quantidade]"]');
        const pesoInput = pecaItem.querySelector('input[name*="[peso]"]');

        if (modoSelect.value === 'quantidade') {
            valorLabel.textContent = 'Quantidade *';
            quantidadeInput.style.display = 'block';
            pesoInput.style.display = 'none';
            quantidadeInput.required = true;
            pesoInput.required = false;
            pesoInput.value = '';
        } else {
            valorLabel.textContent = 'Peso (kg) *';
            quantidadeInput.style.display = 'none';
            pesoInput.style.display = 'block';
            quantidadeInput.required = false;
            pesoInput.required = true;
            quantidadeInput.value = '';
        }

        calculateTotals();
    }

    function calculateTotals() {
        let totalPecas = 0;
        let totalPeso = 0;
        let temPecas = false;
        let temPeso = false;

        document.querySelectorAll('.peca-item').forEach(item => {
            const modoSelect = item.querySelector('.modo-coleta-select');
            const quantidadeInput = item.querySelector('input[name*="[quantidade]"]');
            const pesoInput = item.querySelector('input[name*="[peso]"]');

            if (modoSelect.value === 'quantidade') {
                const quantidade = parseInt(quantidadeInput.value || 0);
                if (quantidade > 0) {
                    totalPecas += quantidade;
                    temPecas = true;
                }
            } else {
                const peso = parseFloat(pesoInput.value || 0);
                if (peso > 0) {
                    totalPeso += peso;
                    temPeso = true;
                }
            }
        });

        // Atualizar displays
        const totalPecasDiv = document.getElementById('total-pecas');
        const totalPesoDiv = document.getElementById('total-peso');

        if (temPecas) {
            totalPecasDiv.style.display = 'block';
            document.getElementById('pecas-count').textContent = totalPecas;
        } else {
            totalPecasDiv.style.display = 'none';
        }

        if (temPeso) {
            totalPesoDiv.style.display = 'block';
            document.getElementById('peso-total').textContent = totalPeso.toFixed(2).replace('.', ',');
        } else {
            totalPesoDiv.style.display = 'none';
        }
    }

    // Validação do formulário
    document.getElementById('coleta-express-form').addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submit-btn');
        const submitIcon = submitBtn.querySelector('.submit-icon');
        const loadingIcon = submitBtn.querySelector('.loading-icon');
        const submitText = submitBtn.querySelector('.submit-text');
        const pecasItems = document.querySelectorAll('.peca-item');
        let hasValidPeca = false;

        pecasItems.forEach(item => {
            const tipoSelect = item.querySelector('.tipo-select');
            const modoSelect = item.querySelector('.modo-coleta-select');
            const quantidadeInput = item.querySelector('input[name*="[quantidade]"]');
            const pesoInput = item.querySelector('input[name*="[peso]"]');

            if (tipoSelect.value) {
                if (modoSelect.value === 'quantidade' && quantidadeInput.value > 0) {
                    hasValidPeca = true;
                } else if (modoSelect.value === 'peso' && pesoInput.value > 0) {
                    hasValidPeca = true;
                }
            }
        });

        if (!hasValidPeca) {
            e.preventDefault();
            alert('Adicione pelo menos uma peça válida à coleta.');
            return false;
        }

        // Mostrar loading
        submitBtn.disabled = true;
        submitIcon.classList.add('hidden');
        loadingIcon.classList.remove('hidden');
        submitText.textContent = 'Processando...';
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\lavanderia\resources\views/coletas/create-express.blade.php ENDPATH**/ ?>