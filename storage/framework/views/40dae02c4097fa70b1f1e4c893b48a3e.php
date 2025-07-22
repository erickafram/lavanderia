<?php $__env->startSection('title', 'Detalhes do Empacotamento'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">
                <svg class="inline w-5 h-5 sm:w-6 sm:h-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                📦 Empacotamento <?php echo e($empacotamento->codigo_qr); ?>

            </h1>
            <p class="text-sm text-gray-600">Detalhes do empacotamento e rastreamento</p>
        </div>
        <div class="flex gap-2 mt-3 sm:mt-0">
            <a href="<?php echo e(route('empacotamento.reimprimir-qr', $empacotamento->id)); ?>" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Reimprimir QR
            </a>
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
            <!-- Detalhes do Empacotamento -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
                <div class="p-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Detalhes do Empacotamento
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Código: <span class="font-mono font-bold text-blue-600"><?php echo e($empacotamento->codigo_qr); ?></span></p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Status Atual -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-900 mb-3">Status Atual</h4>
                            <div class="flex items-center">
                                <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium"
                                      style="background-color: <?php echo e($empacotamento->status->cor); ?>20; color: <?php echo e($empacotamento->status->cor); ?>;">
                                    <div class="w-2 h-2 rounded-full mr-2" style="background-color: <?php echo e($empacotamento->status->cor); ?>;"></div>
                                    <?php echo e($empacotamento->status->nome); ?>

                                </span>
                            </div>
                        </div>

                        <!-- Data de Empacotamento -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-900 mb-3">Data de Empacotamento</h4>
                            <div class="text-lg font-bold text-gray-900"><?php echo e($empacotamento->data_empacotamento->format('d/m/Y')); ?></div>
                            <div class="text-sm text-gray-600"><?php echo e($empacotamento->data_empacotamento->format('H:i:s')); ?></div>
                        </div>

                        <!-- Responsável -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-900 mb-3">Responsável pelo Empacotamento</h4>
                            <div class="text-gray-900 font-medium"><?php echo e($empacotamento->usuarioEmpacotamento->nome); ?></div>
                        </div>
                    </div>

                    <?php if($empacotamento->observacoes_empacotamento): ?>
                        <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <h4 class="font-semibold text-yellow-800 mb-2">Observações do Empacotamento</h4>
                            <p class="text-yellow-700"><?php echo e($empacotamento->observacoes_empacotamento); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Informações do Hotel/Estabelecimento -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
                <div class="p-4 border-b border-gray-100 bg-gradient-to-r from-green-50 to-emerald-50">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Informações do Hotel
                    </h3>
                </div>
                <div class="p-6">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mt-1 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <div>
                                <h4 class="font-bold text-blue-900 text-lg">Hotel: <?php echo e($empacotamento->coleta->estabelecimento->razao_social); ?></h4>
                                <?php if($empacotamento->coleta->estabelecimento->nome_fantasia): ?>
                                    <p class="text-blue-700 text-sm mt-1"><?php echo e($empacotamento->coleta->estabelecimento->nome_fantasia); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900"><?php echo e($empacotamento->coleta->numero_coleta); ?></div>
                            <div class="text-sm text-gray-600">Número da Coleta</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900"><?php echo e(number_format($empacotamento->coleta->peso_total, 1, ',', '.')); ?> kg</div>
                            <div class="text-sm text-gray-600">Peso Total</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900">R$ <?php echo e(number_format($empacotamento->coleta->valor_total, 2, ',', '.')); ?></div>
                            <div class="text-sm text-gray-600">Valor Total</div>
                        </div>
                    </div>

                    <?php if($empacotamento->coleta->estabelecimento->endereco): ?>
                        <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                            <div class="text-sm text-gray-600">Endereço:</div>
                            <div class="text-gray-900"><?php echo e($empacotamento->coleta->estabelecimento->endereco); ?></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Peças Coletadas e Empacotadas -->
            <?php if($empacotamento->coleta->pecas->count() > 0): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="p-4 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-pink-50">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Peças Coletadas e Empacotadas
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Relação detalhada das peças processadas</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Peça</th>
                                    <th class="px-6 py-4 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">Quantidade Coletada</th>
                                    <th class="px-6 py-4 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">Quantidade Entregue</th>
                                    <th class="px-6 py-4 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">Peso (kg)</th>
                                    <th class="px-6 py-4 text-right text-sm font-bold text-gray-700 uppercase tracking-wider">Valor</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php $__currentLoopData = $empacotamento->coleta->pecas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $peca): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="hover:bg-blue-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-3 h-3 bg-purple-500 rounded-full mr-3"></div>
                                                <div class="text-sm font-medium text-gray-900"><?php echo e($peca->tipo->nome); ?></div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                <?php echo e($peca->quantidade); ?>

                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                <?php echo e($peca->quantidade); ?>

                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 font-medium">
                                            <?php echo e(number_format($peca->peso, 2, ',', '.')); ?>

                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-gray-900">
                                            R$ <?php echo e(number_format($peca->subtotal, 2, ',', '.')); ?>

                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-right text-sm font-bold text-gray-900">Total:</td>
                                    <td class="px-6 py-4 text-center text-sm font-bold text-gray-900">
                                        <?php echo e(number_format($empacotamento->coleta->peso_total, 2, ',', '.')); ?> kg
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-bold text-gray-900">
                                        R$ <?php echo e(number_format($empacotamento->coleta->valor_total, 2, ',', '.')); ?>

                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="lg:col-span-1 space-y-6">
            <!-- Status do Motorista -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-4 border-b border-gray-100 bg-gradient-to-r from-orange-50 to-red-50">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Status do Motorista
                    </h3>
                </div>
                <div class="p-4 space-y-4">
                    <?php if($empacotamento->motorista): ?>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-bold text-blue-900">Motorista: <?php echo e($empacotamento->motorista->nome); ?></div>
                                    <?php if($empacotamento->data_saida): ?>
                                        <div class="text-sm text-blue-700">Data de Confirmação pelo Motorista: <?php echo e($empacotamento->data_saida->format('d/m/Y H:i:s')); ?></div>
                                    <?php else: ?>
                                        <div class="text-sm text-blue-700">Aguardando confirmação</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <span class="text-yellow-800 font-medium">Motorista não definido</span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Status Atual -->
                    <div class="border-t pt-4">
                        <span class="text-sm font-medium text-gray-700">Status Atual:</span>
                        <div class="mt-2">
                            <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium"
                                  style="background-color: <?php echo e($empacotamento->status->cor); ?>20; color: <?php echo e($empacotamento->status->cor); ?>;">
                                <div class="w-2 h-2 rounded-full mr-2" style="background-color: <?php echo e($empacotamento->status->cor); ?>;"></div>
                                <?php echo e($empacotamento->status->nome); ?>

                            </span>
                        </div>
                    </div>

                    <!-- Ações -->
                    <?php if($empacotamento->podeSerEntregue() && !$empacotamento->foiEntregue()): ?>
                        <div class="border-t pt-4">
                            <button type="button" onclick="abrirModalEntrega()"
                                    class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Confirmar Entrega
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Status do Recebimento -->
            <?php if($empacotamento->foiEntregue()): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="p-4 border-b border-gray-100 bg-gradient-to-r from-green-50 to-emerald-50">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Status do Recebimento
                        </h3>
                    </div>
                    <div class="p-4 space-y-4">
                        <!-- Status de Entrega -->
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="font-bold text-green-800">ENTREGUE COM SUCESSO</span>
                            </div>
                            <div class="text-sm text-green-700">
                                <strong>Data de Entrega:</strong> <?php echo e($empacotamento->data_entrega->format('d/m/Y H:i:s')); ?>

                            </div>
                        </div>

                        <!-- Informações do Recebedor -->
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-900 mb-3">Dados do Recebimento</h4>
                            <div class="space-y-2">
                                <div>
                                    <span class="text-sm font-medium text-gray-700">Recebido por:</span>
                                    <div class="text-gray-900 font-medium"><?php echo e($empacotamento->nome_recebedor); ?></div>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-700">Data de Confirmação:</span>
                                    <div class="text-gray-900"><?php echo e($empacotamento->data_confirmacao_recebimento->format('d/m/Y H:i:s')); ?></div>
                                </div>
                            </div>
                        </div>

                        <!-- Assinatura do Recebedor -->
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-900 mb-3">Assinatura do Recebedor</h4>
                            <?php if($empacotamento->assinatura_recebimento): ?>
                                <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                                    <img src="<?php echo e(asset('storage/' . $empacotamento->assinatura_recebimento)); ?>"
                                         alt="Assinatura" class="max-h-24 mx-auto">
                                </div>
                            <?php else: ?>
                                <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                                    <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                    <p class="text-gray-500 text-sm">Assinatura digital não disponível</p>
                                    <p class="text-gray-400 text-xs mt-1">Recebimento confirmado verbalmente</p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if($empacotamento->observacoes_entrega): ?>
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <h4 class="font-semibold text-blue-900 mb-2">Observações da Entrega</h4>
                                <p class="text-blue-800 text-sm"><?php echo e($empacotamento->observacoes_entrega); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <!-- Aguardando Entrega -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="p-4 border-b border-gray-100 bg-gradient-to-r from-yellow-50 to-orange-50">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Status do Recebimento
                        </h3>
                    </div>
                    <div class="p-4">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center">
                            <svg class="w-8 h-8 text-yellow-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-yellow-800 font-medium">Aguardando Entrega</p>
                            <p class="text-yellow-600 text-sm mt-1">O empacotamento ainda não foi entregue</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- QR Code -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                        </svg>
                        Código QR
                    </h3>
                </div>
                <div class="p-4 text-center">
                    <div class="text-sm text-gray-600 mb-2"><?php echo e($empacotamento->codigo_qr); ?></div>
                    <div class="text-xs text-gray-500">Use este código para rastreamento</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Entrega -->
