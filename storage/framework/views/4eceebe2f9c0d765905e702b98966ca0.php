

<?php $__env->startSection('title', 'Editar Empacotamento'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Estilos para peças extras */
    .tipo-peca-container[data-tipo-id] {
        animation: fadeIn 0.3s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">
                <svg class="inline w-5 h-5 sm:w-6 sm:h-6 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Editar Empacotamento <?php echo e($empacotamento->codigo_qr); ?>

            </h1>
            <p class="text-sm text-gray-600">Modificar dados do empacotamento</p>
        </div>
        <div class="flex gap-2 mt-3 sm:mt-0">
            <a href="<?php echo e(route('empacotamento.show', $empacotamento->id)); ?>"
               class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Voltar
            </a>
        </div>
    </div>

    <!-- Alertas -->
    <?php if(session('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <h4 class="font-medium mb-2">Corrija os seguintes erros:</h4>
            <ul class="list-disc list-inside">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('empacotamento.update', $empacotamento->id)); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <!-- Informações Básicas -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
                    <div class="p-4 border-b border-gray-100 bg-gradient-to-r from-yellow-50 to-orange-50">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Informações do Empacotamento
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Data de Empacotamento -->
                            <div>
                                <label for="data_empacotamento" class="block text-sm font-medium text-gray-700 mb-2">
                                    Data e Hora do Empacotamento *
                                </label>
                                <input type="datetime-local" 
                                       id="data_empacotamento" 
                                       name="data_empacotamento" 
                                       value="<?php echo e(old('data_empacotamento', $empacotamento->data_empacotamento->format('Y-m-d\TH:i'))); ?>"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 text-sm <?php $__errorArgs = ['data_empacotamento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       required>
                                <?php $__errorArgs = ['data_empacotamento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Status Atual (só visualização) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Status Atual
                                </label>
                                <div class="px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-sm font-medium"
                                          style="background-color: <?php echo e($empacotamento->status->cor); ?>20; color: <?php echo e($empacotamento->status->cor); ?>;">
                                        <div class="w-2 h-2 rounded-full mr-2" style="background-color: <?php echo e($empacotamento->status->cor); ?>;"></div>
                                        <?php echo e($empacotamento->status->nome); ?>

                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Observações -->
                        <div class="mt-6">
                            <label for="observacoes_empacotamento" class="block text-sm font-medium text-gray-700 mb-2">
                                Observações do Empacotamento
                            </label>
                            <textarea id="observacoes_empacotamento"
                                      name="observacoes_empacotamento"
                                      rows="4"
                                      placeholder="Observações sobre o empacotamento..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 text-sm <?php $__errorArgs = ['observacoes_empacotamento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('observacoes_empacotamento', $empacotamento->observacoes_empacotamento)); ?></textarea>
                            <?php $__errorArgs = ['observacoes_empacotamento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <!-- Divisão de Peças por Tipo -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="p-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Divisão de Peças por Tipo
                            <span class="ml-2 bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                <?php echo e($empacotamento->pecasIndividuais->count()); ?> lotes
                            </span>
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Divida as peças em lotes menores. Cada lote terá seu próprio QR Code para rastreamento</p>
                    </div>
                    <!-- Container dos Tipos de Peças Agrupadas -->
                    <div class="p-4">
                        <?php
                            // Agrupar peças por tipo
                            $pecasPorTipo = $empacotamento->pecasIndividuais->groupBy('tipo_id');
                            $coletaPecas = $empacotamento->coleta->pecas->keyBy('tipo_id');

                            // Debug - vamos ver o que tem nas peças da coleta
                            // dd($empacotamento->coleta->pecas->toArray(), $coletaPecas->toArray());
                        ?>

                        <?php $__currentLoopData = $pecasPorTipo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipoId => $pecasDoTipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $primeiraP = $pecasDoTipo->first();

                                // Buscar a peça da coleta de forma mais robusta
                                $coletaPeca = $empacotamento->coleta->pecas->where('tipo_id', $tipoId)->first();
                                $quantidadeColetada = $coletaPeca ? $coletaPeca->quantidade : 0;

                                // Se ainda for 0, tentar buscar pela observação da peça individual
                                if ($quantidadeColetada == 0 && $primeiraP->observacoes) {
                                    // Tentar diferentes padrões de regex
                                    $patterns = [
                                        '/Qtd\. coletada: (\d+)/',
                                        '/quantidade: (\d+)/',
                                        '/original da coleta: (\d+)/',
                                        '/original: (\d+)/'
                                    ];

                                    foreach ($patterns as $pattern) {
                                        if (preg_match($pattern, $primeiraP->observacoes, $matches)) {
                                            $quantidadeColetada = (int)$matches[1];
                                            break;
                                        }
                                    }
                                }

                                // Debug: vamos ver o que está acontecendo
                                if ($tipoId == $pecasPorTipo->keys()->first()) {
                                    // dd('Primeira iteração:', $tipoId, $coletaPeca, $quantidadeColetada, $primeiraP->observacoes, $empacotamento->coleta->pecas->toArray());
                                }

                                $totalEmpacotado = $pecasDoTipo->sum('quantidade');
                                $diferenca = $totalEmpacotado - $quantidadeColetada;
                            ?>

                            <div class="tipo-peca-container border border-gray-200 rounded-lg overflow-hidden mb-4">
                                <!-- Barra/Título do Tipo -->
                                <div class="tipo-peca-header bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200 p-4 cursor-pointer hover:from-blue-100 hover:to-indigo-100 transition-colors"
                                     onclick="toggleTipoEdicao('<?php echo e($tipoId); ?>')"
                                     data-quantidade-coletada="<?php echo e($quantidadeColetada); ?>">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                            <div>
                                                <h5 class="text-sm font-semibold text-gray-900"><?php echo e($primeiraP->tipo->nome); ?></h5>
                                                <p class="text-xs text-gray-500"><?php echo e($primeiraP->tipo->categoria); ?></p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <div class="text-right">
                                                <div class="text-xs text-gray-500">Coletado</div>
                                                <div class="text-sm font-medium text-gray-900"><?php echo e($quantidadeColetada); ?> peças</div>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-xs text-gray-500">Empacotado</div>
                                                <div class="text-sm font-medium <?php echo e($diferenca == 0 ? 'text-green-600' : ($diferenca > 0 ? 'text-orange-600' : 'text-red-600')); ?>">
                                                    <?php echo e($totalEmpacotado); ?> peças
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-xs text-gray-500">Status</div>
                                                <div class="text-sm font-medium <?php echo e($diferenca == 0 ? 'text-green-600' : ($diferenca > 0 ? 'text-orange-600' : 'text-red-600')); ?>">
                                                    <?php if($diferenca == 0): ?>
                                                        ✓ Confere
                                                    <?php elseif($diferenca > 0): ?>
                                                        +<?php echo e($diferenca); ?> a mais
                                                    <?php else: ?>
                                                        <?php echo e(abs($diferenca)); ?> faltando
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-xs text-gray-500">Lotes</div>
                                                <div class="text-sm font-medium text-blue-600"><?php echo e($pecasDoTipo->count()); ?> lotes</div>
                                            </div>
                                            <svg id="chevron-<?php echo e($tipoId); ?>" class="w-5 h-5 text-gray-400 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Área de Conteúdo (Lotes) -->
                                <div id="content-<?php echo e($tipoId); ?>" class="tipo-peca-content hidden bg-white">
                                    <div class="p-4">
                                        <div class="mb-4">
                                            <span class="text-sm font-medium text-gray-700">Lotes de empacotamento:</span>
                                        </div>

                                        <div class="space-y-3">
                                            <?php $__currentLoopData = $pecasDoTipo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $peca): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="lote-empacotamento flex items-center space-x-3 p-3 bg-gray-50 rounded border">
                                                    <div class="flex-1 grid grid-cols-2 gap-4">
                                                        <div>
                                                            <label class="block text-xs font-medium text-gray-700 mb-1">Código QR</label>
                                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-mono font-medium bg-gray-100 text-gray-800">
                                                                <?php echo e($peca->codigo_qr); ?>

                                                            </span>
                                                        </div>
                                                        <div>
                                                            <label class="block text-xs font-medium text-gray-700 mb-1">Quantidade</label>
                                                            <input type="number"
                                                                   name="pecas_individuais[<?php echo e($peca->id); ?>][quantidade]"
                                                                   value="0"
                                                                   min="0"
                                                                   data-tipo-id="<?php echo e($tipoId); ?>"
                                                                   onchange="atualizarStatusTipo('<?php echo e($tipoId); ?>')"
                                                                   oninput="atualizarStatusTipo('<?php echo e($tipoId); ?>')"
                                                                   class="quantidade-lote w-full px-2 py-1 text-center border border-gray-300 rounded text-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                                                            <!-- Campo hidden para peso (mantém valor original) -->
                                                            <input type="hidden" name="pecas_individuais[<?php echo e($peca->id); ?>][peso]" value="<?php echo e($peca->peso); ?>">
                                                        </div>
                                                    </div>
                                                    <?php if($pecasDoTipo->count() > 1): ?>
                                                        <div class="flex-shrink-0">
                                                            <button type="button" onclick="removerLoteEdicao(<?php echo e($peca->id); ?>)"
                                                                    class="inline-flex items-center px-2 py-1 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-medium rounded transition-colors"
                                                                    title="Remover lote">
                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>

                                        <!-- Botão Adicionar Lote no final -->
                                        <div class="mt-4 pt-3 border-t border-gray-200">
                                            <button type="button" onclick="duplicarLoteEdicao('<?php echo e($tipoId); ?>', '<?php echo e($primeiraP->tipo->nome); ?>')"
                                                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                                Adicionar Novo Lote
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    
                    <!-- Botão Adicionar Peça Extra -->
                    <div class="p-4 border-t border-gray-200 bg-gray-50">
                        <button type="button" onclick="abrirModalPecaExtra()"
                                class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Adicionar Peça Extra (Novo Tipo)
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar com informações da coleta -->
            <div class="lg:col-span-1">
                <!-- Informações da Coleta -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
                    <div class="p-4 border-b border-gray-100 bg-gradient-to-r from-green-50 to-emerald-50">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Informações da Coleta
                        </h3>
                    </div>
                    <div class="p-4">
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm text-gray-600">Número:</span>
                                <span class="text-sm font-medium text-gray-900 ml-2"><?php echo e($empacotamento->coleta->numero_coleta); ?></span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600">Estabelecimento:</span>
                                <span class="text-sm font-medium text-gray-900 ml-2"><?php echo e($empacotamento->coleta->estabelecimento->razao_social); ?></span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600">Peso Total:</span>
                                <span class="text-sm font-medium text-gray-900 ml-2"><?php echo e(number_format($empacotamento->coleta->peso_total, 2, ',', '.')); ?> kg</span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600">Responsável:</span>
                                <span class="text-sm font-medium text-gray-900 ml-2"><?php echo e($empacotamento->usuarioEmpacotamento->nome); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aviso sobre edição -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="text-sm font-semibold text-yellow-800 mb-1">Atenção</h4>
                            <p class="text-sm text-yellow-700">
                                Alterações nas quantidades empacotadas afetarão os cálculos de valor e peso total do empacotamento. 
                                Certifique-se de que os dados estão corretos antes de salvar.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botões de Ação -->
        <div class="flex flex-col sm:flex-row gap-3 sm:justify-end mt-6">
            <a href="<?php echo e(route('empacotamento.show', $empacotamento->id)); ?>" 
               class="inline-flex items-center justify-center px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-700 text-sm font-medium rounded-xl transition-colors duration-200">
                Cancelar
            </a>
            <button type="submit" 
                    class="inline-flex items-center justify-center px-6 py-3 bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Salvar Alterações
            </button>
        </div>
    </form>
</div>

<!-- Modal Adicionar Peça Extra -->
<div id="modalPecaExtra" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Adicionar Peça Extra</h3>
                <button type="button" onclick="fecharModalPecaExtra()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="formPecaExtra">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Peça</label>
                    <select id="tipoExtraSelect" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        <option value="">Selecione um tipo...</option>
                        <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($tipo->id); ?>" data-nome="<?php echo e($tipo->nome); ?>" data-categoria="<?php echo e($tipo->categoria); ?>">
                                <?php echo e($tipo->nome); ?> (<?php echo e($tipo->categoria); ?>)
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Quantidade</label>
                    <input type="number" id="quantidadeExtra" min="1" value="1"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
                    <textarea id="observacoesExtra" rows="3" placeholder="Ex: Peça encontrada durante empacotamento..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500"></textarea>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="fecharModalPecaExtra()"
                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 text-sm font-medium rounded-md transition-colors">
                        Cancelar
                    </button>
                    <button type="button" onclick="adicionarPecaExtra()"
                            class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-md transition-colors">
                        Adicionar Peça
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Função para toggle do tipo de peça (expandir/recolher)
    window.toggleTipoEdicao = function(tipoId) {
        const content = document.getElementById(`content-${tipoId}`);
        const chevron = document.getElementById(`chevron-${tipoId}`);

        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            chevron.style.transform = 'rotate(180deg)';
        } else {
            content.classList.add('hidden');
            chevron.style.transform = 'rotate(0deg)';
        }
    };

    // Função para duplicar lote (adicionar novo lote do mesmo tipo)
    window.duplicarLoteEdicao = function(tipoId, tipoNome) {
        const container = document.querySelector(`#content-${tipoId} .space-y-3`);
        const novoIndex = Date.now();

        const novoLote = document.createElement('div');
        novoLote.className = 'lote-empacotamento flex items-center space-x-3 p-3 bg-gray-50 rounded border';
        novoLote.innerHTML = `
            <div class="flex-1 grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Código QR</label>
                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-mono font-medium bg-yellow-100 text-yellow-800">
                        Será gerado
                    </span>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Quantidade</label>
                    <input type="number"
                           name="novos_lotes[${novoIndex}][quantidade]"
                           value="0"
                           min="0"
                           data-tipo-id="${tipoId}"
                           onchange="atualizarStatusTipo('${tipoId}')"
                           oninput="atualizarStatusTipo('${tipoId}')"
                           class="quantidade-lote w-full px-2 py-1 text-center border border-gray-300 rounded text-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                    <input type="hidden" name="novos_lotes[${novoIndex}][tipo_id]" value="${tipoId}">
                    <input type="hidden" name="novos_lotes[${novoIndex}][tipo_nome]" value="${tipoNome}">
                    <input type="hidden" name="novos_lotes[${novoIndex}][peso]" value="0">
                </div>
            </div>
            <div class="flex-shrink-0">
                <button type="button" onclick="removerNovoLote(this, '${tipoId}')"
                        class="inline-flex items-center px-2 py-1 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-medium rounded transition-colors"
                        title="Remover lote">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
        `;

        container.appendChild(novoLote);

        // Atualizar status após adicionar
        atualizarStatusTipo(tipoId);

        // Scroll suave para o novo lote
        setTimeout(() => {
            novoLote.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });

            // Focar no input de quantidade
            const input = novoLote.querySelector('.quantidade-lote');
            if (input) {
                input.focus();
                input.select();
            }
        }, 100);
    };

    // Função para remover lote existente
    window.removerLoteEdicao = function(pecaId) {
        if (confirm('Tem certeza que deseja remover este lote? Esta ação não pode ser desfeita.')) {
            // Adicionar campo hidden para marcar como removido
            const form = document.querySelector('form');
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'lotes_removidos[]';
            hiddenInput.value = pecaId;
            form.appendChild(hiddenInput);

            // Obter tipo antes de remover
            const lote = document.querySelector(`input[name="pecas_individuais[${pecaId}][quantidade]"]`).closest('.lote-empacotamento');
            const tipoContainer = lote.closest('.tipo-peca-container');
            const tipoId = tipoContainer.querySelector('.tipo-peca-header').onclick.toString().match(/'(\d+)'/)[1];

            // Remover visualmente
            lote.remove();

            // Atualizar status
            atualizarStatusTipo(tipoId);
        }
    };

    // Função para remover novo lote
    window.removerNovoLote = function(botao, tipoId) {
        botao.closest('.lote-empacotamento').remove();
        atualizarStatusTipo(tipoId);
    };

    // Função para atualizar status do tipo em tempo real
    window.atualizarStatusTipo = function(tipoId) {
        const tipoContainer = document.querySelector(`[onclick*="'${tipoId}'"]`).closest('.tipo-peca-container');

        // Buscar quantidade coletada (do atributo data)
        const header = tipoContainer.querySelector('.tipo-peca-header');
        const quantidadeColetada = parseInt(header.dataset.quantidadeColetada) || 0;

        // Calcular total empacotado (lotes existentes + novos lotes)
        let totalEmpacotado = 0;
        let totalLotes = 0;

        // Lotes existentes
        const lotesExistentes = tipoContainer.querySelectorAll('input[name*="pecas_individuais"]');
        lotesExistentes.forEach(input => {
            if (input.name.includes('[quantidade]')) {
                totalEmpacotado += parseInt(input.value) || 0;
                totalLotes++;
            }
        });

        // Novos lotes
        const novosLotes = tipoContainer.querySelectorAll('input[name*="novos_lotes"]');
        novosLotes.forEach(input => {
            if (input.name.includes('[quantidade]')) {
                totalEmpacotado += parseInt(input.value) || 0;
                totalLotes++;
            }
        });

        // Calcular diferença
        const diferenca = totalEmpacotado - quantidadeColetada;

        // Atualizar displays na barra (buscar de forma mais específica)
        const headerDiv = tipoContainer.querySelector('.tipo-peca-header');
        const displays = headerDiv.querySelectorAll('.text-right .text-sm.font-medium');

        if (displays.length < 4) {
            console.error('Não foi possível encontrar todos os displays necessários');
            return;
        }

        const empacotadoDisplay = displays[1]; // Segundo display (Empacotado)
        const statusDisplay = displays[2];     // Terceiro display (Status)
        const lotesDisplay = displays[3];      // Quarto display (Lotes)

        // Atualizar quantidade empacotada
        empacotadoDisplay.textContent = `${totalEmpacotado} peças`;

        // Atualizar status e cores
        if (diferenca === 0) {
            statusDisplay.textContent = '✓ Confere';
            statusDisplay.className = 'text-sm font-medium text-green-600';
            empacotadoDisplay.className = 'text-sm font-medium text-green-600';
        } else if (diferenca > 0) {
            statusDisplay.textContent = `+${diferenca} a mais`;
            statusDisplay.className = 'text-sm font-medium text-orange-600';
            empacotadoDisplay.className = 'text-sm font-medium text-orange-600';
        } else {
            statusDisplay.textContent = `${Math.abs(diferenca)} faltando`;
            statusDisplay.className = 'text-sm font-medium text-red-600';
            empacotadoDisplay.className = 'text-sm font-medium text-red-600';
        }

        // Atualizar número de lotes
        lotesDisplay.textContent = `${totalLotes} lotes`;
    };

    // Função para abrir modal de peça extra
    window.abrirModalPecaExtra = function() {
        document.getElementById('modalPecaExtra').classList.remove('hidden');
        document.getElementById('tipoExtraSelect').focus();
    };

    // Função para fechar modal de peça extra
    window.fecharModalPecaExtra = function() {
        document.getElementById('modalPecaExtra').classList.add('hidden');
        // Limpar campos
        document.getElementById('tipoExtraSelect').value = '';
        document.getElementById('quantidadeExtra').value = '1';
        document.getElementById('observacoesExtra').value = '';
    };

    // Função para adicionar peça extra
    window.adicionarPecaExtra = function() {
        const tipoSelect = document.getElementById('tipoExtraSelect');
        const quantidade = document.getElementById('quantidadeExtra').value;
        const observacoes = document.getElementById('observacoesExtra').value;

        console.log('Adicionando peça extra:', { tipoSelect: tipoSelect.value, quantidade, observacoes });

        // Validações
        if (!tipoSelect.value) {
            alert('Por favor, selecione um tipo de peça.');
            return;
        }

        if (!quantidade || quantidade < 1) {
            alert('Por favor, informe uma quantidade válida.');
            return;
        }

        const tipoId = tipoSelect.value;
        const tipoNome = tipoSelect.options[tipoSelect.selectedIndex].dataset.nome;
        const tipoCategoria = tipoSelect.options[tipoSelect.selectedIndex].dataset.categoria;

        console.log('Dados da peça extra:', { tipoId, tipoNome, tipoCategoria, quantidade, observacoes });

        // Verificar se já existe um container para este tipo
        // Buscar pelo container principal, não pelos inputs
        let tipoContainer = document.querySelector(`.tipo-peca-container[onclick*="'${tipoId}'"]`) ||
                           document.querySelector(`[onclick*="toggleTipoEdicao('${tipoId}')"]`)?.closest('.tipo-peca-container');

        console.log('Container existente encontrado:', tipoContainer);

        if (tipoContainer) {
            // Se já existe, adicionar um novo lote ao tipo existente
            const container = tipoContainer.querySelector('.space-y-3');
            console.log('Container de lotes encontrado:', container);

            if (!container) {
                console.error('Não foi possível encontrar o container de lotes dentro do tipo existente');
                return;
            }

            const novoIndex = Date.now();

            const novoLote = document.createElement('div');
            novoLote.className = 'lote-empacotamento flex items-center space-x-3 p-3 bg-purple-50 rounded border border-purple-200';
            novoLote.innerHTML = `
                <div class="flex-1 grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Código QR</label>
                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-mono font-medium bg-purple-100 text-purple-800">
                            Será gerado (EXTRA)
                        </span>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Quantidade</label>
                        <input type="number"
                               name="pecas_extras[${novoIndex}][quantidade]"
                               value="${quantidade}"
                               min="0"
                               data-tipo-id="${tipoId}"
                               onchange="atualizarStatusTipo('${tipoId}')"
                               oninput="atualizarStatusTipo('${tipoId}')"
                               class="quantidade-lote w-full px-2 py-1 text-center border border-gray-300 rounded text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        <input type="hidden" name="pecas_extras[${novoIndex}][tipo_id]" value="${tipoId}">
                        <input type="hidden" name="pecas_extras[${novoIndex}][tipo_nome]" value="${tipoNome}">
                        <input type="hidden" name="pecas_extras[${novoIndex}][observacoes]" value="Peça extra: ${observacoes}">
                        <input type="hidden" name="pecas_extras[${novoIndex}][peso]" value="0">
                    </div>
                </div>
                <div class="flex-shrink-0">
                    <button type="button" onclick="removerNovoLote(this, '${tipoId}')"
                            class="inline-flex items-center px-2 py-1 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-medium rounded transition-colors"
                            title="Remover peça extra">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            `;

            container.appendChild(novoLote);
            console.log('Novo lote adicionado ao tipo existente');
            atualizarStatusTipo(tipoId);

        } else {
            // Se não existe, criar um novo container para este tipo
            console.log('Tipo não existe, criando novo container');
            criarNovoTipoExtra(tipoId, tipoNome, tipoCategoria, quantidade, observacoes);
        }

        // Fechar modal
        fecharModalPecaExtra();

        console.log('Peça extra adicionada com sucesso!');

        // Scroll para o novo item
        setTimeout(() => {
            const ultimoLote = document.querySelector(`[onclick*="'${tipoId}'"]`)?.closest('.tipo-peca-container')?.querySelector('.lote-empacotamento:last-child');
            if (ultimoLote) {
                ultimoLote.scrollIntoView({ behavior: 'smooth', block: 'center' });
                console.log('Scroll realizado para o novo lote');
            } else {
                console.log('Não foi possível encontrar o lote para scroll');
            }
        }, 100);
    };

    // Função para criar novo tipo extra
    window.criarNovoTipoExtra = function(tipoId, tipoNome, tipoCategoria, quantidade, observacoes) {
        console.log('Criando novo tipo extra:', { tipoId, tipoNome, tipoCategoria, quantidade, observacoes });

        const novoIndex = Date.now();

        const novoTipoContainer = document.createElement('div');
        novoTipoContainer.className = 'tipo-peca-container border border-purple-200 rounded-lg overflow-hidden mb-4';
        novoTipoContainer.setAttribute('data-tipo-id', tipoId);

        novoTipoContainer.innerHTML = `
            <!-- Barra/Título do Tipo Extra -->
            <div class="tipo-peca-header bg-gradient-to-r from-purple-50 to-pink-50 border-b border-purple-200 p-4 cursor-pointer hover:from-purple-100 hover:to-pink-100 transition-colors"
                 onclick="toggleTipoEdicao('${tipoId}')"
                 data-quantidade-coletada="0">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
                        <div>
                            <h5 class="text-sm font-semibold text-gray-900">${tipoNome} <span class="text-purple-600">(EXTRA)</span></h5>
                            <p class="text-xs text-gray-500">${tipoCategoria}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <div class="text-xs text-gray-500">Coletado</div>
                            <div class="text-sm font-medium text-gray-900">0 peças</div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs text-gray-500">Empacotado</div>
                            <div class="text-sm font-medium text-purple-600">${quantidade} peças</div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs text-gray-500">Status</div>
                            <div class="text-sm font-medium text-orange-600">+${quantidade} a mais</div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs text-gray-500">Lotes</div>
                            <div class="text-sm font-medium text-purple-600">1 lotes</div>
                        </div>
                        <svg id="chevron-${tipoId}" class="w-5 h-5 text-gray-400 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Área de Conteúdo (Lotes) -->
            <div id="content-${tipoId}" class="tipo-peca-content hidden bg-white">
                <div class="p-4">
                    <div class="mb-4">
                        <span class="text-sm font-medium text-gray-700">Lotes de empacotamento:</span>
                    </div>

                    <div class="space-y-3">
                        <div class="lote-empacotamento flex items-center space-x-3 p-3 bg-purple-50 rounded border border-purple-200">
                            <div class="flex-1 grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Código QR</label>
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-mono font-medium bg-purple-100 text-purple-800">
                                        Será gerado (EXTRA)
                                    </span>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Quantidade</label>
                                    <input type="number"
                                           name="pecas_extras[${novoIndex}][quantidade]"
                                           value="${quantidade}"
                                           min="0"
                                           data-tipo-id="${tipoId}"
                                           onchange="atualizarStatusTipo('${tipoId}')"
                                           oninput="atualizarStatusTipo('${tipoId}')"
                                           class="quantidade-lote w-full px-2 py-1 text-center border border-gray-300 rounded text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                    <input type="hidden" name="pecas_extras[${novoIndex}][tipo_id]" value="${tipoId}">
                                    <input type="hidden" name="pecas_extras[${novoIndex}][tipo_nome]" value="${tipoNome}">
                                    <input type="hidden" name="pecas_extras[${novoIndex}][observacoes]" value="Peça extra: ${observacoes}">
                                    <input type="hidden" name="pecas_extras[${novoIndex}][peso]" value="0">
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <button type="button" onclick="removerTipoExtra('${tipoId}')"
                                        class="inline-flex items-center px-2 py-1 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-medium rounded transition-colors"
                                        title="Remover tipo extra">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Botão Adicionar Lote no final -->
                    <div class="mt-4 pt-3 border-t border-gray-200">
                        <button type="button" onclick="duplicarLoteEdicao('${tipoId}', '${tipoNome}')"
                                class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Adicionar Novo Lote
                        </button>
                    </div>
                </div>
            </div>
        `;

        // Inserir antes do botão "Adicionar Peça Extra"
        // Buscar o container pai que contém tanto os tipos quanto o botão
        const containerPai = document.querySelector('.bg-white.rounded-xl.shadow-sm') ||
                            document.querySelector('.bg-white.rounded-xl');
        const containerTipos = containerPai?.querySelector('.p-4');
        const botaoExtraContainer = document.querySelector('.p-4.border-t.border-gray-200.bg-gray-50');

        console.log('Container pai:', containerPai);
        console.log('Container tipos:', containerTipos);
        console.log('Botão extra container:', botaoExtraContainer);

        if (containerPai && botaoExtraContainer) {
            // Verificar se o botão é realmente filho do container pai
            if (containerPai.contains(botaoExtraContainer)) {
                containerPai.insertBefore(novoTipoContainer, botaoExtraContainer);
                console.log('Novo tipo extra inserido com sucesso antes do botão no container pai');
            } else {
                console.log('Botão não é filho do container pai, inserindo no final');
                containerPai.appendChild(novoTipoContainer);
                console.log('Novo tipo extra inserido no final do container pai');
            }
        } else {
            // Abordagem mais simples: sempre inserir no final do container de tipos
            const containerSeguro = containerTipos || containerPai;

            if (containerSeguro) {
                containerSeguro.appendChild(novoTipoContainer);
                console.log('Novo tipo extra inserido com sucesso usando abordagem segura');
            } else {
                // Último fallback: inserir em qualquer container disponível
                const qualquerContainer = document.querySelector('.container') ||
                                        document.querySelector('.max-w-7xl') ||
                                        document.querySelector('main') ||
                                        document.body;

                if (qualquerContainer) {
                    qualquerContainer.appendChild(novoTipoContainer);
                    console.log('Novo tipo extra inserido usando fallback extremo');
                } else {
                    console.error('Não foi possível encontrar NENHUM container para inserir o novo tipo');
                }
            }
        }

        // Verificar se foi realmente inserido
        setTimeout(() => {
            const verificacao = document.querySelector(`[data-tipo-id="${tipoId}"]`);
            if (verificacao) {
                console.log('✅ Verificação: Novo tipo foi inserido com sucesso na DOM');
            } else {
                console.error('❌ Verificação: Novo tipo NÃO foi inserido na DOM');
            }
        }, 100);
    };

    // Função para remover tipo extra completo
    window.removerTipoExtra = function(tipoId) {
        if (confirm('Tem certeza que deseja remover este tipo extra completo?')) {
            const tipoContainer = document.querySelector(`[data-tipo-id="${tipoId}"]`);
            if (tipoContainer) {
                tipoContainer.remove();
            }
        }
    };

    // Inicializar status de todos os tipos ao carregar a página
    function inicializarStatus() {
        document.querySelectorAll('.tipo-peca-container').forEach(container => {
            const headerOnclick = container.querySelector('.tipo-peca-header').onclick.toString();
            const tipoId = headerOnclick.match(/'(\d+)'/)[1];
            atualizarStatusTipo(tipoId);
        });
    }

    // Executar inicialização
    inicializarStatus();
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Tipos de peças disponíveis
const tiposDisponiveis = <?php echo json_encode($tipos, 15, 512) ?>;
let contadorNovasPecas = 0;

// Função para adicionar nova linha de peça
function adicionarLinhaPeca() {
    const tabela = document.getElementById('tabela-pecas-empacotamento');
    
    // Criar opções do select
    let opcoesSelect = '<option value="">Selecione um tipo</option>';
    tiposDisponiveis.forEach(function(tipo) {
        opcoesSelect += `<option value="${tipo.id}">${tipo.nome} (${tipo.categoria})</option>`;
    });

    // Criar nova linha
    const novaLinha = document.createElement('tr');
    novaLinha.className = 'linha-nova-peca hover:bg-gray-50';
    novaLinha.innerHTML = `
        <td class="px-6 py-4 whitespace-nowrap">
            <select name="novas_pecas[${contadorNovasPecas}][tipo_id]" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500" 
                    required>
                ${opcoesSelect}
            </select>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-center">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                Nova
            </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-center">
            <input type="number" 
                   name="novas_pecas[${contadorNovasPecas}][quantidade]"
                   min="1" 
                   placeholder="1"
                   class="w-20 px-2 py-1 text-center border border-gray-300 rounded text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500"
                   required>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-center">
            <input type="number" 
                   name="novas_pecas[${contadorNovasPecas}][peso]"
                   step="0.01" 
                   min="0"
                   placeholder="0.00"
                   class="w-20 px-2 py-1 text-center border border-gray-300 rounded text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-center">
            <button type="button" 
                    onclick="removerLinhaPeca(this)"
                    class="inline-flex items-center px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded transition-colors duration-200">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Remover
            </button>
        </td>
    `;

    // Adicionar a linha à tabela
    tabela.appendChild(novaLinha);
    contadorNovasPecas++;
}

// Função para remover linha de peça
function removerLinhaPeca(botao) {
    const linha = botao.closest('tr');
    if (linha.classList.contains('linha-nova-peca')) {
        linha.remove();
    }
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\lavanderia\resources\views/empacotamento/edit.blade.php ENDPATH**/ ?>