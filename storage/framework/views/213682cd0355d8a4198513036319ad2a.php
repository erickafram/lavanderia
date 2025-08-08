

<?php $__env->startSection('title', 'Detalhes da Coleta ' . $coleta->numero_coleta); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50">
    <!-- Header - Mais compacto -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold text-gray-900"><?php echo e($coleta->numero_coleta); ?></h1>
                    <p class="text-gray-600 text-sm"><?php echo e($coleta->estabelecimento->razao_social); ?></p>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium"
                          style="background-color: <?php echo e($coleta->status->cor); ?>20; color: <?php echo e($coleta->status->cor); ?>;">
                        <?php echo e($progresso['status_atual']); ?>

                    </span>
                    <button onclick="history.back()" 
                           class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-2 rounded-md transition-colors duration-200 text-sm">
                        ← Voltar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Coluna Principal - Timeline -->
            <div class="lg:col-span-2 space-y-4">
                <!-- Progress Overview - Mais compacto -->
                <div class="bg-white rounded-lg shadow-sm border p-4">
                    <h2 class="text-lg font-semibold text-gray-900 mb-3">📈 Progresso da Coleta</h2>
                    
                    <div class="w-full bg-gray-200 rounded-full h-2 mb-3">
                        <div class="bg-gradient-to-r from-blue-500 to-green-500 h-2 rounded-full transition-all duration-1000" 
                             style="width: <?php echo e($progresso['porcentagem']); ?>%"></div>
                    </div>
                    
                    <div class="flex justify-between text-xs text-gray-600 mb-4">
                        <span>Início</span>
                        <span class="font-medium"><?php echo e($progresso['porcentagem']); ?>% Concluído</span>
                        <span>Entregue</span>
                    </div>

                    <div class="text-center">
                        <p class="text-sm font-medium text-gray-900">Status Atual</p>
                        <p class="text-lg font-bold" style="color: <?php echo e($coleta->status->cor); ?>;">
                            <?php echo e($progresso['status_atual']); ?>

                        </p>
                    </div>
                </div>

                <!-- Timeline - Mais compacto -->
                <div class="bg-white rounded-lg shadow-sm border p-4">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">📅 Histórico da Coleta</h2>
                    
                    <div class="space-y-4">
                        <?php $__currentLoopData = $progresso['etapas']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $etapa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-start">
                                <!-- Timeline Icon - Menor -->
                                <div class="flex-shrink-0 mr-3">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm <?php echo e($etapa['concluida'] ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-500'); ?>">
                                        <?php switch($etapa['icone']):
                                            case ('calendar'): ?>
                                                📅
                                                <?php break; ?>
                                            <?php case ('truck'): ?>
                                                🚚
                                                <?php break; ?>
                                            <?php case ('check-circle'): ?>
                                                ✅
                                                <?php break; ?>
                                            <?php case ('scale'): ?>
                                                ⚖️
                                                <?php break; ?>
                                            <?php case ('package'): ?>
                                                📦
                                                <?php break; ?>
                                            <?php case ('clock'): ?>
                                                ⏰
                                                <?php break; ?>
                                            <?php case ('check'): ?>
                                                ✅
                                                <?php break; ?>
                                            <?php default: ?>
                                                📋
                                        <?php endswitch; ?>
                                    </div>
                                </div>

                                <!-- Timeline Content - Texto menor -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <h3 class="text-sm font-medium <?php echo e($etapa['concluida'] ? 'text-gray-900' : 'text-gray-500'); ?>">
                                            <?php echo e($etapa['titulo']); ?>

                                        </h3>
                                        <?php if($etapa['concluida'] && $etapa['data']): ?>
                                            <span class="text-xs text-gray-500">
                                                <?php echo e($etapa['data']->format('d/m/Y H:i')); ?>

                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <p class="text-xs <?php echo e($etapa['concluida'] ? 'text-gray-600' : 'text-gray-400'); ?>">
                                        <?php echo e($etapa['descricao']); ?>

                                    </p>
                                </div>
                            </div>

                            <?php if(!$loop->last): ?>
                                <div class="ml-4 w-px h-4 bg-gray-300"></div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <!-- Sidebar - Informações -->
            <div class="space-y-4">
                <!-- Informações do Estabelecimento - Mais compacto -->
                <div class="bg-white rounded-lg shadow-sm border p-4">
                    <h3 class="text-base font-semibold text-gray-900 mb-3">🏢 Estabelecimento</h3>
                    <div class="space-y-2 text-xs">
                        <div>
                            <span class="text-gray-500">Razão Social:</span>
                            <p class="font-medium text-gray-900"><?php echo e($coleta->estabelecimento->razao_social); ?></p>
                        </div>
                        <?php if($coleta->estabelecimento->nome_fantasia): ?>
                            <div>
                                <span class="text-gray-500">Nome Fantasia:</span>
                                <p class="font-medium text-gray-900"><?php echo e($coleta->estabelecimento->nome_fantasia); ?></p>
                            </div>
                        <?php endif; ?>
                        <div>
                            <span class="text-gray-500">CNPJ:</span>
                            <p class="font-medium text-gray-900"><?php echo e($coleta->estabelecimento->cnpj_formatado ?? 'N/A'); ?></p>
                        </div>
                        <div>
                            <span class="text-gray-500">Endereço:</span>
                            <p class="font-medium text-gray-900">
                                <?php echo e($coleta->estabelecimento->endereco); ?><br>
                                <?php echo e($coleta->estabelecimento->cidade); ?> - <?php echo e($coleta->estabelecimento->estado); ?>

                            </p>
                        </div>
                    </div>
                </div>

                <!-- Informações da Coleta - Mais compacto -->
                <div class="bg-white rounded-lg shadow-sm border p-4">
                    <h3 class="text-base font-semibold text-gray-900 mb-3">📋 Dados da Coleta</h3>
                    <div class="space-y-2 text-xs">
                        <div>
                            <span class="text-gray-500">Número:</span>
                            <p class="font-medium text-gray-900"><?php echo e($coleta->numero_coleta); ?></p>
                        </div>
                        <div>
                            <span class="text-gray-500">Data de Criação:</span>
                            <p class="font-medium text-gray-900"><?php echo e($coleta->created_at->format('d/m/Y H:i')); ?></p>
                        </div>
                        <div>
                            <span class="text-gray-500">Status Atual:</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium mt-1"
                                  style="background-color: <?php echo e($coleta->status->cor); ?>20; color: <?php echo e($coleta->status->cor); ?>;">
                                <?php echo e($coleta->status->nome); ?>

                            </span>
                        </div>
                    </div>
                </div>

                <!-- Peças da Coleta - Mais compacto -->
                <?php if($coleta->pecas->isNotEmpty()): ?>
                    <div class="bg-white rounded-lg shadow-sm border p-4">
                        <h3 class="text-base font-semibold text-gray-900 mb-3">👕 Peças Coletadas</h3>
                        <div class="space-y-2">
                            <?php $__currentLoopData = $coleta->pecas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $peca): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex justify-between items-center p-2 bg-gray-50 rounded-md">
                                    <div>
                                        <p class="font-medium text-gray-900 text-xs"><?php echo e($peca->tipo->nome); ?></p>
                                        <p class="text-xs text-gray-600"><?php echo e($peca->quantidade); ?> peças</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium text-gray-900 text-xs"><?php echo e(number_format($peca->peso, 2, ',', '.')); ?> kg</p>
                                        <p class="text-xs text-gray-500">R$ <?php echo e(number_format($peca->valor_total, 2, ',', '.')); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                            <div class="border-t pt-2 mt-2">
                                <div class="flex justify-between items-center font-semibold text-gray-900 text-xs">
                                    <span>Total:</span>
                                    <div class="text-right">
                                        <p><?php echo e($coleta->pecas->sum('quantidade')); ?> peças</p>
                                        <p><?php echo e(number_format($coleta->pecas->sum('peso'), 2, ',', '.')); ?> kg</p>
                                        <p class="text-blue-600">R$ <?php echo e(number_format($coleta->pecas->sum('valor_total'), 2, ',', '.')); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Pesagem - Mais compacto -->
                <?php if($coleta->pesagens->isNotEmpty()): ?>
                    <div class="bg-white rounded-lg shadow-sm border p-4">
                        <h3 class="text-base font-semibold text-gray-900 mb-3">⚖️ Pesagem</h3>
                        <?php $__currentLoopData = $coleta->pesagens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pesagem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="space-y-2 text-xs">
                                <div>
                                    <span class="text-gray-500">Peso Total:</span>
                                    <p class="font-medium text-gray-900"><?php echo e(number_format($pesagem->peso, 2, ',', '.')); ?> kg</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Quantidade:</span>
                                    <p class="font-medium text-gray-900"><?php echo e($pesagem->quantidade); ?> peças</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Data da Pesagem:</span>
                                    <p class="font-medium text-gray-900"><?php echo e($pesagem->data_pesagem->format('d/m/Y H:i')); ?></p>
                                </div>
                                <?php if($pesagem->usuario): ?>
                                    <div>
                                        <span class="text-gray-500">Responsável:</span>
                                        <p class="font-medium text-gray-900"><?php echo e($pesagem->usuario->nome); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>

                <!-- Empacotamento - Mais compacto -->
                <?php if($coleta->empacotamentos->isNotEmpty()): ?>
                    <?php $empacotamento = $coleta->empacotamentos->first(); ?>
                    <div class="bg-white rounded-lg shadow-sm border p-4">
                        <h3 class="text-base font-semibold text-gray-900 mb-3">📦 Empacotamento</h3>
                        <div class="space-y-2 text-xs">
                            <div>
                                <span class="text-gray-500">Código QR:</span>
                                <p class="font-medium text-gray-900"><?php echo e($empacotamento->codigo_qr); ?></p>
                            </div>
                            <div>
                                <span class="text-gray-500">Data:</span>
                                <p class="font-medium text-gray-900"><?php echo e($empacotamento->data_empacotamento->format('d/m/Y H:i')); ?></p>
                            </div>
                            <div>
                                <span class="text-gray-500">Status:</span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium mt-1"
                                      style="background-color: <?php echo e($empacotamento->status->cor); ?>20; color: <?php echo e($empacotamento->status->cor); ?>;">
                                    <?php echo e($empacotamento->status->nome); ?>

                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Entrega - Mais compacto -->
                    <?php if($empacotamento->entrega): ?>
                        <div class="bg-white rounded-lg shadow-sm border p-4">
                            <h3 class="text-base font-semibold text-gray-900 mb-3">🚚 Entrega</h3>
                            <div class="space-y-2 text-xs">
                                <?php if($empacotamento->entrega->data_saida): ?>
                                    <div>
                                        <span class="text-gray-500">Saída:</span>
                                        <p class="font-medium text-gray-900"><?php echo e($empacotamento->entrega->data_saida->format('d/m/Y H:i')); ?></p>
                                    </div>
                                <?php endif; ?>
                                <?php if($empacotamento->entrega->motoristaSaida): ?>
                                    <div>
                                        <span class="text-gray-500">Motorista:</span>
                                        <p class="font-medium text-gray-900"><?php echo e($empacotamento->entrega->motoristaSaida->nome); ?></p>
                                    </div>
                                <?php endif; ?>
                                <?php if($empacotamento->entrega->data_entrega): ?>
                                    <div>
                                        <span class="text-gray-500">Data da Entrega:</span>
                                        <p class="font-medium text-gray-900"><?php echo e($empacotamento->entrega->data_entrega->format('d/m/Y H:i')); ?></p>
                                    </div>
                                <?php endif; ?>
                                <?php if($empacotamento->entrega->nome_recebedor): ?>
                                    <div>
                                        <span class="text-gray-500">Recebido por:</span>
                                        <p class="font-medium text-gray-900"><?php echo e($empacotamento->entrega->nome_recebedor); ?></p>
                                    </div>
                                <?php endif; ?>
                                <?php if($empacotamento->entrega->assinatura_recebedor): ?>
                                    <div>
                                        <span class="text-gray-500">Assinatura:</span>
                                        <div class="mt-2">
                                            <button onclick="visualizarAssinatura('<?php echo e($empacotamento->entrega->assinatura_recebedor); ?>', '<?php echo e($empacotamento->entrega->nome_recebedor ?? 'N/A'); ?>')" 
                                                    class="inline-flex items-center px-3 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 text-xs font-medium rounded-lg transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                                </svg>
                                                Ver Assinatura
                                            </button>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // Animação da barra de progresso ao carregar a página
    document.addEventListener('DOMContentLoaded', function() {
        const progressBar = document.querySelector('.bg-gradient-to-r');
        if (progressBar) {
            progressBar.style.width = '0%';
            setTimeout(() => {
                progressBar.style.width = '<?php echo e($progresso["porcentagem"]); ?>%';
            }, 500);
        }
    });

    // Função para visualizar assinatura
    function visualizarAssinatura(assinatura, nomeRecebedor) {
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 flex items-center justify-center p-4';
        modal.innerHTML = `
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Assinatura do Recebedor</h3>
                        <button onclick="this.closest('.fixed').remove()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="text-center">
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Recebido por:</p>
                            <p class="font-semibold text-gray-900">${nomeRecebedor}</p>
                        </div>
                        
                        <div class="border-2 border-gray-300 rounded-lg p-4 bg-gray-50">
                            <img src="${assinatura.startsWith('data:') ? assinatura : '/storage/' + assinatura}" 
                                 alt="Assinatura do recebedor" 
                                 class="max-w-full max-h-32 mx-auto object-contain">
                        </div>
                        
                        <button onclick="this.closest('.fixed').remove()" 
                                class="mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                            Fechar
                        </button>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(modal);

        // Fechar com ESC
        modal.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                modal.remove();
            }
        });

        // Fechar clicando fora
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.remove();
            }
        });
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.public', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\lavanderia\resources\views/publico/acompanhamento/detalhes.blade.php ENDPATH**/ ?>