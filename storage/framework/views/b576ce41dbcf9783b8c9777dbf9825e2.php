

<?php $__env->startSection('title', 'Resultados da Busca'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50">
    <!-- Header - Mais clean -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Resultados da Busca</h1>
                    <p class="text-gray-600 text-sm mt-1">
                        <?php echo e($coletas->count()); ?> coleta(s) encontrada(s) para: <strong>"<?php echo e($termoBusca); ?>"</strong>
                    </p>
                </div>
                <a href="<?php echo e(route('acompanhamento.index')); ?>" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md transition-colors duration-200 text-sm">
                    🔍 Nova Busca
                </a>
            </div>
        </div>
    </div>

    <!-- Results -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <?php $__currentLoopData = $coletas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coleta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-lg shadow-sm border hover:shadow-md transition-shadow duration-200">
                    <!-- Header do Card -->
                    <div class="p-4 border-b border-gray-100">
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">
                                    <?php echo e($coleta->numero_coleta); ?>

                                </h3>
                                <p class="text-gray-600 text-xs">
                                    <?php echo e($coleta->estabelecimento->razao_social); ?>

                                </p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium"
                                      style="background-color: <?php echo e($coleta->status->cor); ?>20; color: <?php echo e($coleta->status->cor); ?>;">
                                    <?php echo e($coleta->status->nome); ?>

                                </span>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <?php
                            $progresso = 0;
                            
                            // Primeiro, definir progresso baseado no status da coleta
                            switch($coleta->status->nome) {
                                case 'Agendada': $progresso = 10; break;
                                case 'Em andamento': $progresso = 30; break;
                                case 'Concluída': $progresso = 50; break;
                                case 'Empacotada': $progresso = 70; break;
                            }
                            
                            // Se há empacotamento, verificar se o status dele é mais avançado
                            if($coleta->empacotamentos->isNotEmpty()) {
                                $statusEmpacotamento = $coleta->empacotamentos->first()->status->nome;
                                $progressoEmpacotamento = 0;
                                
                                switch($statusEmpacotamento) {
                                    case 'Pronto para motorista': $progressoEmpacotamento = 80; break;
                                    case 'Em trânsito': $progressoEmpacotamento = 90; break;
                                    case 'Entregue': $progressoEmpacotamento = 100; break;
                                }
                                
                                // Usar o maior progresso entre coleta e empacotamento
                                $progresso = max($progresso, $progressoEmpacotamento);
                            }
                        ?>

                        <div class="w-full bg-gray-200 rounded-full h-1.5 mb-3">
                            <div class="bg-gradient-to-r from-blue-500 to-green-500 h-1.5 rounded-full transition-all duration-500" 
                                 style="width: <?php echo e($progresso); ?>%"></div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500">
                            <span>Início</span>
                            <span class="font-medium"><?php echo e($progresso); ?>%</span>
                            <span>Entregue</span>
                        </div>
                    </div>

                    <!-- Informações da Coleta -->
                    <div class="p-4 space-y-3">
                        <div class="grid grid-cols-2 gap-3 text-xs">
                            <div>
                                <span class="text-gray-500">Data da Coleta:</span>
                                <p class="font-medium text-gray-900"><?php echo e($coleta->created_at->format('d/m/Y')); ?></p>
                            </div>
                            <div>
                                <span class="text-gray-500">CNPJ:</span>
                                <p class="font-medium text-gray-900"><?php echo e($coleta->estabelecimento->cnpj_formatado ?? 'N/A'); ?></p>
                            </div>
                        </div>

                        <?php if($coleta->pesagens->isNotEmpty()): ?>
                            <div class="bg-blue-50 rounded-md p-2">
                                <h4 class="font-medium text-blue-900 text-xs mb-1">📊 Pesagem</h4>
                                <p class="text-blue-800 text-xs">
                                    <?php echo e(number_format($coleta->pesagens->sum('peso'), 2, ',', '.')); ?> kg 
                                    (<?php echo e($coleta->pesagens->sum('quantidade')); ?> peças)
                                </p>
                            </div>
                        <?php endif; ?>

                        <?php if($coleta->empacotamentos->isNotEmpty()): ?>
                            <?php $empacotamento = $coleta->empacotamentos->first(); ?>
                            <div class="bg-green-50 rounded-md p-2">
                                <h4 class="font-medium text-green-900 text-xs mb-1">📦 Empacotamento</h4>
                                <p class="text-green-800 text-xs">
                                    <?php echo e($empacotamento->codigo_qr); ?><br>
                                    <?php echo e($empacotamento->data_empacotamento->format('d/m/Y H:i')); ?>

                                </p>
                            </div>

                            <?php if($empacotamento->entrega && $empacotamento->entrega->data_entrega): ?>
                                <div class="bg-emerald-50 rounded-md p-2">
                                    <h4 class="font-medium text-emerald-900 text-xs mb-1">✅ Entrega</h4>
                                    <p class="text-emerald-800 text-xs">
                                        <?php echo e($empacotamento->entrega->data_entrega->format('d/m/Y H:i')); ?><br>
                                        <?php echo e($empacotamento->entrega->nome_recebedor ?? 'N/A'); ?>

                                    </p>
                                </div>
                            <?php elseif($empacotamento->entrega && $empacotamento->entrega->data_saida): ?>
                                <div class="bg-yellow-50 rounded-md p-2">
                                    <h4 class="font-medium text-yellow-900 text-xs mb-1">🚚 Em Trânsito</h4>
                                    <p class="text-yellow-800 text-xs">
                                        Saiu: <?php echo e($empacotamento->entrega->data_saida->format('d/m/Y H:i')); ?>

                                    </p>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <!-- Botão Ver Detalhes -->
                        <div class="pt-3 border-t border-gray-100">
                            <a href="<?php echo e(route('acompanhamento.detalhes', $coleta->id)); ?>" 
                               class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white text-center py-2 px-4 rounded-md transition-all duration-200 inline-block text-sm">
                                👁️ Ver Detalhes
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <?php if($coletas->isEmpty()): ?>
            <div class="text-center py-12">
                <div class="text-6xl mb-4">🔍</div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Nenhuma coleta encontrada</h3>
                <p class="text-gray-600 mb-6">
                    Não encontramos coletas para "<?php echo e($termoBusca); ?>". 
                    Verifique se o CNPJ ou número da coleta estão corretos.
                </p>
                <a href="<?php echo e(route('acompanhamento.index')); ?>" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-colors duration-200">
                    🔍 Fazer Nova Busca
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.public', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\lavanderia\resources\views/publico/acompanhamento/resultados.blade.php ENDPATH**/ ?>