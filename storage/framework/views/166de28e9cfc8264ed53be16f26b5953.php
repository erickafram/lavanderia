

<?php $__env->startSection('title', 'Dashboard - Sistema de Gestão de Lavanderia'); ?>

<?php $__env->startSection('content'); ?>
<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
    <div>
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">
            <svg class="inline w-5 h-5 sm:w-6 sm:h-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v3H8V5z"></path>
            </svg>
            Dashboard
        </h1>
        <p class="text-sm text-gray-600">Visão geral do sistema de gestão de lavanderia</p>
    </div>
    <div class="flex items-center bg-white px-3 py-2 rounded-lg shadow-sm border mt-3 sm:mt-0">
        <svg class="w-4 h-4 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1M8 7h8m-8 0H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V9a2 2 0 00-2-2h-2"></path>
        </svg>
        <span class="text-sm text-gray-700 font-medium"><?php echo e(date('d/m/Y')); ?></span>
    </div>
</div>

<!-- Cards de estatísticas do dia -->
<div class="mb-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Estatísticas de Hoje</h2>
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        <!-- Coletas Hoje -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 sm:p-4 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-medium text-gray-600 uppercase tracking-wide truncate">Coletas Hoje</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900 mt-1"><?php echo e($coletasHoje); ?></p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-blue-100 rounded-lg flex items-center justify-center ml-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Empacotamentos Hoje -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 sm:p-4 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-medium text-gray-600 uppercase tracking-wide truncate">Empacotamentos</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900 mt-1"><?php echo e($empacotamentosHoje); ?></p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-green-100 rounded-lg flex items-center justify-center ml-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Peso Total Hoje -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 sm:p-4 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-medium text-gray-600 uppercase tracking-wide truncate">Peso (kg)</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900 mt-1"><?php echo e(number_format($pesoTotalHoje, 1, ',', '.')); ?></p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-purple-100 rounded-lg flex items-center justify-center ml-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16l3-1m-3 1l-3-1"></path>
                    </svg>
                </div>
            </div>
        </div>
        <!-- Faturamento Hoje -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 sm:p-4 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-medium text-gray-600 uppercase tracking-wide truncate">Faturamento</p>
                    <p class="text-lg sm:text-xl font-bold text-gray-900 mt-1">R$ <?php echo e(number_format($valorTotalHoje, 0, ',', '.')); ?></p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-yellow-100 rounded-lg flex items-center justify-center ml-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cards de estatísticas do mês -->
<div class="mb-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Estatísticas do Mês</h2>
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        <!-- Coletas do Mês -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 sm:p-4 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-medium text-gray-600 uppercase tracking-wide truncate">Coletas Mês</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900 mt-1"><?php echo e($coletasMes); ?></p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-indigo-100 rounded-lg flex items-center justify-center ml-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1M8 7h8m-8 0H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V9a2 2 0 00-2-2h-2"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Empacotamentos do Mês -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 sm:p-4 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-medium text-gray-600 uppercase tracking-wide truncate">Empac. Mês</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900 mt-1"><?php echo e($empacotamentosMes); ?></p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-teal-100 rounded-lg flex items-center justify-center ml-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Peso Total do Mês -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 sm:p-4 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-medium text-gray-600 uppercase tracking-wide truncate">Peso Mês</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900 mt-1"><?php echo e(number_format($pesoTotalMes, 1, ',', '.')); ?></p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-pink-100 rounded-lg flex items-center justify-center ml-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16l3-1m-3 1l-3-1"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Faturamento do Mês -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 sm:p-4 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-medium text-gray-600 uppercase tracking-wide truncate">Fatur. Mês</p>
                    <p class="text-lg sm:text-xl font-bold text-gray-900 mt-1">R$ <?php echo e(number_format($valorTotalMes, 0, ',', '.')); ?></p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-emerald-100 rounded-lg flex items-center justify-center ml-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Tabelas de dados recentes -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
    <!-- Coletas Recentes -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between p-4 border-b border-gray-100">
            <h3 class="text-base font-semibold text-gray-900">Coletas Recentes</h3>
            <a href="<?php echo e(route('coletas.index')); ?>" class="inline-flex items-center px-3 py-1.5 bg-primary-600 hover:bg-primary-700 text-white text-xs font-medium rounded-lg transition-colors duration-200">
                Ver Todas
                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
        <div class="p-4">
            <?php if($coletasRecentes->count() > 0): ?>
                <div class="space-y-3">
                    <?php $__currentLoopData = $coletasRecentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coleta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-900 truncate">#<?php echo e($coleta->numero_coleta); ?></p>
                                    <p class="text-xs text-gray-600 truncate"><?php echo e(Str::limit($coleta->estabelecimento->razao_social, 20)); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="text-right ml-2">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium" style="background-color: <?php echo e($coleta->status->cor); ?>20; color: <?php echo e($coleta->status->cor); ?>">
                                <?php echo e(Str::limit($coleta->status->nome, 10)); ?>

                            </span>
                            <p class="text-xs text-gray-500 mt-1"><?php echo e($coleta->created_at->format('d/m')); ?></p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-6">
                    <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm text-gray-500">Nenhuma coleta encontrada</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Empacotamentos Pendentes -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between p-4 border-b border-gray-100">
            <h3 class="text-base font-semibold text-gray-900">Empacotamentos Pendentes</h3>
            <a href="<?php echo e(route('empacotamento.index')); ?>" class="inline-flex items-center px-3 py-1.5 bg-primary-600 hover:bg-primary-700 text-white text-xs font-medium rounded-lg transition-colors duration-200">
                Ver Todos
                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
        <div class="p-4">
            <?php if($empacotamentosPendentes->count() > 0): ?>
                <div class="space-y-3">
                    <?php $__currentLoopData = $empacotamentosPendentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empacotamento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-900 truncate"><?php echo e($empacotamento->codigo_qr); ?></p>
                                    <p class="text-xs text-gray-600 truncate"><?php echo e(Str::limit($empacotamento->coleta->estabelecimento->razao_social, 20)); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="text-right ml-2">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium" style="background-color: <?php echo e($empacotamento->status->cor); ?>20; color: <?php echo e($empacotamento->status->cor); ?>">
                                <?php echo e(Str::limit($empacotamento->status->nome, 10)); ?>

                            </span>
                            <p class="text-xs text-gray-500 mt-1"><?php echo e($empacotamento->created_at->format('d/m')); ?></p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-6">
                    <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <p class="text-sm text-gray-500">Nenhum empacotamento pendente</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\lavanderia\resources\views/painel/index.blade.php ENDPATH**/ ?>