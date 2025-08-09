<?php $__env->startSection('title', 'Acompanhe sua Coleta'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50/30 to-purple-50/30">
    <!-- Hero Section - Compact Design -->
    <div class="gradient-bg text-white py-12 relative overflow-hidden">
        <div class="hero-pattern absolute inset-0 opacity-20"></div>
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div class="mb-6">
                <div class="inline-flex items-center justify-center w-14 h-14 bg-white bg-opacity-20 rounded-xl mb-4">
                    <span class="text-2xl">🧺</span>
                </div>
            </div>
            <h1 class="text-2xl md:text-3xl font-bold mb-4 tracking-tight">
                Acompanhe sua <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-pink-300">Coleta</span>
            </h1>
            <p class="text-sm text-blue-100 max-w-xl mx-auto leading-relaxed mb-6">
                Rastreamento em tempo real. Digite seu CNPJ ou número da coleta.
            </p>
            <div class="flex flex-wrap justify-center gap-2 text-xs">
                <div class="flex items-center space-x-1 bg-white bg-opacity-20 rounded-full px-3 py-1">
                    <div class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></div>
                    <span>Tempo Real</span>
                </div>
                <div class="flex items-center space-x-1 bg-white bg-opacity-20 rounded-full px-3 py-1">
                    <div class="w-1.5 h-1.5 bg-yellow-400 rounded-full animate-pulse"></div>
                    <span>Transparente</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Section - Compact Design -->
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-10">
        <div class="glass-effect rounded-2xl shadow-xl p-6 border">
            <form method="POST" action="<?php echo e(route('acompanhamento.buscar')); ?>" class="space-y-4">
                <?php echo csrf_field(); ?>
                
                <div class="text-center mb-6">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-500 rounded-xl mb-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold text-gray-900 mb-2">Consultar Coleta</h2>
                    <p class="text-sm text-gray-600">Digite seu CNPJ ou número da coleta</p>
                </div>

                <!-- Mensagens de erro -->
                <?php if(session('error')): ?>
                    <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">
                        <?php echo e(session('error')); ?>

                    </div>
                <?php endif; ?>

                <?php if(session('success')): ?>
                    <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <div class="space-y-2">
                    <label for="busca" class="block text-sm font-medium text-gray-700 mb-2">
                        CNPJ ou Número da Coleta
                    </label>
                    <div class="relative group">
                        <input type="text" 
                               id="busca" 
                               name="busca" 
                               value="<?php echo e(old('busca')); ?>"
                               class="w-full px-4 py-3 text-base border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300 bg-gray-50 hover:bg-white group-hover:border-gray-300 <?php $__errorArgs = ['busca'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="Ex: 12.345.678/0001-90 ou COL-2024-001"
                               required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <?php $__errorArgs = ['busca'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="flex items-center space-x-2 mt-2 text-red-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-sm font-medium"><?php echo e($message); ?></p>
                        </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <button type="submit" 
                        class="w-full bg-gradient-to-r from-blue-600 via-purple-600 to-cyan-600 hover:from-blue-700 hover:via-purple-700 hover:to-cyan-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl">
                    <span class="flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span>Buscar Coleta</span>
                    </span>
                </button>
            </form>
            
            <!-- Quick Tips -->
            <div class="mt-4 pt-4 border-t border-gray-200">
                <div class="flex flex-wrap justify-center gap-3 text-xs">
                    <div class="flex items-center space-x-1 text-gray-600">
                        <div class="w-1.5 h-1.5 bg-green-400 rounded-full"></div>
                        <span>Instantâneo</span>
                    </div>
                    <div class="flex items-center space-x-1 text-gray-600">
                        <div class="w-1.5 h-1.5 bg-blue-400 rounded-full"></div>
                        <span>Tempo Real</span>
                    </div>
                    <div class="flex items-center space-x-1 text-gray-600">
                        <div class="w-1.5 h-1.5 bg-purple-400 rounded-full"></div>
                        <span>Completo</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Como Funciona - Compact Cards -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center mb-8">
            <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-3">
                Como <span class="text-gradient">Funciona</span>
            </h2>
            <p class="text-sm text-gray-600 max-w-xl mx-auto">
                Processo transparente do início ao fim
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="group relative">
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 p-6 border border-gray-100">
                    <div class="absolute -top-3 left-6">
                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center shadow-md">
                            <span class="text-lg">📋</span>
                        </div>
                    </div>
                    <div class="mt-6">
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="w-5 h-5 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs font-bold">1</span>
                            <h3 class="text-base font-bold text-gray-900">Coleta Agendada</h3>
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed">
                            Agendamento e preparo da sua coleta
                        </p>
                    </div>
                </div>
            </div>

            <div class="group relative">
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 p-6 border border-gray-100">
                    <div class="absolute -top-3 left-6">
                        <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-md">
                            <span class="text-lg">🚚</span>
                        </div>
                    </div>
                    <div class="mt-6">
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="w-5 h-5 bg-purple-500 text-white rounded-full flex items-center justify-center text-xs font-bold">2</span>
                            <h3 class="text-base font-bold text-gray-900">Processamento</h3>
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed">
                            Coleta, pesagem e empacotamento
                        </p>
                    </div>
                </div>
            </div>

            <div class="group relative">
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 p-6 border border-gray-100">
                    <div class="absolute -top-3 left-6">
                        <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-500 rounded-xl flex items-center justify-center shadow-md">
                            <span class="text-lg">✅</span>
                        </div>
                    </div>
                    <div class="mt-6">
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="w-5 h-5 bg-green-500 text-white rounded-full flex items-center justify-center text-xs font-bold">3</span>
                            <h3 class="text-base font-bold text-gray-900">Entrega</h3>
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed">
                            Peças limpas e entrega programada
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Timeline - Compact Design -->
    <div class="bg-gradient-to-br from-gray-50 to-blue-50/30 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-3">
                    Status de <span class="text-gradient">Acompanhamento</span>
                </h2>
                <p class="text-sm text-gray-600 max-w-xl mx-auto">
                    Veja em tempo real cada etapa do processo
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div class="flex items-center space-x-3 p-3 bg-blue-50 rounded-lg border border-blue-100">
                        <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center text-white text-sm font-bold">1</div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-900">Agendada</h4>
                            <p class="text-xs text-gray-600">Programada</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 p-3 bg-purple-50 rounded-lg border border-purple-100">
                        <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center text-white text-sm font-bold">2</div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-900">Coletando</h4>
                            <p class="text-xs text-gray-600">Em andamento</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 p-3 bg-green-50 rounded-lg border border-green-100">
                        <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center text-white text-sm font-bold">3</div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-900">Processando</h4>
                            <p class="text-xs text-gray-600">Pesagem</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 p-3 bg-yellow-50 rounded-lg border border-yellow-100">
                        <div class="w-8 h-8 bg-yellow-500 rounded-lg flex items-center justify-center text-white text-sm font-bold">4</div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-900">Em Trânsito</h4>
                            <p class="text-xs text-gray-600">Saindo</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 p-3 bg-emerald-50 rounded-lg border border-emerald-100">
                        <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center text-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-900">Entregue</h4>
                            <p class="text-xs text-gray-600">Finalizado</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // Auto format CNPJ
    document.getElementById('busca').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        
        // Se tem 11 dígitos ou mais, pode ser CNPJ
        if (value.length >= 11) {
            // Formatar como CNPJ: XX.XXX.XXX/XXXX-XX
            if (value.length <= 14) {
                value = value.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{0,2}).*/, function(match, p1, p2, p3, p4, p5) {
                    let formatted = p1 + '.' + p2 + '.' + p3 + '/' + p4;
                    if (p5) formatted += '-' + p5;
                    return formatted;
                });
                e.target.value = value;
            }
        }
    });

    // Permitir apenas números, letras, pontos, barras e hífens
    document.getElementById('busca').addEventListener('keypress', function(e) {
        const allowedChars = /[0-9A-Za-z.\-\/]/;
        if (!allowedChars.test(e.key) && e.key !== 'Backspace' && e.key !== 'Delete') {
            e.preventDefault();
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.public', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\lavanderia\resources\views/publico/acompanhamento/index.blade.php ENDPATH**/ ?>