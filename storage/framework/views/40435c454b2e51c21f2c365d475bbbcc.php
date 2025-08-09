<table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Coleta</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estabelecimento</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peso</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor Estimado</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Situação</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        <?php $__empty_1 = true; $__currentLoopData = $coletas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coleta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $valorEstimado = $coleta->peso_total * 5; // R$ 5 por kg (exemplo)
                $finalizada = $coleta->empacotamento && $coleta->empacotamento->entrega && 
                             $coleta->empacotamento->entrega->status->nome === 'Confirmado pelo Cliente';
            ?>
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900"><?php echo e($coleta->numero_coleta); ?></div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900"><?php echo e($coleta->estabelecimento->razao_social); ?></div>
                    <?php if($coleta->estabelecimento->nome_fantasia): ?>
                        <div class="text-xs text-gray-500"><?php echo e($coleta->estabelecimento->nome_fantasia); ?></div>
                    <?php endif; ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900"><?php echo e($coleta->created_at->format('d/m/Y')); ?></div>
                    <div class="text-xs text-gray-500"><?php echo e($coleta->created_at->format('H:i')); ?></div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900"><?php echo e(number_format($coleta->peso_total, 2)); ?>kg</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">R$ <?php echo e(number_format($valorEstimado, 2, ',', '.')); ?></div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                          style="background-color: <?php echo e($coleta->status->cor); ?>20; color: <?php echo e($coleta->status->cor); ?>;">
                        <?php echo e($coleta->status->nome); ?>

                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <?php if($finalizada): ?>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Faturável
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            Pendente
                        </span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                    Nenhuma coleta encontrada no período selecionado
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<?php /**PATH C:\wamp64\www\lavanderia\resources\views/relatorios/partials/financeiro-table.blade.php ENDPATH**/ ?>