<?php $__env->startSection('title', 'Detalhes da Coleta - Sistema de Gestão de Lavanderia'); ?>

<?php $__env->startSection('content'); ?>
<?php if(!isset($coleta) || !$coleta): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <strong>Erro:</strong> Coleta não encontrada.
        <a href="<?php echo e(route('coletas.index')); ?>" class="underline">Voltar para listagem</a>
    </div>
<?php else: ?>
<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
    <div>
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">
            <svg class="inline w-5 h-5 sm:w-6 sm:h-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            </svg>
            Coleta <?php echo e($coleta->numero_coleta); ?>

        </h1>
        <p class="text-sm text-gray-600">Detalhes completos da coleta</p>
    </div>
    <div class="flex gap-2 mt-3 sm:mt-0">
        <?php if($coleta->podeSerCancelada() && $coleta->status->nome !== 'Concluída'): ?>
            <?php if($coleta->status->nome === 'Agendada'): ?>
                <form method="POST" action="<?php echo e(route('coletas.concluir', $coleta->id)); ?>" class="inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-xl transition-colors duration-200"
                            onclick="return confirm('Confirma a conclusão desta coleta?')">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Concluir
                    </button>
                </form>
            <?php endif; ?>
            
            <button type="button" 
                    onclick="openCancelModal()"
                    class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Cancelar
            </button>
        <?php endif; ?>
        
        <a href="<?php echo e(route('coletas.index')); ?>" 
           class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition-colors duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Voltar
        </a>
    </div>
</div>

<!-- Status Badge -->
<div class="mb-6">
    <?php
        $statusColors = [
            'Agendada' => 'bg-blue-100 text-blue-800',
            'Em andamento' => 'bg-yellow-100 text-yellow-800',
            'Concluída' => 'bg-green-100 text-green-800',
            'Cancelada' => 'bg-red-100 text-red-800',
        ];
        $colorClass = $statusColors[$coleta->status->nome] ?? 'bg-gray-100 text-gray-800';
    ?>
    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium <?php echo e($colorClass); ?>">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <?php if($coleta->status->nome === 'Concluída'): ?>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            <?php elseif($coleta->status->nome === 'Cancelada'): ?>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            <?php elseif($coleta->status->nome === 'Em andamento'): ?>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            <?php else: ?>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h8m-8 0H6a2 2 0 00-2 2v10a2 2 0 002 2h1m5 0h8a2 2 0 002-2V9a2 2 0 00-2-2h-1"></path>
            <?php endif; ?>
        </svg>
        <?php echo e($coleta->status->nome); ?>

    </span>
</div>

