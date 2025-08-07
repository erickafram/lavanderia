

<?php $__env->startSection('title', 'Dashboard do Motorista'); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://unpkg.com/qr-scanner@1.4.2/qr-scanner.umd.min.js"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-4">
    <!-- Header -->
    <div class="mb-4">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard do Motorista</h1>
        <p class="text-gray-600 text-sm">Gerencie suas entregas</p>
    </div>

    <!-- Cards de Estatísticas - Compactos -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="p-2 rounded-full bg-green-100">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600">Prontos</p>
                    <p class="text-xl font-bold text-gray-900"><?php echo e($prontos); ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="p-2 rounded-full bg-blue-100">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600">Em Trânsito</p>
                    <p class="text-xl font-bold text-gray-900"><?php echo e($emTransito); ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="p-2 rounded-full bg-purple-100">
                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600">Hoje</p>
                    <p class="text-xl font-bold text-gray-900"><?php echo e($entreguesHoje); ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="p-2 rounded-full bg-gray-100">
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600">Total</p>
                    <p class="text-xl font-bold text-gray-900"><?php echo e($total); ?></p>
                </div>
            </div>
        </div>
    </div>



    <!-- Abas Principais -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-2 px-4">
                <button onclick="showMainTab('scanner')" id="tab-scanner"
                        class="main-tab-button py-3 px-4 border-b-2 border-green-500 font-medium text-sm text-green-600">
                    📷 Scanner Múltiplo
                </button>
                <button onclick="showMainTab('prontos')" id="tab-prontos"
                        class="main-tab-button py-3 px-4 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    📦 Prontos (<?php echo e($prontos); ?>)
                </button>
                <button onclick="showMainTab('transito')" id="tab-transito"
                        class="main-tab-button py-3 px-4 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    🚚 Em Trânsito (<?php echo e($emTransito); ?>)
                </button>
                <button onclick="showMainTab('entregues')" id="tab-entregues"
                        class="main-tab-button py-3 px-4 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    ✅ Entregues (<?php echo e($entreguesHoje); ?>)
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-4">
            <!-- Scanner Múltiplo -->
            <div id="content-scanner" class="main-tab-content">
                <div class="space-y-4">
                    <div class="text-center">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">📷 Scanner Múltiplo de QR Codes</h3>
                        <p class="text-gray-600 text-sm">Escaneie vários empacotamentos e processe em lote</p>
                    </div>

                    <!-- Modo de entrada -->
                    <div class="flex gap-2 mb-3">
                        <button onclick="alternarModo('camera')" id="btnModoCamera" 
                                class="flex-1 px-3 py-2 bg-green-600 text-white rounded-lg text-sm font-medium">
                            📷 Escanear Múltiplo
                        </button>
                        <button onclick="alternarModo('manual')" id="btnModoManual" 
                                class="flex-1 px-3 py-2 bg-gray-300 text-gray-700 rounded-lg text-sm font-medium">
                            ⌨️ Digitar Manual
                        </button>
                    </div>

                    <!-- Scanner de Câmera -->
                    <div id="modoCamera" class="mb-3">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <!-- Área da Câmera -->
                            <div class="space-y-3">
                                <div class="relative bg-black rounded-lg overflow-hidden">
                                    <video id="qr-video" class="w-full h-64 object-cover"></video>
                                    <div id="qr-resultado" class="absolute top-2 left-2 bg-green-600 text-white px-2 py-1 rounded text-sm hidden">
                                        ✅ QR Code detectado!
                                    </div>
                                    <div id="qr-overlay" class="absolute inset-0 border-2 border-green-400 rounded-lg pointer-events-none hidden">
                                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-32 h-32 border-2 border-green-400 rounded-lg"></div>
                                    </div>
                                    <div id="qr-contador" class="absolute bottom-2 right-2 bg-blue-600 text-white px-2 py-1 rounded text-sm">
                                        Escaneados: <span id="contador-numero">0</span>
                                    </div>
                                </div>
                                <div class="flex gap-2 justify-center">
                                    <button onclick="iniciarScanner()" id="btnIniciarCamera" 
                                            class="px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition-colors">
                                        📷 Iniciar Scanner
                                    </button>
                                    <button onclick="pararScanner()" id="btnPararCamera" 
                                            class="px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition-colors hidden">
                                        ⏹️ Parar
                                    </button>
                                    <button onclick="limparLista()" id="btnLimparLista" 
                                            class="px-4 py-2 bg-gray-600 text-white text-sm rounded-lg hover:bg-gray-700 transition-colors">
                                        🗑️ Limpar
                                    </button>
                                </div>
                            </div>

                            <!-- Lista de Empacotamentos Escaneados -->
                            <div class="space-y-3">
                                <h4 class="font-semibold text-gray-800">📦 Empacotamentos Escaneados</h4>
                                <div id="lista-escaneados" class="max-h-64 overflow-y-auto space-y-2 border rounded-lg p-3 bg-gray-50">
                                    <div class="text-gray-500 text-sm text-center py-4">
                                        Nenhum empacotamento escaneado ainda
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <button onclick="processarTodosProntos()" id="btnTodosProntos" 
                                            class="flex-1 px-3 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors disabled:bg-gray-400" disabled>
                                        🚚 Confirmar Saídas
                                    </button>
                                    <button onclick="processarTodosEntrega()" id="btnTodosEntrega" 
                                            class="flex-1 px-3 py-2 bg-purple-600 text-white text-sm rounded-lg hover:bg-purple-700 transition-colors disabled:bg-gray-400" disabled>
                                        📋 Confirmar Entregas
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Entrada Manual -->
                    <div id="modoManual" class="hidden mb-3">
                        <div class="flex gap-2">
                            <input type="text" id="codigoBusca" placeholder="Digite o código QR..." 
                                   class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                   onkeypress="if(event.key==='Enter') buscarParaAcao()">
                            <button onclick="buscarParaAcao()" id="btnProcessar" 
                                    class="px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition-colors">
                                📱 Processar
                            </button>
                        </div>
                    </div>

                    <div id="statusBusca" class="mt-2 text-sm hidden"></div>
                    <div class="mt-2 text-xs text-gray-500 text-center">
                        💡 <strong>Modo Scanner:</strong> Escaneie múltiplos QR codes e processe todos de uma vez<br>
                        💡 <strong>Modo Manual:</strong> Digite um código por vez para ação imediata
                    </div>
                </div>
            </div>

            <!-- Prontos para Entrega -->
            <div id="content-prontos" class="main-tab-content hidden">
                <?php $__empty_1 = true; $__currentLoopData = $empacotamentosProntos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empacotamento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="border border-gray-200 rounded-lg p-3 mb-3">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="font-bold text-base"><?php echo e($empacotamento->codigo_qr); ?></h3>
                                <p class="text-blue-600 font-medium text-sm"><?php echo e($empacotamento->status->nome); ?></p>
                                <?php if($empacotamento->coleta && $empacotamento->coleta->estabelecimento): ?>
                                    <p class="text-gray-900 font-medium text-sm"><?php echo e(Str::limit($empacotamento->coleta->estabelecimento->nome_fantasia ?? $empacotamento->coleta->estabelecimento->razao_social, 30)); ?></p>
                                <?php else: ?>
                                    <p class="text-red-600 font-medium text-sm">Estabelecimento não encontrado</p>
                                <?php endif; ?>
                                <p class="text-gray-600 text-xs"><?php echo e($empacotamento->data_empacotamento->format('d/m/Y H:i')); ?></p>
                            </div>
                            <button onclick="confirmarSaida(<?php echo e($empacotamento->id); ?>)"
                                    class="px-3 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 ml-2">
                                Confirmar Saída
                            </button>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-500 text-center py-6 text-sm">Nenhum empacotamento pronto para entrega</p>
                <?php endif; ?>
            </div>

            <!-- Em Trânsito -->
            <div id="content-transito" class="tab-content hidden">
                <?php $__empty_1 = true; $__currentLoopData = $empacotamentosTransito; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empacotamento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="border border-gray-200 rounded-lg p-3 mb-3">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="font-bold text-base"><?php echo e($empacotamento->codigo_qr); ?></h3>
                                <p class="text-yellow-600 font-medium text-sm"><?php echo e($empacotamento->status->nome); ?></p>
                                <?php if($empacotamento->coleta && $empacotamento->coleta->estabelecimento): ?>
                                    <p class="text-gray-900 font-medium text-sm"><?php echo e(Str::limit($empacotamento->coleta->estabelecimento->nome_fantasia ?? $empacotamento->coleta->estabelecimento->razao_social, 30)); ?></p>
                                <?php else: ?>
                                    <p class="text-red-600 font-medium text-sm">Estabelecimento não encontrado</p>
                                <?php endif; ?>
                                <?php if($empacotamento->entrega && $empacotamento->entrega->data_saida): ?>
                                    <p class="text-gray-600 text-xs">Saída: <?php echo e($empacotamento->entrega->data_saida->format('d/m/Y H:i')); ?></p>
                                <?php endif; ?>
                            </div>
                            <button onclick="abrirModalEntrega(<?php echo e($empacotamento->id); ?>, '<?php echo e($empacotamento->codigo_qr); ?>')"
                                    class="px-3 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 ml-2">
                                Confirmar Entrega
                            </button>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-500 text-center py-6 text-sm">Nenhum empacotamento em trânsito</p>
                <?php endif; ?>
            </div>

            <!-- Entregues Hoje -->
            <div id="content-entregues" class="main-tab-content hidden">
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">✅ Entregas Realizadas Hoje</h3>
                    <p class="text-gray-600 text-sm">Histórico completo com assinaturas de recebimento</p>
                </div>
                
                <?php $__empty_1 = true; $__currentLoopData = $empacotamentosEntregues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empacotamento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="border border-gray-200 rounded-lg p-4 mb-4 bg-green-50">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                            <!-- Informações do Empacotamento -->
                            <div class="lg:col-span-2">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex-1">
                                        <h4 class="font-bold text-lg text-gray-900"><?php echo e($empacotamento->codigo_qr); ?></h4>
                                        <span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium mt-1">
                                            ✅ <?php echo e($empacotamento->status->nome); ?>

                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Estabelecimento -->
                                <?php if($empacotamento->coleta && $empacotamento->coleta->estabelecimento): ?>
                                    <div class="mb-2">
                                        <p class="text-gray-700 font-medium">📍 <?php echo e($empacotamento->coleta->estabelecimento->nome_fantasia ?? $empacotamento->coleta->estabelecimento->razao_social); ?></p>
                                    </div>
                                <?php else: ?>
                                    <div class="mb-2">
                                        <p class="text-red-600 font-medium">📍 Estabelecimento não encontrado</p>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Informações de Entrega -->
                                <?php if($empacotamento->entrega): ?>
                                    <div class="space-y-1 text-sm">
                                        <p class="text-gray-600">
                                            <span class="font-medium">🕐 Data/Hora:</span> 
                                            <?php echo e($empacotamento->entrega->data_entrega->format('d/m/Y H:i')); ?>

                                        </p>
                                        <?php if($empacotamento->entrega->nome_recebedor): ?>
                                            <p class="text-gray-600">
                                                <span class="font-medium">👤 Recebido por:</span> 
                                                <?php echo e($empacotamento->entrega->nome_recebedor); ?>

                                            </p>
                                        <?php endif; ?>
                                        <?php if($empacotamento->entrega->observacoes): ?>
                                            <p class="text-gray-600">
                                                <span class="font-medium">📝 Observações:</span> 
                                                <?php echo e(Str::limit($empacotamento->entrega->observacoes, 100)); ?>

                                            </p>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Assinatura -->
                            <div class="flex flex-col">
                                <h5 class="font-medium text-gray-700 mb-2">✍️ Assinatura de Recebimento</h5>
                                <?php if($empacotamento->entrega && $empacotamento->entrega->assinatura_recebedor): ?>
                                    <div class="border-2 border-gray-300 rounded-lg bg-white p-2 flex-1 min-h-[120px] flex items-center justify-center">
                                        <img src="<?php echo e($empacotamento->entrega->assinatura_recebedor); ?>" 
                                             alt="Assinatura de <?php echo e($empacotamento->entrega->nome_recebedor); ?>"
                                             class="max-w-full max-h-full object-contain">
                                    </div>
                                    <button onclick="verAssinaturaCompleta('<?php echo e($empacotamento->entrega->assinatura_recebedor); ?>', '<?php echo e($empacotamento->entrega->nome_recebedor); ?>', '<?php echo e($empacotamento->codigo_qr); ?>')"
                                            class="mt-2 text-xs text-blue-600 hover:text-blue-800 underline">
                                        👁️ Ver assinatura completa
                                    </button>
                                <?php else: ?>
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg bg-gray-100 p-4 flex-1 min-h-[120px] flex items-center justify-center">
                                        <p class="text-gray-500 text-sm text-center">
                                            Assinatura não disponível
                                        </p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-12">
                        <div class="text-gray-400 text-6xl mb-4">📋</div>
                        <p class="text-gray-500 text-lg">Nenhuma entrega realizada hoje</p>
                        <p class="text-gray-400 text-sm">As entregas aparecerão aqui após serem confirmadas</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Saída - Ação Rápida -->
