

<?php $__env->startSection('title', 'Dashboard do Motorista'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard do Motorista</h1>
        <p class="text-gray-600 mt-2">Gerencie suas entregas e confirme recebimentos</p>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Prontos</p>
                    <p class="text-2xl font-bold text-gray-900"><?php echo e($prontos); ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Em Trânsito</p>
                    <p class="text-2xl font-bold text-gray-900"><?php echo e($emTransito); ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Hoje</p>
                    <p class="text-2xl font-bold text-gray-900"><?php echo e($entreguesHoje); ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-gray-100">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total</p>
                    <p class="text-2xl font-bold text-gray-900"><?php echo e($total); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Buscar Empacotamento -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Buscar Empacotamento</h2>
        <p class="text-gray-600 mb-4">Digite ou escaneie o código QR do empacotamento</p>
        <div class="flex gap-4">
            <input type="text" id="codigoBusca" placeholder="Código do empacotamento" 
                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <button onclick="buscarEmpacotamento()" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                Buscar
            </button>
        </div>
    </div>

    <!-- Tabs -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 px-6">
                <button onclick="showTab('prontos')" id="tab-prontos" 
                        class="tab-button py-4 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600">
                    Prontos para Entrega (<?php echo e($prontos); ?>)
                </button>
                <button onclick="showTab('transito')" id="tab-transito" 
                        class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Em Trânsito (<?php echo e($emTransito); ?>)
                </button>
                <button onclick="showTab('entregues')" id="tab-entregues" 
                        class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Entregues Hoje (<?php echo e($entreguesHoje); ?>)
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
            <!-- Prontos para Entrega -->
            <div id="content-prontos" class="tab-content">
                <?php $__empty_1 = true; $__currentLoopData = $empacotamentosProntos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empacotamento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="border border-gray-200 rounded-lg p-4 mb-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-lg"><?php echo e($empacotamento->codigo_qr); ?></h3>
                                <p class="text-blue-600 font-medium"><?php echo e($empacotamento->status->nome); ?></p>
                                <?php if($empacotamento->coleta && $empacotamento->coleta->estabelecimento): ?>
                                    <p class="text-gray-900 font-medium"><?php echo e($empacotamento->coleta->estabelecimento->nome_fantasia ?? $empacotamento->coleta->estabelecimento->razao_social); ?></p>
                                <?php else: ?>
                                    <p class="text-red-600 font-medium">Estabelecimento não encontrado</p>
                                <?php endif; ?>
                                <p class="text-gray-600 text-sm">Empacotado: <?php echo e($empacotamento->data_empacotamento->format('d/m/Y H:i')); ?></p>
                            </div>
                            <button onclick="confirmarSaida(<?php echo e($empacotamento->id); ?>)" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Confirmar Saída
                            </button>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-500 text-center py-8">Nenhum empacotamento pronto para entrega</p>
                <?php endif; ?>
            </div>

            <!-- Em Trânsito -->
            <div id="content-transito" class="tab-content hidden">
                <?php $__empty_1 = true; $__currentLoopData = $empacotamentosTransito; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empacotamento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="border border-gray-200 rounded-lg p-4 mb-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-lg"><?php echo e($empacotamento->codigo_qr); ?></h3>
                                <p class="text-yellow-600 font-medium"><?php echo e($empacotamento->status->nome); ?></p>
                                <?php if($empacotamento->coleta && $empacotamento->coleta->estabelecimento): ?>
                                    <p class="text-gray-900 font-medium"><?php echo e($empacotamento->coleta->estabelecimento->nome_fantasia ?? $empacotamento->coleta->estabelecimento->razao_social); ?></p>
                                <?php else: ?>
                                    <p class="text-red-600 font-medium">Estabelecimento não encontrado</p>
                                <?php endif; ?>
                                <?php if($empacotamento->entrega && $empacotamento->entrega->data_saida): ?>
                                    <p class="text-gray-600 text-sm">Saída: <?php echo e($empacotamento->entrega->data_saida->format('d/m/Y H:i')); ?></p>
                                <?php endif; ?>
                            </div>
                            <button onclick="abrirModalEntrega(<?php echo e($empacotamento->id); ?>, '<?php echo e($empacotamento->codigo_qr); ?>')" 
                                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                Confirmar Entrega
                            </button>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-500 text-center py-8">Nenhum empacotamento em trânsito</p>
                <?php endif; ?>
            </div>

            <!-- Entregues Hoje -->
            <div id="content-entregues" class="tab-content hidden">
                <?php $__empty_1 = true; $__currentLoopData = $empacotamentosEntregues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empacotamento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="border border-gray-200 rounded-lg p-4 mb-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-lg"><?php echo e($empacotamento->codigo_qr); ?></h3>
                                <p class="text-green-600 font-medium"><?php echo e($empacotamento->status->nome); ?></p>
                                <?php if($empacotamento->coleta && $empacotamento->coleta->estabelecimento): ?>
                                    <p class="text-gray-900 font-medium"><?php echo e($empacotamento->coleta->estabelecimento->nome_fantasia ?? $empacotamento->coleta->estabelecimento->razao_social); ?></p>
                                <?php else: ?>
                                    <p class="text-red-600 font-medium">Estabelecimento não encontrado</p>
                                <?php endif; ?>
                                <?php if($empacotamento->entrega): ?>
                                    <p class="text-gray-600 text-sm">Entregue: <?php echo e($empacotamento->entrega->data_entrega->format('d/m/Y H:i')); ?></p>
                                    <?php if($empacotamento->entrega->nome_recebedor): ?>
                                        <p class="text-gray-600 text-sm">Recebido por: <?php echo e($empacotamento->entrega->nome_recebedor); ?></p>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                Entregue
                            </span>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-500 text-center py-8">Nenhuma entrega realizada hoje</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Entrega -->
<div id="modalEntrega" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Confirmar Entrega</h3>
                <p class="text-gray-600 mb-4">Empacotamento: <span id="codigoEntrega" class="font-mono font-bold"></span></p>
                
                <form id="formEntrega">
                    <input type="hidden" id="empacotamentoId" name="empacotamento_id">
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nome de quem recebeu</label>
                        <input type="text" id="nomeRecebedor" name="nome_recebedor" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Digite o nome completo">
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Assinatura</label>
                        <div class="border border-gray-300 rounded-lg">
                            <canvas id="canvasAssinatura" width="400" height="150" class="w-full cursor-crosshair"></canvas>
                        </div>
                        <div class="flex justify-between mt-2">
                            <button type="button" onclick="limparAssinatura()" 
                                    class="text-sm text-gray-600 hover:text-gray-800">
                                Limpar Assinatura
                            </button>
                            <span class="text-xs text-gray-500">Desenhe sua assinatura acima</span>
                        </div>
                    </div>
                    
                    <div class="flex gap-3">
                        <button type="button" onclick="fecharModalEntrega()" 
                                class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            Confirmar Entrega
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Variáveis globais para assinatura
let canvas, ctx, isDrawing = false;

document.addEventListener('DOMContentLoaded', function() {
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

function showTab(tabName) {
    // Esconder todos os conteúdos
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remover classe ativa de todos os botões
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('border-blue-500', 'text-blue-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Mostrar conteúdo ativo
    document.getElementById('content-' + tabName).classList.remove('hidden');
    
    // Ativar botão
    const activeButton = document.getElementById('tab-' + tabName);
    activeButton.classList.remove('border-transparent', 'text-gray-500');
    activeButton.classList.add('border-blue-500', 'text-blue-600');
}

function buscarEmpacotamento() {
    const codigo = document.getElementById('codigoBusca').value.trim();
    if (!codigo) {
        alert('Digite um código para buscar');
        return;
    }
    
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
            alert('Empacotamento encontrado: ' + data.empacotamento.codigo_qr);
            // Aqui você pode adicionar lógica para mostrar detalhes
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao buscar empacotamento');
    });
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
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\lavanderia\resources\views/motorista/dashboard.blade.php ENDPATH**/ ?>