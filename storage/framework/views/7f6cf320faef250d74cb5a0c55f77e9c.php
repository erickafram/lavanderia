

<?php $__env->startSection('title', 'Coletas - Sistema de Gestão de Lavanderia'); ?>

<?php $__env->startSection('content'); ?>
<!-- Indicador de Atualização Automática -->
<div id="auto-update-status" class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4 flex items-center justify-between text-sm">
    <div class="flex items-center">
        <div class="w-2 h-2 bg-blue-500 rounded-full mr-3 animate-pulse"></div>
        <span class="text-blue-800">
            <strong>Atualização automática ativa:</strong> Dados atualizados a cada 30 segundos
        </span>
    </div>
    <div class="text-blue-600 text-xs">
        Última atualização: <span id="last-update-time"><?php echo e(now()->format('H:i:s')); ?></span>
    </div>
</div>

<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
    <div>
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">
            <svg class="inline w-5 h-5 sm:w-6 sm:h-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h8m-8 0H6a2 2 0 00-2 2v10a2 2 0 002 2h1m5 0h8a2 2 0 002-2V9a2 2 0 00-2-2h-1"></path>
            </svg>
            Coletas
        </h1>
        <p class="text-sm text-gray-600">Gerencie as coletas de roupas dos estabelecimentos</p>
    </div>
    <div class="flex gap-2 mt-3 sm:mt-0">
        <a href="<?php echo e(route('coletas.create')); ?>"
           class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Nova Coleta
        </a>
    </div>
</div>

<!-- Filtros -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <form method="GET" action="<?php echo e(route('coletas.index')); ?>" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Busca -->
            <div>
                <label for="busca" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                <input type="text" 
                       id="busca" 
                       name="busca" 
                       value="<?php echo e(request('busca')); ?>"
                       placeholder="Número da coleta ou estabelecimento"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
            </div>

            <!-- Estabelecimento -->
            <div>
                <label for="estabelecimento_id" class="block text-sm font-medium text-gray-700 mb-1">Estabelecimento</label>
                <select id="estabelecimento_id" 
                        name="estabelecimento_id" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                    <option value="">Todos</option>
                    <?php $__currentLoopData = $estabelecimentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estabelecimento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($estabelecimento->id); ?>" <?php echo e(request('estabelecimento_id') == $estabelecimento->id ? 'selected' : ''); ?>>
                            <?php echo e($estabelecimento->razao_social); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <!-- Status -->
            <div>
                <label for="status_id" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="status_id" 
                        name="status_id" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                    <option value="">Todos</option>
                    <?php $__currentLoopData = $status; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($st->id); ?>" <?php echo e(request('status_id') == $st->id ? 'selected' : ''); ?>>
                            <?php echo e($st->nome); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <!-- Data Início -->
            <div>
                <label for="data_inicio" class="block text-sm font-medium text-gray-700 mb-1">Data Início</label>
                <input type="date" 
                       id="data_inicio" 
                       name="data_inicio" 
                       value="<?php echo e(request('data_inicio')); ?>"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-2">
            <button type="submit" 
                    class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Filtrar
            </button>
            <a href="<?php echo e(route('coletas.index')); ?>" 
               class="inline-flex items-center px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Limpar
            </a>
        </div>
    </form>
</div>