<div id="modalSaida" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-sm w-full">
            <div class="p-4">
                <h3 class="text-base font-bold text-green-900 mb-3">🚚 Confirmar Saída para Entrega</h3>
                <div class="bg-green-50 p-3 rounded-lg mb-3">
                    <p class="text-green-800 text-sm font-medium">QR Code: <span id="codigoSaida" class="font-mono"></span></p>
                    <p class="text-green-700 text-xs" id="estabelecimentoSaida"></p>
                    <p class="text-green-600 text-xs" id="dataSaida"></p>
                </div>

                <div class="flex gap-2">
                    <button type="button" onclick="fecharModalSaida()"
                            class="flex-1 px-3 py-2 text-sm border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Cancelar
                    </button>
                    <button onclick="confirmarSaidaRapida()"
                            class="flex-1 px-3 py-2 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700">
                        ✅ Confirmar Saída
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Entrega - Compacto -->
<div id="modalEntrega" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-sm w-full">
            <div class="p-4">
                <h3 class="text-base font-bold text-gray-900 mb-3">Confirmar Entrega</h3>
                <p class="text-gray-600 mb-3 text-sm">QR: <span id="codigoEntrega" class="font-mono font-bold"></span></p>

                <form id="formEntrega">
                    <input type="hidden" id="empacotamentoId" name="empacotamento_id">

                    <div class="mb-3">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Nome de quem recebeu</label>
                        <input type="text" id="nomeRecebedor" name="nome_recebedor" required
                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Nome completo">
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Assinatura</label>
                        <div class="border border-gray-300 rounded-lg">
                            <canvas id="canvasAssinatura" width="300" height="120" class="w-full cursor-crosshair"></canvas>
                        </div>
                        <div class="flex justify-between mt-1">
                            <button type="button" onclick="limparAssinatura()"
                                    class="text-xs text-gray-600 hover:text-gray-800">
                                Limpar
                            </button>
                            <span class="text-xs text-gray-500">Desenhe acima</span>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <button type="button" onclick="fecharModalEntrega()"
                                class="flex-1 px-3 py-2 text-sm border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="flex-1 px-3 py-2 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700">
                            Confirmar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Ver Assinatura Completa -->
