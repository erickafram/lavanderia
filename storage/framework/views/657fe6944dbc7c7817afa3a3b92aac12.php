

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
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                Peças Coletadas
            </h3>
            <button type="button" 
                    id="add-peca" 
                    class="inline-flex items-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Adicionar Peça
            </button>
        </div>

        <div id="pecas-container">
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
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Tipo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo *</label>
                        <select name="pecas[0][tipo_id]" 
                                class="tipo-select w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm"
                                required>
                            <option value="">Selecione</option>
                            <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($tipo->id); ?>" data-preco="<?php echo e($tipo->preco_kg); ?>">
                                    <?php echo e($tipo->nome); ?> (R$ <?php echo e(number_format($tipo->preco_kg, 2, ',', '.')); ?>/kg)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Quantidade -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantidade *</label>
                        <input type="number" 
                               name="pecas[0][quantidade]" 
                               min="1" 
                               step="1"
                               class="quantidade-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm"
                               required>
                    </div>

                    <!-- Peso -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Peso (kg) *</label>
                        <input type="number" 
                               name="pecas[0][peso]" 
                               min="0.01" 
                               step="0.01"
                               class="peso-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm"
                               required>
                    </div>

                    <!-- Subtotal -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subtotal</label>
                        <input type="text" 
                               class="subtotal-display w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg text-sm"
                               readonly
                               placeholder="R$ 0,00">
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
                    <div class="text-gray-900">Peso: <span id="peso-total">0,00</span> kg</div>
                    <div class="text-green-600">Valor: R$ <span id="valor-total">0,00</span></div>
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
    
    // Calcular subtotais quando peso ou tipo mudar
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('peso-input')) {
            calculateSubtotal(e.target.closest('.peca-item'));
        }
    });
    
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('tipo-select')) {
            calculateSubtotal(e.target.closest('.peca-item'));
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
            }
        });
        
        // Atualizar nomes dos campos
        const index = pecaCount;
        template.querySelectorAll('[name^="pecas[0]"]').forEach(input => {
            input.name = input.name.replace('pecas[0]', `pecas[${index}]`);
        });
        
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
    
    function calculateSubtotal(pecaItem) {
        const tipoSelect = pecaItem.querySelector('.tipo-select');
        const pesoInput = pecaItem.querySelector('.peso-input');
        const subtotalDisplay = pecaItem.querySelector('.subtotal-display');
        
        const preco = parseFloat(tipoSelect.options[tipoSelect.selectedIndex]?.dataset.preco || 0);
        const peso = parseFloat(pesoInput.value || 0);
        const subtotal = preco * peso;
        
        subtotalDisplay.value = subtotal > 0 ? `R$ ${subtotal.toFixed(2).replace('.', ',')}` : 'R$ 0,00';
        
        calculateTotals();
    }
    
    function calculateTotals() {
        let pesoTotal = 0;
        let valorTotal = 0;
        
        document.querySelectorAll('.peca-item').forEach(item => {
            const tipoSelect = item.querySelector('.tipo-select');
            const pesoInput = item.querySelector('.peso-input');
            
            const preco = parseFloat(tipoSelect.options[tipoSelect.selectedIndex]?.dataset.preco || 0);
            const peso = parseFloat(pesoInput.value || 0);
            
            pesoTotal += peso;
            valorTotal += preco * peso;
        });
        
        document.getElementById('peso-total').textContent = pesoTotal.toFixed(2).replace('.', ',');
        document.getElementById('valor-total').textContent = valorTotal.toFixed(2).replace('.', ',');
    }
    
    // Inicializar
    updateRemoveButtons();
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\lavanderianovo\resources\views/coletas/add-pecas.blade.php ENDPATH**/ ?>