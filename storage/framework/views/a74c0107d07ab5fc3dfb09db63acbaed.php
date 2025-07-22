<?php $__env->startSection('title', 'Novo Empacotamento'); ?>

<?php $__env->startSection('content'); ?>
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
            <a href="<?php echo e(route('empacotamento.index')); ?>" 
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
                    <form method="POST" action="<?php echo e(route('empacotamento.store')); ?>" id="formEmpacotamento">
                        <?php echo csrf_field(); ?>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="coleta_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Coleta <span class="text-red-500">*</span>
                                </label>
                                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm <?php $__errorArgs = ['coleta_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                        id="coleta_id" name="coleta_id" required>
                                    <option value="">Selecione uma coleta</option>
                                    <?php $__currentLoopData = $coletas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coleta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($coleta->id); ?>" 
                                                <?php echo e(old('coleta_id') == $coleta->id ? 'selected' : ''); ?>

                                                data-estabelecimento="<?php echo e($coleta->estabelecimento->razao_social); ?>"
                                                data-peso="<?php echo e($coleta->peso_total); ?>"
                                                data-valor="<?php echo e($coleta->valor_total); ?>"
                                                data-pecas="<?php echo e($coleta->pecas->count()); ?>">
                                            <?php echo e($coleta->numero_coleta); ?> - <?php echo e($coleta->estabelecimento->razao_social); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['coleta_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div>
                                <label for="motorista_id" class="block text-sm font-medium text-gray-700 mb-2">Motorista</label>
                                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm <?php $__errorArgs = ['motorista_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                        id="motorista_id" name="motorista_id">
                                    <option value="">Selecione um motorista</option>
                                    <?php $__currentLoopData = $motoristas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $motorista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($motorista->id); ?>" <?php echo e(old('motorista_id') == $motorista->id ? 'selected' : ''); ?>>
                                            <?php echo e($motorista->nome); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['motorista_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="data_empacotamento" class="block text-sm font-medium text-gray-700 mb-2">
                                Data/Hora do Empacotamento <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm <?php $__errorArgs = ['data_empacotamento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="data_empacotamento" name="data_empacotamento" 
                                   value="<?php echo e(old('data_empacotamento', now()->format('Y-m-d\TH:i'))); ?>" 
                                   required>
                            <?php $__errorArgs = ['data_empacotamento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mt-4">
                            <label for="observacoes_empacotamento" class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
                            <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm <?php $__errorArgs = ['observacoes_empacotamento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      id="observacoes_empacotamento" name="observacoes_empacotamento" rows="3" 
                                      placeholder="Observações sobre o empacotamento..."><?php echo e(old('observacoes_empacotamento')); ?></textarea>
                            <?php $__errorArgs = ['observacoes_empacotamento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="flex justify-end space-x-3 mt-6">
                            <a href="<?php echo e(route('empacotamento.index')); ?>" 
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

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\lavanderianovo\resources\views/empacotamento/create.blade.php ENDPATH**/ ?>