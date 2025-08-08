<table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Empacotamento</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estabelecimento</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motorista</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data Saída</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data Entrega</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tempo</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        <?php $__empty_1 = true; $__currentLoopData = $entregas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrega): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $tempoEntrega = null;
                if ($entrega->data_saida && $entrega->data_entrega) {
                    $minutos = \Carbon\Carbon::parse($entrega->data_saida)->diffInMinutes($entrega->data_entrega);
                    if ($minutos < 60) {
                        $tempoEntrega = $minutos . 'm';
                    } else {
                        $horas = floor($minutos / 60);
                        $mins = $minutos % 60;
                        $tempoEntrega = $horas . 'h ' . $mins . 'm';
                    }
                }
            ?>
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900"><?php echo e($entrega->empacotamento->codigo_qr); ?></div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900"><?php echo e($entrega->empacotamento->coleta->estabelecimento->razao_social); ?></div>
                    <?php if($entrega->empacotamento->coleta->estabelecimento->nome_fantasia): ?>
                        <div class="text-xs text-gray-500"><?php echo e($entrega->empacotamento->coleta->estabelecimento->nome_fantasia); ?></div>
                    <?php endif; ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">
                        <?php echo e($entrega->motoristaEntrega->nome ?? $entrega->motoristaSaida->nome ?? 'N/A'); ?>

                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <?php if($entrega->data_saida): ?>
                        <div class="text-sm text-gray-900"><?php echo e($entrega->data_saida->format('d/m/Y')); ?></div>
                        <div class="text-xs text-gray-500"><?php echo e($entrega->data_saida->format('H:i')); ?></div>
                    <?php else: ?>
                        <span class="text-gray-400">-</span>
                    <?php endif; ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <?php if($entrega->data_entrega): ?>
                        <div class="text-sm text-gray-900"><?php echo e($entrega->data_entrega->format('d/m/Y')); ?></div>
                        <div class="text-xs text-gray-500"><?php echo e($entrega->data_entrega->format('H:i')); ?></div>
                    <?php else: ?>
                        <span class="text-gray-400">-</span>
                    <?php endif; ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                          style="background-color: <?php echo e($entrega->status->cor); ?>20; color: <?php echo e($entrega->status->cor); ?>;">
                        <?php echo e($entrega->status->nome); ?>

                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <?php if($tempoEntrega): ?>
                        <div class="text-sm text-gray-900"><?php echo e($tempoEntrega); ?></div>
                    <?php else: ?>
                        <span class="text-gray-400">-</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                    Nenhuma entrega encontrada no período selecionado
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<?php /**PATH C:\wamp64\www\lavanderia\resources\views/relatorios/partials/entregas-table.blade.php ENDPATH**/ ?>