<div id="modalAssinatura" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">✍️ Assinatura de Recebimento</h3>
                    <button onclick="fecharModalAssinatura()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-sm text-gray-600"><span class="font-medium">Empacotamento:</span> <span id="assinatura-codigo"></span></p>
                        <p class="text-sm text-gray-600"><span class="font-medium">Recebido por:</span> <span id="assinatura-nome"></span></p>
                    </div>
                    
                    <div class="border-2 border-gray-300 rounded-lg bg-white p-4 text-center">
                        <img id="assinatura-imagem" src="" alt="Assinatura" class="max-w-full h-auto mx-auto" style="max-height: 300px;">
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end">
                    <button onclick="fecharModalAssinatura()" 
                            class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Variáveis globais para assinatura
let canvas, ctx, isDrawing = false;

// Variáveis globais para scanner QR
let qrScanner = null;
let videoElement = null;
let modoAtual = 'camera'; // Iniciar com scanner como padrão
let empacotamentosEscaneados = [];
let contadorEscaneados = 0;

document.addEventListener('DOMContentLoaded', function() {
    // Inicializar elemento de vídeo para scanner
    videoElement = document.getElementById('qr-video');
    
    // Inicializar no modo scanner por padrão
    showMainTab('scanner');

    // Inicializar canvas de assinatura
    canvas = document.getElementById('canvasAssinatura');
    ctx = canvas.getContext('2d');
    
    // Configurar canvas
    ctx.strokeStyle = '#000';
    ctx.lineWidth = 2;
    ctx.lineCap = 'round';
    
    // Event listeners para desenhar
    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mouseout', stopDrawing);
    
    // Touch events para mobile
    canvas.addEventListener('touchstart', handleTouch);
    canvas.addEventListener('touchmove', handleTouch);
    canvas.addEventListener('touchend', stopDrawing);
});