<!-- Tabela Desktop -->
<div class="hidden md:block bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Coleta</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estabelecimento</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data Agendamento</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peso/Valor</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $coletas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coleta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900"><?php echo e($coleta->numero_coleta); ?></div>
                            <div class="text-sm text-gray-500"><?php echo e($coleta->created_at->format('d/m/Y H:i')); ?></div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900"><?php echo e($coleta->estabelecimento->razao_social); ?></div>
                            <?php if($coleta->estabelecimento->nome_fantasia): ?>
                            <div class="text-sm text-gray-500"><?php echo e($coleta->estabelecimento->nome_fantasia); ?></div>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <?php echo e(\Carbon\Carbon::parse($coleta->data_agendamento)->format('d/m/Y H:i')); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php
                                $statusColors = [
                                    'Agendada' => 'bg-blue-100 text-blue-800',
                                    'Em andamento' => 'bg-yellow-100 text-yellow-800',
                                    'Concluída' => 'bg-green-100 text-green-800',
                                    'Cancelada' => 'bg-red-100 text-red-800',
                                ];
                                $colorClass = $statusColors[$coleta->status->nome] ?? 'bg-gray-100 text-gray-800';
                            ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($colorClass); ?>">
                                <?php echo e($coleta->status->nome); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div><?php echo e(number_format($coleta->peso_total, 2, ',', '.')); ?> kg</div>
                            <div class="text-green-600 font-medium">R$ <?php echo e(number_format($coleta->valor_total, 2, ',', '.')); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="<?php echo e(route('coletas.show', $coleta->id)); ?>" 
                                   class="text-blue-600 hover:text-blue-900 transition-colors duration-200"
                                   title="Ver Detalhes">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h8m-8 0H6a2 2 0 00-2 2v10a2 2 0 002 2h1m5 0h8a2 2 0 002-2V9a2 2 0 00-2-2h-1"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhuma coleta encontrada</h3>
                            <p class="mt-1 text-sm text-gray-500">Comece agendando uma nova coleta.</p>
                            <div class="mt-6">
                                <a href="<?php echo e(route('coletas.create')); ?>" 
                                   class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Nova Coleta
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Cards Mobile -->
<div class="md:hidden space-y-4">
    <?php $__empty_1 = true; $__currentLoopData = $coletas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coleta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <h3 class="text-sm font-semibold text-gray-900"><?php echo e($coleta->numero_coleta); ?></h3>
                    <p class="text-xs text-gray-500"><?php echo e($coleta->created_at->format('d/m/Y H:i')); ?></p>
                </div>
                <?php
                    $statusColors = [
                        'Agendada' => 'bg-blue-100 text-blue-800',
                        'Em andamento' => 'bg-yellow-100 text-yellow-800',
                        'Concluída' => 'bg-green-100 text-green-800',
                        'Cancelada' => 'bg-red-100 text-red-800',
                    ];
                    $colorClass = $statusColors[$coleta->status->nome] ?? 'bg-gray-100 text-gray-800';
                ?>
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium <?php echo e($colorClass); ?>">
                    <?php echo e($coleta->status->nome); ?>

                </span>
            </div>
            
            <div class="space-y-2 mb-4">
                <div>
                    <p class="text-sm font-medium text-gray-900"><?php echo e($coleta->estabelecimento->razao_social); ?></p>
                    <?php if($coleta->estabelecimento->nome_fantasia): ?>
                    <p class="text-xs text-gray-500"><?php echo e($coleta->estabelecimento->nome_fantasia); ?></p>
                    <?php endif; ?>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Agendamento:</span>
                    <span class="text-gray-900"><?php echo e(\Carbon\Carbon::parse($coleta->data_agendamento)->format('d/m/Y H:i')); ?></span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Peso/Valor:</span>
                    <span class="text-gray-900"><?php echo e(number_format($coleta->peso_total, 2, ',', '.')); ?> kg - <span class="text-green-600 font-medium">R$ <?php echo e(number_format($coleta->valor_total, 2, ',', '.')); ?></span></span>
                </div>
            </div>
            
            <div class="flex justify-end">
                <a href="<?php echo e(route('coletas.show', $coleta->id)); ?>" 
                   class="text-blue-600 hover:text-blue-900 transition-colors duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </a>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h8m-8 0H6a2 2 0 00-2 2v10a2 2 0 002 2h1m5 0h8a2 2 0 002-2V9a2 2 0 00-2-2h-1"></path>
            </svg>
            <h3 class="text-sm font-medium text-gray-900 mb-2">Nenhuma coleta encontrada</h3>
            <p class="text-sm text-gray-500 mb-4">Comece agendando uma nova coleta.</p>
            <a href="<?php echo e(route('coletas.create')); ?>" 
               class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Nova Coleta
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- Paginação -->
<?php if($coletas->hasPages()): ?>
<div class="mt-6">
    <?php echo e($coletas->appends(request()->query())->links()); ?>

</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
let updateInterval;
let isUpdating = false;