<?php if($empacotamento->podeSerEntregue() && !$empacotamento->foiEntregue()): ?>
<div id="modalEntrega" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Confirmar Entrega</h3>
            <form method="POST" action="<?php echo e(route('empacotamento.confirmar-entrega', $empacotamento->id)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
                <div class="mb-4">
                    <label for="nome_recebedor" class="block text-sm font-medium text-gray-700 mb-2">
                        Nome do Recebedor <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nome_recebedor" id="nome_recebedor" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                </div>
                
                <div class="mb-4">
                    <label for="data_entrega" class="block text-sm font-medium text-gray-700 mb-2">
                        Data/Hora da Entrega <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" name="data_entrega" id="data_entrega" required
                           value="<?php echo e(now()->format('Y-m-d\TH:i')); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                </div>
                
                <div class="mb-4">
                    <label for="observacoes_entrega" class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
                    <textarea name="observacoes_entrega" id="observacoes_entrega" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm"
                              placeholder="Observações sobre a entrega..."></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="fecharModalEntrega()" 
                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 text-sm font-medium rounded-lg">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg">
                        Confirmar Entrega
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<?php $__env->startPush('scripts'); ?>
<script>
function abrirModalEntrega() {
    document.getElementById('modalEntrega').classList.remove('hidden');
}

function fecharModalEntrega() {
    document.getElementById('modalEntrega').classList.add('hidden');
}

// Fechar modal ao clicar fora
document.getElementById('modalEntrega').addEventListener('click', function(e) {
    if (e.target === this) {
        fecharModalEntrega();
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\lavanderianovo\resources\views/empacotamento/show.blade.php ENDPATH**/ ?>