function showMainTab(tabName) {
    // Esconder todos os conteúdos
    document.querySelectorAll('.main-tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remover classe ativa de todos os botões
    document.querySelectorAll('.main-tab-button').forEach(button => {
        button.classList.remove('border-green-500', 'text-green-600', 'border-blue-500', 'text-blue-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Mostrar conteúdo ativo
    document.getElementById('content-' + tabName).classList.remove('hidden');
    
    // Ativar botão com cor apropriada
    const activeButton = document.getElementById('tab-' + tabName);
    activeButton.classList.remove('border-transparent', 'text-gray-500');
    
    if (tabName === 'scanner') {
        activeButton.classList.add('border-green-500', 'text-green-600');
        // Inicializar modo camera quando abrir scanner
        alternarModo('camera');
    } else {
        activeButton.classList.add('border-blue-500', 'text-blue-600');
    }
}

// Funções do Scanner QR Code
function alternarModo(modo) {
    modoAtual = modo;
    
    // Parar scanner se estiver ativo
    if (qrScanner) {
        pararScanner();
    }
    
    if (modo === 'manual') {
        document.getElementById('modoManual').classList.remove('hidden');
        document.getElementById('modoCamera').classList.add('hidden');
        document.getElementById('btnModoManual').classList.add('bg-green-600', 'text-white');
        document.getElementById('btnModoManual').classList.remove('bg-gray-300', 'text-gray-700');
        document.getElementById('btnModoCamera').classList.add('bg-gray-300', 'text-gray-700');
        document.getElementById('btnModoCamera').classList.remove('bg-green-600', 'text-white');
        
        // Focar no campo de entrada
        setTimeout(() => document.getElementById('codigoBusca').focus(), 100);
    } else {
        document.getElementById('modoManual').classList.add('hidden');
        document.getElementById('modoCamera').classList.remove('hidden');
        document.getElementById('btnModoCamera').classList.add('bg-green-600', 'text-white');
        document.getElementById('btnModoCamera').classList.remove('bg-gray-300', 'text-gray-700');
        document.getElementById('btnModoManual').classList.add('bg-gray-300', 'text-gray-700');
        document.getElementById('btnModoManual').classList.remove('bg-green-600', 'text-white');
    }
}

function iniciarScanner() {
    if (typeof QrScanner === 'undefined') {
        mostrarStatus('❌ Biblioteca QR Scanner não carregada', 'error');
        return;
    }

    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        mostrarStatus('❌ Câmera não suportada neste dispositivo', 'error');
        return;
    }

    try {
        qrScanner = new QrScanner(
            videoElement,
            (result) => {
                mostrarStatus('✅ QR Code detectado!', 'success');
                document.getElementById('qr-resultado').classList.remove('hidden');
                
                // Processar o resultado automaticamente
                processarQRDetectado(result.data);
                
                // Ocultar resultado após 2 segundos
                setTimeout(() => {
                    document.getElementById('qr-resultado').classList.add('hidden');
                }, 2000);
            },
            {
                returnDetailedScanResult: true,
                highlightScanRegion: true,
                highlightCodeOutline: true,
            }
        );

        qrScanner.start().then(() => {
            document.getElementById('btnIniciarCamera').classList.add('hidden');
            document.getElementById('btnPararCamera').classList.remove('hidden');
            document.getElementById('qr-overlay').classList.remove('hidden');
            mostrarStatus('📷 Câmera ativa - Aponte para o QR Code', 'info');
        }).catch(error => {
            console.error('Erro ao iniciar scanner:', error);
            mostrarStatus('❌ Erro ao acessar a câmera', 'error');
        });

    } catch (error) {
        console.error('Erro ao criar scanner:', error);
        mostrarStatus('❌ Erro ao inicializar scanner', 'error');
    }
}

function pararScanner() {
    if (qrScanner) {
        qrScanner.stop();
        qrScanner.destroy();
        qrScanner = null;
    }
    
    document.getElementById('btnIniciarCamera').classList.remove('hidden');
    document.getElementById('btnPararCamera').classList.add('hidden');
    document.getElementById('qr-overlay').classList.add('hidden');
    document.getElementById('qr-resultado').classList.add('hidden');
}

function processarQRDetectado(codigo) {
    // Verificar se já foi escaneado para evitar duplicatas
    if (empacotamentosEscaneados.find(emp => emp.codigo === codigo)) {
        mostrarStatus('⚠️ QR Code já escaneado', 'warning');
        return;
    }
    
    // Processar o código e adicionar à lista
    mostrarStatus('🔍 Processando QR Code...', 'info');
    
    // Buscar empacotamento e adicionar à lista
    buscarEAdicionarEmpacotamento(codigo);
}

function buscarEAdicionarEmpacotamento(codigo) {
    if (!codigo || !codigo.trim()) {
        mostrarStatus('⚠️ Código QR inválido', 'warning');
        return;
    }

    fetch('<?php echo e(route("motorista.buscar-empacotamento")); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ codigo: codigo.trim() })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const empacotamento = data.empacotamento;
            const status = empacotamento.status.nome;

            // Adicionar à lista de escaneados
            empacotamentosEscaneados.push({
                id: empacotamento.id,
                codigo: empacotamento.codigo_qr,
                status: status,
                estabelecimento: empacotamento.coleta?.estabelecimento?.nome_fantasia || 'N/A',
                data: empacotamento.data_empacotamento,
                dados: empacotamento
            });

            contadorEscaneados++;
            atualizarListaEscaneados();
            atualizarContador();
            
            mostrarStatus(`✅ Adicionado: ${empacotamento.codigo_qr}`, 'success');
        } else {
            mostrarStatus(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        mostrarStatus('❌ Erro ao buscar empacotamento', 'error');
    });
}

function atualizarListaEscaneados() {
    const lista = document.getElementById('lista-escaneados');
    
    if (empacotamentosEscaneados.length === 0) {
        lista.innerHTML = '<div class="text-gray-500 text-sm text-center py-4">Nenhum empacotamento escaneado ainda</div>';
        document.getElementById('btnTodosProntos').disabled = true;
        document.getElementById('btnTodosEntrega').disabled = true;
        return;
    }

    let html = '';
    let temProntos = false;
    let temEmTransito = false;

    empacotamentosEscaneados.forEach((emp, index) => {
        const statusColor = emp.status === 'Pronto para Entrega' ? 'bg-blue-100 text-blue-800' : 
                           emp.status === 'Em Trânsito' ? 'bg-purple-100 text-purple-800' : 
                           'bg-gray-100 text-gray-800';
        
        if (emp.status === 'Pronto para Entrega') temProntos = true;
        if (emp.status === 'Em Trânsito') temEmTransito = true;

        html += `
            <div class="flex items-center justify-between p-2 bg-white rounded border text-xs">
                <div class="flex-1">
                    <div class="font-semibold">${emp.codigo}</div>
                    <div class="text-gray-600">${emp.estabelecimento}</div>
                    <span class="inline-block px-2 py-1 rounded text-xs ${statusColor}">${emp.status}</span>
                </div>
                <button onclick="removerEscaneado(${index})" class="text-red-600 hover:text-red-800 ml-2">
                    🗑️
                </button>
            </div>
        `;
    });

    lista.innerHTML = html;
    
    // Habilitar botões conforme necessário
    document.getElementById('btnTodosProntos').disabled = !temProntos;
    document.getElementById('btnTodosEntrega').disabled = !temEmTransito;
}

function atualizarContador() {
    document.getElementById('contador-numero').textContent = contadorEscaneados;
}

function removerEscaneado(index) {
    empacotamentosEscaneados.splice(index, 1);
    contadorEscaneados--;
    atualizarListaEscaneados();
    atualizarContador();
}

function limparLista() {
    empacotamentosEscaneados = [];
    contadorEscaneados = 0;
    atualizarListaEscaneados();
    atualizarContador();
    mostrarStatus('🗑️ Lista limpa', 'info');
}

function processarTodosProntos() {
    const prontos = empacotamentosEscaneados.filter(emp => emp.status === 'Pronto para Entrega');
    
    if (prontos.length === 0) {
        mostrarStatus('⚠️ Nenhum empacotamento pronto para entrega', 'warning');
        return;
    }

    if (!confirm(`Confirmar saída de ${prontos.length} empacotamento(s) para entrega?`)) {
        return;
    }

    const promises = prontos.map(emp => 
        fetch('<?php echo e(route("motorista.confirmar-saida")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ empacotamento_id: emp.id })
        }).then(response => response.json())
    );

    Promise.all(promises)
        .then(results => {
            const sucessos = results.filter(r => r.success).length;
            const erros = results.length - sucessos;
            
            if (erros === 0) {
                mostrarStatus(`✅ ${sucessos} saída(s) confirmada(s) com sucesso!`, 'success');
                // Remover os processados da lista
                empacotamentosEscaneados = empacotamentosEscaneados.filter(emp => emp.status !== 'Pronto para Entrega');
                contadorEscaneados = empacotamentosEscaneados.length;
                atualizarListaEscaneados();
                atualizarContador();
                location.reload(); // Atualizar dados
            } else {
                mostrarStatus(`⚠️ ${sucessos} sucessos, ${erros} erro(s)`, 'warning');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            mostrarStatus('❌ Erro ao processar saídas', 'error');
        });
}

function processarTodosEntrega() {
    const emTransito = empacotamentosEscaneados.filter(emp => emp.status === 'Em Trânsito');
    
    if (emTransito.length === 0) {
        mostrarStatus('⚠️ Nenhum empacotamento em trânsito', 'warning');
        return;
    }

    // Para entregas, não podemos fazer em lote pois precisam de assinatura
    // Vamos processar um por vez
    mostrarStatus(`📋 ${emTransito.length} empacotamento(s) em trânsito - será necessário assinatura para cada um`, 'info');
    
    // Abrir modal para o primeiro
    const primeiro = emTransito[0];
    abrirModalEntrega(primeiro.id, primeiro.codigo);
}

// Nova função para ação rápida com QR Code
function buscarParaAcao() {
    const codigo = document.getElementById('codigoBusca').value.trim();
    const btnProcessar = document.getElementById('btnProcessar');
    const statusBusca = document.getElementById('statusBusca');

    if (!codigo) {
        mostrarStatus('⚠️ Digite ou escaneie um código QR', 'warning');
        return;
    }

    // Mostrar loading
    btnProcessar.disabled = true;
    btnProcessar.innerHTML = '⏳ Processando...';
    mostrarStatus('🔍 Buscando empacotamento...', 'info');

    fetch('<?php echo e(route("motorista.buscar-empacotamento")); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ codigo: codigo })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const empacotamento = data.empacotamento;
            const status = empacotamento.status.nome;

            // Limpar campo após busca
            document.getElementById('codigoBusca').value = '';
            mostrarStatus(`✅ Encontrado: ${empacotamento.codigo_qr}`, 'success');

            if (status === 'Pronto para Entrega') {
                // Abrir modal de confirmação de saída
                abrirModalSaida(empacotamento);
            } else if (status === 'Em Trânsito') {
                // Abrir modal de confirmação de entrega
                abrirModalEntrega(empacotamento.id, empacotamento.codigo_qr);
            } else {
                mostrarStatus(`⚠️ Status: ${status} - Não disponível para ação`, 'warning');
            }
        } else {
            mostrarStatus(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        mostrarStatus('❌ Erro ao buscar empacotamento', 'error');
    })
    .finally(() => {
        // Restaurar botão
        btnProcessar.disabled = false;
        btnProcessar.innerHTML = '📱 Processar';
        // Focar novamente no campo
        setTimeout(() => document.getElementById('codigoBusca').focus(), 100);
    });
}

// Função para mostrar status visual
function mostrarStatus(mensagem, tipo) {
    const statusDiv = document.getElementById('statusBusca');
    statusDiv.className = 'mt-2 text-sm p-2 rounded-lg';

    switch(tipo) {
        case 'success':
            statusDiv.className += ' bg-green-100 text-green-800 border border-green-200';
            break;
        case 'error':
            statusDiv.className += ' bg-red-100 text-red-800 border border-red-200';
            break;
        case 'warning':
            statusDiv.className += ' bg-yellow-100 text-yellow-800 border border-yellow-200';
            break;
        case 'info':
            statusDiv.className += ' bg-blue-100 text-blue-800 border border-blue-200';
            break;
    }

    statusDiv.textContent = mensagem;
    statusDiv.classList.remove('hidden');

    // Auto-hide após 3 segundos para success e info
    if (tipo === 'success' || tipo === 'info') {
        setTimeout(() => {
            statusDiv.classList.add('hidden');
        }, 3000);
    }
}

// Função para busca simples (mantida para compatibilidade)
function buscarEmpacotamento() {
    buscarParaAcao();
}

function confirmarSaida(empacotamentoId) {
    if (!confirm('Confirmar saída para entrega?')) return;
    
    fetch('<?php echo e(route("motorista.confirmar-saida")); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ empacotamento_id: empacotamentoId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert('Erro ao confirmar saída');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao confirmar saída');
    });
}

function abrirModalEntrega(empacotamentoId, codigo) {
    document.getElementById('empacotamentoId').value = empacotamentoId;
    document.getElementById('codigoEntrega').textContent = codigo;
    document.getElementById('nomeRecebedor').value = '';
    limparAssinatura();
    document.getElementById('modalEntrega').classList.remove('hidden');
}

function fecharModalEntrega() {
    document.getElementById('modalEntrega').classList.add('hidden');
    // Voltar foco para o campo de busca
    setTimeout(() => document.getElementById('codigoBusca').focus(), 100);
}

// Funções para modal de saída rápida
let empacotamentoParaSaida = null;

function abrirModalSaida(empacotamento) {
    empacotamentoParaSaida = empacotamento;
    document.getElementById('codigoSaida').textContent = empacotamento.codigo_qr;

    // Mostrar informações do estabelecimento
    if (empacotamento.coleta && empacotamento.coleta.estabelecimento) {
        const estabelecimento = empacotamento.coleta.estabelecimento;
        document.getElementById('estabelecimentoSaida').textContent =
            `📍 ${estabelecimento.nome_fantasia || estabelecimento.razao_social}`;
    } else {
        document.getElementById('estabelecimentoSaida').textContent = '📍 Estabelecimento não encontrado';
    }

    // Mostrar data de empacotamento
    const dataEmpacotamento = new Date(empacotamento.data_empacotamento).toLocaleString('pt-BR');
    document.getElementById('dataSaida').textContent = `📦 Empacotado em: ${dataEmpacotamento}`;

    document.getElementById('modalSaida').classList.remove('hidden');
}

function fecharModalSaida() {
    document.getElementById('modalSaida').classList.add('hidden');
    empacotamentoParaSaida = null;
    // Voltar foco para o campo de busca
    setTimeout(() => document.getElementById('codigoBusca').focus(), 100);
}

function confirmarSaidaRapida() {
    if (!empacotamentoParaSaida) return;

    fetch('<?php echo e(route("motorista.confirmar-saida")); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ empacotamento_id: empacotamentoParaSaida.id })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ ' + data.message);
            fecharModalSaida();
            location.reload();
        } else {
            alert('❌ Erro ao confirmar saída');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('❌ Erro ao confirmar saída');
    });
}