<!-- Card Principal com Informações -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
    <!-- Header do Card -->
    <div class="bg-gradient-to-r from-primary-50 to-primary-100 px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900"><?php echo e($coleta->estabelecimento->razao_social); ?></h2>
                <?php if($coleta->estabelecimento->nome_fantasia): ?>
                <p class="text-sm text-gray-600 mt-1"><?php echo e($coleta->estabelecimento->nome_fantasia); ?></p>
                <?php endif; ?>
            </div>
            <div class="text-right">
                <p class="text-sm font-medium text-gray-700">Número da Coleta</p>
                <p class="text-lg font-mono text-gray-900"><?php echo e($coleta->numero_coleta); ?></p>
            </div>
        </div>
    </div>

    <!-- Conteúdo do Card -->
    <div class="p-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Coluna Esquerda - Informações da Coleta -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h8m-8 0H6a2 2 0 00-2 2v10a2 2 0 002 2h1m5 0h8a2 2 0 002-2V9a2 2 0 00-2-2h-1"></path>
                    </svg>
                    Informações da Coleta
                </h3>
                
                <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Data Agendamento:</span>
                        <span class="text-sm font-medium text-gray-900"><?php echo e(\Carbon\Carbon::parse($coleta->data_agendamento)->format('d/m/Y H:i')); ?></span>
                    </div>
                    
                    <?php if($coleta->data_coleta): ?>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Data Coleta:</span>
                        <span class="text-sm font-medium text-gray-900"><?php echo e(\Carbon\Carbon::parse($coleta->data_coleta)->format('d/m/Y H:i')); ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if($coleta->data_conclusao): ?>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Data Conclusão:</span>
                        <span class="text-sm font-medium text-gray-900"><?php echo e(\Carbon\Carbon::parse($coleta->data_conclusao)->format('d/m/Y H:i')); ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Responsável:</span>
                        <span class="text-sm font-medium text-gray-900"><?php echo e($coleta->usuario->nome); ?></span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Cadastrado em:</span>
                        <span class="text-sm font-medium text-gray-900"><?php echo e($coleta->created_at->format('d/m/Y H:i')); ?></span>
                    </div>
                </div>
                
                <?php if($coleta->observacoes): ?>
                <div class="mt-4">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Observações:</h4>
                    <div class="bg-blue-50 rounded-lg p-3">
                        <p class="text-sm text-gray-700"><?php echo e($coleta->observacoes); ?></p>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if($coleta->motivo_cancelamento): ?>
                <div class="mt-4">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Motivo do Cancelamento:</h4>
                    <div class="bg-red-50 rounded-lg p-3">
                        <p class="text-sm text-red-700"><?php echo e($coleta->motivo_cancelamento); ?></p>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Coluna Direita - Totais -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    Resumo
                </h3>
                
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-6 text-center">
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Peso Total</p>
                            <p class="text-2xl font-bold text-gray-900"><?php echo e(number_format($coleta->peso_total, 2, ',', '.')); ?> kg</p>
                        </div>
                        
                        <div class="border-t border-green-200 pt-4">
                            <p class="text-sm text-gray-600 mb-1">Valor Total</p>
                            <p class="text-3xl font-bold text-green-600">R$ <?php echo e(number_format($coleta->valor_total, 2, ',', '.')); ?></p>
                        </div>
                        
                        <div class="border-t border-green-200 pt-4">
                            <p class="text-sm text-gray-600 mb-1">Quantidade de Peças</p>
                            <p class="text-xl font-semibold text-gray-900"><?php echo e($coleta->pecas->count()); ?> tipos</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Peças da Coleta -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
        <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
        </svg>
        Peças da Coleta
    </h3>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantidade</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peso</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço/kg</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Observações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__currentLoopData = $coleta->pecas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $peca): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900"><?php echo e($peca->tipo->nome); ?></div>
                            <div class="text-sm text-gray-500"><?php echo e($peca->tipo->categoria); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <?php echo e($peca->quantidade); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <?php echo e(number_format($peca->peso, 2, ',', '.')); ?> kg
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            R$ <?php echo e(number_format($peca->preco_unitario, 2, ',', '.')); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                            R$ <?php echo e(number_format($peca->subtotal, 2, ',', '.')); ?>

                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            <?php echo e($peca->observacoes ?: '-'); ?>

                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal de Cancelamento -->
<div id="cancelModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Cancelar Coleta</h3>
                <button type="button" onclick="closeCancelModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form method="POST" action="<?php echo e(route('coletas.cancelar', $coleta->id)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
                <div class="mb-4">
                    <label for="motivo_cancelamento" class="block text-sm font-medium text-gray-700 mb-2">
                        Motivo do Cancelamento *
                    </label>
                    <textarea id="motivo_cancelamento" 
                              name="motivo_cancelamento" 
                              rows="4"
                              placeholder="Descreva o motivo do cancelamento..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm"
                              required></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" 
                            onclick="closeCancelModal()"
                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-200">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        Confirmar Cancelamento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function openCancelModal() {
    document.getElementById('cancelModal').classList.remove('hidden');
}

function closeCancelModal() {
    document.getElementById('cancelModal').classList.add('hidden');
    document.getElementById('motivo_cancelamento').value = '';
}

// Fechar modal ao clicar fora
document.getElementById('cancelModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCancelModal();
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\lavanderia\resources\views/coletas/show.blade.php ENDPATH**/ ?>