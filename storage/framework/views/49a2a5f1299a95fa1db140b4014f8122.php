<?php $__env->startSection('title', 'Editar Pesagem'); ?>

<?php $__env->startSection('content'); ?>
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
            <a href="<?php echo e(route('pesagem.show', $pesagem->id)); ?>"
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                Visualizar
            </a>
            <a href="<?php echo e(route('pesagem.index')); ?>"
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
                    <form method="POST" action="<?php echo e(route('pesagem.update', $pesagem->id)); ?>" id="formPesagem">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="coleta_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Coleta <span class="text-red-500">*</span>
                                </label>
                                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm <?php $__errorArgs = ['coleta_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="coleta_id" name="coleta_id" required>
                                    <option value="">Selecione uma coleta</option>
                                    <?php $__currentLoopData = $coletas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coletaOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($coletaOption->id); ?>"
                                                <?php echo e((old('coleta_id', $pesagem->coleta_id) == $coletaOption->id) ? 'selected' : ''); ?>

                                                data-estabelecimento="<?php echo e($coletaOption->estabelecimento->razao_social); ?>">
                                            <?php echo e($coletaOption->numero_coleta); ?> - <?php echo e($coletaOption->estabelecimento->razao_social); ?>

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
                                <label for="tipo_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tipo de Peça <span class="text-red-500">*</span>
                                </label>
                                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm <?php $__errorArgs = ['tipo_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="tipo_id" name="tipo_id" required>
                                    <option value="">Selecione um tipo</option>
                                    <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($tipo->id); ?>"
                                                <?php echo e(old('tipo_id', $pesagem->tipo_id) == $tipo->id ? 'selected' : ''); ?>

                                                data-preco="<?php echo e($tipo->preco_kg); ?>">
                                            <?php echo e($tipo->nome); ?> (R$ <?php echo e(number_format($tipo->preco_kg, 2, ',', '.')); ?>/kg)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['tipo_id'];
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

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                            <div>
                                <label for="peso" class="block text-sm font-medium text-gray-700 mb-2">
                                    Peso (kg) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" step="0.01" min="0.01" max="999.99"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm <?php $__errorArgs = ['peso'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="peso" name="peso" value="<?php echo e(old('peso', $pesagem->peso)); ?>"
                                       placeholder="0,00" required>
                                <?php $__errorArgs = ['peso'];
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
                                <label for="quantidade" class="block text-sm font-medium text-gray-700 mb-2">
                                    Quantidade <span class="text-red-500">*</span>
                                </label>
                                <input type="number" min="1" max="999"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm <?php $__errorArgs = ['quantidade'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="quantidade" name="quantidade" value="<?php echo e(old('quantidade', $pesagem->quantidade)); ?>"
                                       required>
                                <?php $__errorArgs = ['quantidade'];
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
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm <?php $__errorArgs = ['data_pesagem'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="data_pesagem" name="data_pesagem"
                                       value="<?php echo e(old('data_pesagem', $pesagem->data_pesagem->format('Y-m-d\TH:i'))); ?>"
                                       required>
                                <?php $__errorArgs = ['data_pesagem'];
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
                                <label for="local_pesagem" class="block text-sm font-medium text-gray-700 mb-2">Local da Pesagem</label>
                                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm <?php $__errorArgs = ['local_pesagem'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="local_pesagem" name="local_pesagem"
                                       value="<?php echo e(old('local_pesagem', $pesagem->local_pesagem)); ?>"
                                       placeholder="Ex: Balança 1, Setor A">
                                <?php $__errorArgs = ['local_pesagem'];
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
                            <label for="observacoes" class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
                            <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm <?php $__errorArgs = ['observacoes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      id="observacoes" name="observacoes" rows="3"
                                      placeholder="Observações sobre a pesagem..."><?php echo e(old('observacoes', $pesagem->observacoes)); ?></textarea>
                            <?php $__errorArgs = ['observacoes'];
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
                            <a href="<?php echo e(route('pesagem.show', $pesagem->id)); ?>"
                               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Visualizar
                            </a>
                            <a href="<?php echo e(route('pesagem.index')); ?>"
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
                            <?php if($pesagem->conferido): ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Conferida
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Pendente
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if($pesagem->conferido): ?>
                        <div>
                            <span class="text-sm font-medium text-gray-700">Conferida por:</span>
                            <div class="text-gray-900 text-sm"><?php echo e($pesagem->usuarioConferencia->nome); ?></div>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-700">Data da Conferência:</span>
                            <div class="text-gray-900 text-sm"><?php echo e($pesagem->data_conferencia_formatada); ?></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

                    <!-- Informações da Coleta -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-truck"></i> Coleta Atual
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <strong>Número:</strong><br>
                                <span class="text-primary"><?php echo e($pesagem->coleta->numero_coleta); ?></span>
                            </div>
                            <div class="mb-2">
                                <strong>Estabelecimento:</strong><br>
                                <small><?php echo e($pesagem->coleta->estabelecimento->razao_social); ?></small>
                            </div>
                            <div class="mb-0">
                                <strong>Status:</strong><br>
                                <span class="badge" style="background-color: <?php echo e($pesagem->coleta->status->cor); ?>">
                                    <?php echo e($pesagem->coleta->status->nome); ?>

                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Histórico -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-history"></i> Histórico
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <strong>Criada por:</strong><br>
                                <small><?php echo e($pesagem->usuario->nome); ?></small>
                            </div>
                            <div class="mb-2">
                                <strong>Data de Criação:</strong><br>
                                <small><?php echo e($pesagem->created_at->format('d/m/Y H:i')); ?></small>
                            </div>
                            <?php if($pesagem->updated_at != $pesagem->created_at): ?>
                                <div class="mb-0">
                                    <strong>Última Atualização:</strong><br>
                                    <small><?php echo e($pesagem->updated_at->format('d/m/Y H:i')); ?></small>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Calculadora de Peso -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-calculator"></i> Calculadora
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <strong>Peso Total:</strong> 
                                <span id="calcPesoTotal" class="text-primary"><?php echo e($pesagem->peso_formatado); ?></span>
                            </div>
                            <div class="mb-2">
                                <strong>Peso Unitário:</strong> 
                                <span id="calcPesoUnitario" class="text-info"><?php echo e($pesagem->peso_unitario_formatado); ?></span>
                            </div>
                            <div class="mb-0">
                                <strong>Valor Estimado:</strong> 
                                <span id="calcValorEstimado" class="text-success">R$ 0,00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\lavanderianovo\resources\views/pesagem/edit.blade.php ENDPATH**/ ?>