// Função para atualizar os dados das coletas
function atualizarColetas() {
    if (isUpdating) return;
    
    isUpdating = true;
    
    // Mostrar indicador de atualização
    mostrarIndicadorAtualizacao();
    
    // Capturar filtros ativos
    const filtros = new URLSearchParams();
    const formData = new FormData(document.querySelector('form'));
    
    for (let [key, value] of formData.entries()) {
        if (value) {
            filtros.append(key, value);
        }
    }
    
    // Fazer requisição AJAX
    fetch(`<?php echo e(route('coletas.dados-atualizados')); ?>?${filtros.toString()}`)
        .then(response => response.json())
        .then(data => {
            // Atualizar apenas se houver mudanças
            atualizarInterfaceColetas(data);
            ocultarIndicadorAtualizacao();
        })
        .catch(error => {
            console.error('Erro ao atualizar coletas:', error);
            ocultarIndicadorAtualizacao();
        })
        .finally(() => {
            isUpdating = false;
        });
}

// Função para mostrar indicador de atualização
function mostrarIndicadorAtualizacao() {
    let indicator = document.getElementById('update-indicator');
    if (!indicator) {
        // Criar indicador se não existir
        indicator = document.createElement('div');
        indicator.id = 'update-indicator';
        indicator.className = 'fixed top-4 right-4 z-50 bg-blue-500 text-white px-3 py-2 rounded-lg shadow-lg text-sm';
        indicator.innerHTML = `
            <div class="flex items-center">
                <svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Atualizando...
            </div>
        `;
        document.body.appendChild(indicator);
    }
    indicator.style.display = 'block';
}

// Função para ocultar indicador de atualização
function ocultarIndicadorAtualizacao() {
    const indicator = document.getElementById('update-indicator');
    if (indicator) {
        setTimeout(() => {
            indicator.style.display = 'none';
        }, 500);
    }
}

// Função para atualizar a interface das coletas
function atualizarInterfaceColetas(data) {
    // Atualizar timestamp da última atualização
    const lastUpdateElement = document.getElementById('last-update-time');
    if (lastUpdateElement) {
        const now = new Date();
        lastUpdateElement.textContent = now.toLocaleTimeString('pt-BR');
    }
    
    // Esta é uma implementação simplificada
    // Em uma implementação mais robusta, você compararia os dados e atualizaria apenas o que mudou
    
    // Por enquanto, vamos mostrar um toast de notificação se houver mudanças
    const currentColetasCount = document.querySelectorAll('.bg-white.rounded-xl.shadow-sm.border.border-gray-100.p-6.hover\\:shadow-md').length;
    const newColetasCount = data.coletas.data ? data.coletas.data.length : 0;
    
    if (currentColetasCount !== newColetasCount) {
        mostrarNotificacao('Dados atualizados! Novas alterações detectadas.', 'success');
        // Recarregar a página para mostrar as mudanças
        setTimeout(() => {
            window.location.reload();
        }, 1000);
    }
}

// Função para mostrar notificações
function mostrarNotificacao(mensagem, tipo = 'info') {
    const cores = {
        'success': 'bg-green-500',
        'warning': 'bg-yellow-500',
        'error': 'bg-red-500',
        'info': 'bg-blue-500'
    };
    
    const notificacao = document.createElement('div');
    notificacao.className = `fixed top-16 right-4 z-50 ${cores[tipo]} text-white px-4 py-3 rounded-lg shadow-lg text-sm max-w-sm`;
    notificacao.innerHTML = `
        <div class="flex items-center justify-between">
            <span>${mensagem}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-3 text-white hover:text-gray-200">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
    `;
    
    document.body.appendChild(notificacao);
    
    // Remover automaticamente após 5 segundos
    setTimeout(() => {
        if (notificacao.parentElement) {
            notificacao.remove();
        }
    }, 5000);
}

// Iniciar atualização automática quando a página carregar
document.addEventListener('DOMContentLoaded', function() {
    // Atualizar a cada 30 segundos
    updateInterval = setInterval(atualizarColetas, 30000);
    
    // Parar atualização quando o usuário sair da página
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            clearInterval(updateInterval);
        } else {
            // Reiniciar quando voltar à página
            updateInterval = setInterval(atualizarColetas, 30000);
            // Atualizar imediatamente quando voltar
            atualizarColetas();
        }
    });
    
    // Parar atualização quando houver interação com formulários
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function() {
            clearInterval(updateInterval);
        });
    }
});

// Limpar interval quando sair da página
window.addEventListener('beforeunload', function() {
    clearInterval(updateInterval);
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\lavanderia\resources\views/coletas/index.blade.php ENDPATH**/ ?>