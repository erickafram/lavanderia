<?php $__env->startSection('title', 'Acompanhe sua Coleta'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section - Sobre a 212lavanderia -->
    <div class="bg-gradient-to-br from-blue-50 to-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 tracking-tight text-gray-900">
                    212<span class="text-blue-600">lavanderia</span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-700 max-w-4xl mx-auto leading-relaxed mb-8">
                    Cuidamos das suas roupas com a qualidade e atenção que elas merecem
                </p>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Há anos oferecendo serviços de lavanderia profissional com tecnologia avançada, 
                    processos sustentáveis e acompanhamento em tempo real.
                </p>
            </div>
            
            <!-- Vantagens -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Qualidade Garantida</h3>
                    <p class="text-gray-600">Tratamento especializado para cada tipo de tecido</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Agilidade</h3>
                    <p class="text-gray-600">Prazos rápidos e pontualidade na entrega</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Transparência</h3>
                    <p class="text-gray-600">Acompanhe sua coleta em tempo real</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Seção de Consulta - Design Simples -->
    <div class="bg-white py-16">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Consulte sua Coleta
                </h2>
                <p class="text-lg text-gray-600">
                    Acompanhe o status da sua coleta em tempo real
                </p>
            </div>
            
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                <form method="POST" action="<?php echo e(route('acompanhamento.buscar')); ?>" class="space-y-6">
                    <?php echo csrf_field(); ?>

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

                <div class="space-y-3">
                    <label for="busca" class="block text-sm font-medium text-gray-700">
                        CNPJ ou Número da Coleta
                    </label>
                    <div class="relative">
                        <input type="text" 
                               id="busca" 
                               name="busca" 
                               value="<?php echo e(old('busca')); ?>"
                               class="w-full px-4 py-4 text-base border border-gray-300 rounded-xl focus:ring-2 focus:ring-gray-500/20 focus:border-gray-500 transition-all duration-300 bg-white <?php $__errorArgs = ['busca'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="Ex: 12.345.678/0001-90 ou COL-2024-001"
                               required>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
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
                        class="w-full bg-gray-900 hover:bg-gray-800 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl">
                    <span class="flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span>Consultar Coleta</span>
                    </span>
                </button>
            </form>
            
            <!-- Quick Tips -->
            <div class="mt-6 pt-6 border-t border-gray-100">
                <p class="text-center text-sm text-gray-500">
                    ⚡ Consulta instantânea • 🔄 Atualizações em tempo real • 🔒 100% seguro
                </p>
            </div>
        </div>
    </div>

    <!-- Como Funciona - Clean Cards -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16 bg-gray-50">
        <div class="text-center mb-12">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">
                Como Funciona
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Processo transparente e simples do início ao fim
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-gray-900 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl">📋</span>
                </div>
                <div class="bg-gray-100 rounded-full w-8 h-8 flex items-center justify-center mx-auto mb-4">
                    <span class="text-sm font-bold text-gray-900">1</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Agendamento</h3>
                <p class="text-gray-600 leading-relaxed">
                    Sua coleta é agendada e nossa equipe se prepara para a coleta das peças
                </p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-gray-900 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl">🚚</span>
                </div>
                <div class="bg-gray-100 rounded-full w-8 h-8 flex items-center justify-center mx-auto mb-4">
                    <span class="text-sm font-bold text-gray-900">2</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Processamento</h3>
                <p class="text-gray-600 leading-relaxed">
                    Realizamos a coleta, pesagem e empacotamento das suas peças com total cuidado
                </p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-gray-900 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl">✅</span>
                </div>
                <div class="bg-gray-100 rounded-full w-8 h-8 flex items-center justify-center mx-auto mb-4">
                    <span class="text-sm font-bold text-gray-900">3</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Entrega</h3>
                <p class="text-gray-600 leading-relaxed">
                    Suas peças são entregues limpas e organizadas no prazo combinado
                </p>
            </div>
        </div>
    </div>

    <!-- Status Timeline - Clean Design -->
    <div class="bg-white py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">
                    Status de Acompanhamento
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Veja em tempo real cada etapa do processo da sua coleta
                </p>
            </div>

            <div class="bg-gray-50 rounded-2xl p-8">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-3">
                            <span class="text-sm font-bold text-gray-600">1</span>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-1">Agendada</h4>
                        <p class="text-sm text-gray-600">Coleta programada</p>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-3">
                            <span class="text-sm font-bold text-gray-600">2</span>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-1">Coletando</h4>
                        <p class="text-sm text-gray-600">Em andamento</p>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-3">
                            <span class="text-sm font-bold text-gray-600">3</span>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-1">Processando</h4>
                        <p class="text-sm text-gray-600">Pesagem e limpeza</p>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-3">
                            <span class="text-sm font-bold text-gray-600">4</span>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-1">Em Trânsito</h4>
                        <p class="text-sm text-gray-600">A caminho</p>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-gray-900 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-1">Entregue</h4>
                        <p class="text-sm text-gray-600">Finalizado</p>
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