// Funções de assinatura
function startDrawing(e) {
    isDrawing = true;
    const rect = canvas.getBoundingClientRect();
    ctx.beginPath();
    ctx.moveTo(e.clientX - rect.left, e.clientY - rect.top);
}

function draw(e) {
    if (!isDrawing) return;
    const rect = canvas.getBoundingClientRect();
    ctx.lineTo(e.clientX - rect.left, e.clientY - rect.top);
    ctx.stroke();
}

function stopDrawing() {
    isDrawing = false;
}

function handleTouch(e) {
    e.preventDefault();
    const touch = e.touches[0];
    const mouseEvent = new MouseEvent(e.type === 'touchstart' ? 'mousedown' : 
                                     e.type === 'touchmove' ? 'mousemove' : 'mouseup', {
        clientX: touch.clientX,
        clientY: touch.clientY
    });
    canvas.dispatchEvent(mouseEvent);
}

function limparAssinatura() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
}

// Submit do formulário de entrega
document.getElementById('formEntrega').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const nomeRecebedor = document.getElementById('nomeRecebedor').value.trim();
    if (!nomeRecebedor) {
        alert('Digite o nome de quem recebeu');
        return;
    }
    
    // Verificar se há assinatura
    const imageData = canvas.toDataURL();
    const isCanvasBlank = !ctx.getImageData(0, 0, canvas.width, canvas.height).data.some(channel => channel !== 0);
    
    if (isCanvasBlank) {
        alert('Por favor, faça a assinatura');
        return;
    }
    
    const empacotamentoId = document.getElementById('empacotamentoId').value;
    
    fetch('<?php echo e(route("motorista.confirmar-entrega")); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            empacotamento_id: empacotamentoId,
            nome_recebedor: nomeRecebedor,
            assinatura_recebedor: imageData
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            fecharModalEntrega();
            location.reload();
        } else {
            alert('Erro ao confirmar entrega');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao confirmar entrega');
    });
});

// Funções para modal de assinatura
function verAssinaturaCompleta(assinatura, nome, codigo) {
    document.getElementById('assinatura-imagem').src = assinatura;
    document.getElementById('assinatura-nome').textContent = nome;
    document.getElementById('assinatura-codigo').textContent = codigo;
    document.getElementById('modalAssinatura').classList.remove('hidden');
}

function fecharModalAssinatura() {
    document.getElementById('modalAssinatura').classList.add('hidden');
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make(auth()->user()->nivelAcesso && auth()->user()->nivelAcesso->nome === 'Motorista' ? 'layouts.motorista' : 'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\lavanderia\resources\views/motorista/dashboard.blade.php ENDPATH**/ ?>