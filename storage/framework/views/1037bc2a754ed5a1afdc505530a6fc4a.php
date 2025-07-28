

<?php $__env->startSection('title', 'Novo Estabelecimento - Sistema de Gestão de Lavanderia'); ?>

<?php $__env->startSection('content'); ?>
<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
    <div>
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">
            <svg class="inline w-5 h-5 sm:w-6 sm:h-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Novo Estabelecimento
        </h1>
        <p class="text-sm text-gray-600">Cadastre um novo hotel ou estabelecimento cliente</p>
    </div>
    <a href="<?php echo e(route('estabelecimentos.index')); ?>" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition-colors duration-200 mt-3 sm:mt-0">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Voltar
    </a>
</div>

<!-- Formulário -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <form method="POST" action="<?php echo e(route('estabelecimentos.store')); ?>" class="space-y-6">
        <?php echo csrf_field(); ?>
        
        <!-- Seção: Dados da Empresa -->
        <div>
            <h3 class="text-lg font-medium text-gray-900 mb-4">Dados da Empresa</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- CNPJ -->
                <div class="md:col-span-1">
                    <label for="cnpj" class="block text-sm font-medium text-gray-700 mb-2">
                        CNPJ *
                    </label>
                    <div class="relative">
                        <input type="text" 
                               id="cnpj" 
                               name="cnpj" 
                               value="<?php echo e(old('cnpj')); ?>"
                               placeholder="00.000.000/0000-00"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm <?php $__errorArgs = ['cnpj'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               required>
                        <button type="button" 
                                id="buscar-cnpj"
                                class="absolute right-2 top-1/2 transform -translate-y-1/2 px-3 py-1 bg-primary-600 hover:bg-primary-700 text-white text-xs rounded transition-colors duration-200">
                            Buscar
                        </button>
                    </div>
                    <?php $__errorArgs = ['cnpj'];
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

                <!-- Loading indicator -->
                <div id="loading-cnpj" class="hidden md:col-span-1 flex items-center">
                    <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-primary-600"></div>
                    <span class="ml-2 text-sm text-gray-600">Buscando dados...</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <!-- Razão Social -->
                <div>
                    <label for="razao_social" class="block text-sm font-medium text-gray-700 mb-2">
                        Razão Social *
                    </label>
                    <input type="text" 
                           id="razao_social" 
                           name="razao_social" 
                           value="<?php echo e(old('razao_social')); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm <?php $__errorArgs = ['razao_social'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           required>
                    <?php $__errorArgs = ['razao_social'];
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

                <!-- Nome Fantasia -->
                <div>
                    <label for="nome_fantasia" class="block text-sm font-medium text-gray-700 mb-2">
                        Nome Fantasia
                    </label>
                    <input type="text" 
                           id="nome_fantasia" 
                           name="nome_fantasia" 
                           value="<?php echo e(old('nome_fantasia')); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm <?php $__errorArgs = ['nome_fantasia'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['nome_fantasia'];
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

        <!-- Seção: Endereço -->
        <div>
            <h3 class="text-lg font-medium text-gray-900 mb-4">Endereço</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- CEP -->
                <div>
                    <label for="cep" class="block text-sm font-medium text-gray-700 mb-2">
                        CEP *
                    </label>
                    <input type="text" 
                           id="cep" 
                           name="cep" 
                           value="<?php echo e(old('cep')); ?>"
                           placeholder="00000-000"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm <?php $__errorArgs = ['cep'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           required>
                    <?php $__errorArgs = ['cep'];
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

                <!-- Endereço -->
                <div class="md:col-span-2">
                    <label for="endereco" class="block text-sm font-medium text-gray-700 mb-2">
                        Endereço *
                    </label>
                    <input type="text" 
                           id="endereco" 
                           name="endereco" 
                           value="<?php echo e(old('endereco')); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm <?php $__errorArgs = ['endereco'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           required>
                    <?php $__errorArgs = ['endereco'];
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

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">
                <!-- Número -->
                <div>
                    <label for="numero" class="block text-sm font-medium text-gray-700 mb-2">
                        Número *
                    </label>
                    <input type="text" 
                           id="numero" 
                           name="numero" 
                           value="<?php echo e(old('numero')); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm <?php $__errorArgs = ['numero'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           required>
                    <?php $__errorArgs = ['numero'];
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

                <!-- Complemento -->
                <div>
                    <label for="complemento" class="block text-sm font-medium text-gray-700 mb-2">
                        Complemento
                    </label>
                    <input type="text" 
                           id="complemento" 
                           name="complemento" 
                           value="<?php echo e(old('complemento')); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm <?php $__errorArgs = ['complemento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['complemento'];
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

                <!-- Bairro -->
                <div class="md:col-span-2">
                    <label for="bairro" class="block text-sm font-medium text-gray-700 mb-2">
                        Bairro *
                    </label>
                    <input type="text" 
                           id="bairro" 
                           name="bairro" 
                           value="<?php echo e(old('bairro')); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm <?php $__errorArgs = ['bairro'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           required>
                    <?php $__errorArgs = ['bairro'];
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

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <!-- Cidade -->
                <div class="md:col-span-2">
                    <label for="cidade" class="block text-sm font-medium text-gray-700 mb-2">
                        Cidade *
                    </label>
                    <input type="text" 
                           id="cidade" 
                           name="cidade" 
                           value="<?php echo e(old('cidade')); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm <?php $__errorArgs = ['cidade'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           required>
                    <?php $__errorArgs = ['cidade'];
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

                <!-- Estado -->
                <div>
                    <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">
                        Estado *
                    </label>
                    <select id="estado" 
                            name="estado" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm <?php $__errorArgs = ['estado'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            required>
                        <option value="">Selecione</option>
                        <option value="AC" <?php echo e(old('estado') == 'AC' ? 'selected' : ''); ?>>AC</option>
                        <option value="AL" <?php echo e(old('estado') == 'AL' ? 'selected' : ''); ?>>AL</option>
                        <option value="AP" <?php echo e(old('estado') == 'AP' ? 'selected' : ''); ?>>AP</option>
                        <option value="AM" <?php echo e(old('estado') == 'AM' ? 'selected' : ''); ?>>AM</option>
                        <option value="BA" <?php echo e(old('estado') == 'BA' ? 'selected' : ''); ?>>BA</option>
                        <option value="CE" <?php echo e(old('estado') == 'CE' ? 'selected' : ''); ?>>CE</option>
                        <option value="DF" <?php echo e(old('estado') == 'DF' ? 'selected' : ''); ?>>DF</option>
                        <option value="ES" <?php echo e(old('estado') == 'ES' ? 'selected' : ''); ?>>ES</option>
                        <option value="GO" <?php echo e(old('estado') == 'GO' ? 'selected' : ''); ?>>GO</option>
                        <option value="MA" <?php echo e(old('estado') == 'MA' ? 'selected' : ''); ?>>MA</option>
                        <option value="MT" <?php echo e(old('estado') == 'MT' ? 'selected' : ''); ?>>MT</option>
                        <option value="MS" <?php echo e(old('estado') == 'MS' ? 'selected' : ''); ?>>MS</option>
                        <option value="MG" <?php echo e(old('estado') == 'MG' ? 'selected' : ''); ?>>MG</option>
                        <option value="PA" <?php echo e(old('estado') == 'PA' ? 'selected' : ''); ?>>PA</option>
                        <option value="PB" <?php echo e(old('estado') == 'PB' ? 'selected' : ''); ?>>PB</option>
                        <option value="PR" <?php echo e(old('estado') == 'PR' ? 'selected' : ''); ?>>PR</option>
                        <option value="PE" <?php echo e(old('estado') == 'PE' ? 'selected' : ''); ?>>PE</option>
                        <option value="PI" <?php echo e(old('estado') == 'PI' ? 'selected' : ''); ?>>PI</option>
                        <option value="RJ" <?php echo e(old('estado') == 'RJ' ? 'selected' : ''); ?>>RJ</option>
                        <option value="RN" <?php echo e(old('estado') == 'RN' ? 'selected' : ''); ?>>RN</option>
                        <option value="RS" <?php echo e(old('estado') == 'RS' ? 'selected' : ''); ?>>RS</option>
                        <option value="RO" <?php echo e(old('estado') == 'RO' ? 'selected' : ''); ?>>RO</option>
                        <option value="RR" <?php echo e(old('estado') == 'RR' ? 'selected' : ''); ?>>RR</option>
                        <option value="SC" <?php echo e(old('estado') == 'SC' ? 'selected' : ''); ?>>SC</option>
                        <option value="SP" <?php echo e(old('estado') == 'SP' ? 'selected' : ''); ?>>SP</option>
                        <option value="SE" <?php echo e(old('estado') == 'SE' ? 'selected' : ''); ?>>SE</option>
                        <option value="TO" <?php echo e(old('estado') == 'TO' ? 'selected' : ''); ?>>TO</option>
                    </select>
                    <?php $__errorArgs = ['estado'];
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

        <!-- Seção: Contato -->
        <div>
            <h3 class="text-lg font-medium text-gray-900 mb-4">Contato</h3>

            <!-- Telefone Principal -->
            <div class="mb-6">
                <label for="telefone" class="block text-sm font-medium text-gray-700 mb-2">
                    Telefone Principal *
                </label>
                <input type="text"
                       id="telefone"
                       name="telefone"
                       value="<?php echo e(old('telefone')); ?>"
                       placeholder="(11) 99999-9999"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm <?php $__errorArgs = ['telefone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       required>
                <?php $__errorArgs = ['telefone'];
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

            <!-- Emails -->
            <div class="mb-6">
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Emails (Opcional)
                    </label>
                    <button type="button"
                            id="add-email"
                            class="inline-flex items-center px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-sm rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Adicionar Email
                    </button>
                </div>
                <div id="emails-container">
                    <div class="email-item flex items-center gap-2 mb-2">
                        <input type="email"
                               name="emails[]"
                               placeholder="email@exemplo.com"
                               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                        <button type="button"
                                class="remove-email px-2 py-2 text-red-600 hover:text-red-800 transition-colors duration-200"
                                style="display: none;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <?php $__errorArgs = ['emails.*'];
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

            <!-- Contatos Responsáveis -->
            <div class="mb-6">
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Contatos Responsáveis (Opcional)
                    </label>
                    <button type="button"
                            id="add-contato"
                            class="inline-flex items-center px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Adicionar Contato
                    </button>
                </div>
                <div id="contatos-container">
                    <div class="contato-item border border-gray-200 rounded-lg p-4 mb-3">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-sm font-medium text-gray-700">Contato 1</h4>
                            <button type="button"
                                    class="remove-contato px-2 py-1 text-red-600 hover:text-red-800 transition-colors duration-200"
                                    style="display: none;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
                                <input type="text"
                                       name="contatos_responsaveis[0][nome]"
                                       placeholder="Nome do responsável"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Telefone</label>
                                <input type="text"
                                       name="contatos_responsaveis[0][telefone]"
                                       placeholder="(11) 99999-9999"
                                       class="contato-telefone w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                            </div>
                        </div>
                    </div>
                </div>
                <?php $__errorArgs = ['contatos_responsaveis.*.nome'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <?php $__errorArgs = ['contatos_responsaveis.*.telefone'];
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

        <!-- Seção: Observações -->
        <div>
            <label for="observacoes" class="block text-sm font-medium text-gray-700 mb-2">
                Observações
            </label>
            <textarea id="observacoes" 
                      name="observacoes" 
                      rows="3"
                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm <?php $__errorArgs = ['observacoes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('observacoes')); ?></textarea>
            <?php $__errorArgs = ['observacoes'];
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

        <!-- Botões -->
        <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
            <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-xl transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Cadastrar Estabelecimento
            </button>
            <a href="<?php echo e(route('estabelecimentos.index')); ?>" class="inline-flex items-center justify-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-xl transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Cancelar
            </a>
        </div>
    </form>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Máscaras
    const cnpjInput = document.getElementById('cnpj');
    const cepInput = document.getElementById('cep');
    const telefoneInput = document.getElementById('telefone');

    // Máscara CNPJ
    cnpjInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        value = value.replace(/^(\d{2})(\d)/, '$1.$2');
        value = value.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
        value = value.replace(/\.(\d{3})(\d)/, '.$1/$2');
        value = value.replace(/(\d{4})(\d)/, '$1-$2');
        e.target.value = value;
    });

    // Máscara CEP
    cepInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        value = value.replace(/^(\d{5})(\d)/, '$1-$2');
        e.target.value = value;
    });

    // Máscara Telefone
    function aplicarMascaraTelefone(input) {
        input.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{2})(\d)/, '($1) $2');
            value = value.replace(/(\d{4,5})(\d{4})$/, '$1-$2');
            e.target.value = value;
        });
    }

    aplicarMascaraTelefone(telefoneInput);

    // Aplicar máscara nos telefones de contato existentes
    document.querySelectorAll('.contato-telefone').forEach(aplicarMascaraTelefone);

    // Buscar CNPJ
    document.getElementById('buscar-cnpj').addEventListener('click', function() {
        const cnpj = cnpjInput.value.replace(/\D/g, '');

        if (cnpj.length !== 14) {
            alert('CNPJ deve ter 14 dígitos');
            return;
        }

        const loadingDiv = document.getElementById('loading-cnpj');
        const button = this;

        button.disabled = true;
        button.textContent = 'Buscando...';
        loadingDiv.classList.remove('hidden');

        fetch(`<?php echo e(url('/api/estabelecimentos/buscar-cnpj')); ?>?cnpj=${cnpj}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Preencher campos
                    document.getElementById('razao_social').value = data.data.razao_social || '';
                    document.getElementById('nome_fantasia').value = data.data.nome_fantasia || '';
                    document.getElementById('endereco').value = data.data.endereco || '';
                    document.getElementById('numero').value = data.data.numero || '';
                    document.getElementById('complemento').value = data.data.complemento || '';
                    document.getElementById('bairro').value = data.data.bairro || '';
                    document.getElementById('cidade').value = data.data.cidade || '';
                    document.getElementById('estado').value = data.data.estado || '';
                    document.getElementById('cep').value = data.data.cep || '';
                    document.getElementById('telefone').value = data.data.telefone || '';

                    // Preencher emails
                    const emailsContainer = document.getElementById('emails-container');
                    emailsContainer.innerHTML = '';
                    if (data.data.emails && data.data.emails.length > 0) {
                        data.data.emails.forEach((email, index) => {
                            addEmailField(email);
                        });
                    } else {
                        addEmailField('');
                    }

                    alert('Dados encontrados e preenchidos automaticamente!');
                } else {
                    alert(data.message || 'CNPJ não encontrado');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao buscar dados do CNPJ. Verifique se você está logado no sistema.');
            })
            .finally(() => {
                button.disabled = false;
                button.textContent = 'Buscar';
                loadingDiv.classList.add('hidden');
            });
    });

    // Gerenciamento de Emails Dinâmicos
    let emailCount = 1;

    function addEmailField(value = '') {
        const container = document.getElementById('emails-container');
        const emailItem = document.createElement('div');
        emailItem.className = 'email-item flex items-center gap-2 mb-2';
        emailItem.innerHTML = `
            <input type="email"
                   name="emails[]"
                   value="${value}"
                   placeholder="email@exemplo.com"
                   class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
            <button type="button"
                    class="remove-email px-2 py-2 text-red-600 hover:text-red-800 transition-colors duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        `;
        container.appendChild(emailItem);
        updateEmailRemoveButtons();
    }

    function updateEmailRemoveButtons() {
        const emailItems = document.querySelectorAll('.email-item');
        emailItems.forEach((item, index) => {
            const removeBtn = item.querySelector('.remove-email');
            if (emailItems.length > 1) {
                removeBtn.style.display = 'block';
            } else {
                removeBtn.style.display = 'none';
            }
        });
    }

    document.getElementById('add-email').addEventListener('click', function() {
        addEmailField();
    });

    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-email')) {
            e.target.closest('.email-item').remove();
            updateEmailRemoveButtons();
        }
    });

    // Gerenciamento de Contatos Dinâmicos
    let contatoCount = 1;

    function addContatoField(nome = '', telefone = '') {
        const container = document.getElementById('contatos-container');
        const contatoItem = document.createElement('div');
        contatoItem.className = 'contato-item border border-gray-200 rounded-lg p-4 mb-3';
        contatoItem.innerHTML = `
            <div class="flex items-center justify-between mb-3">
                <h4 class="text-sm font-medium text-gray-700">Contato ${contatoCount + 1}</h4>
                <button type="button"
                        class="remove-contato px-2 py-1 text-red-600 hover:text-red-800 transition-colors duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
                    <input type="text"
                           name="contatos_responsaveis[${contatoCount}][nome]"
                           value="${nome}"
                           placeholder="Nome do responsável"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Telefone</label>
                    <input type="text"
                           name="contatos_responsaveis[${contatoCount}][telefone]"
                           value="${telefone}"
                           placeholder="(11) 99999-9999"
                           class="contato-telefone w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                </div>
            </div>
        `;
        container.appendChild(contatoItem);

        // Aplicar máscara no novo campo de telefone
        const novoTelefone = contatoItem.querySelector('.contato-telefone');
        aplicarMascaraTelefone(novoTelefone);

        contatoCount++;
        updateContatoRemoveButtons();
    }

    function updateContatoRemoveButtons() {
        const contatoItems = document.querySelectorAll('.contato-item');
        contatoItems.forEach((item, index) => {
            const removeBtn = item.querySelector('.remove-contato');
            if (contatoItems.length > 1) {
                removeBtn.style.display = 'block';
            } else {
                removeBtn.style.display = 'none';
            }
        });
    }

    document.getElementById('add-contato').addEventListener('click', function() {
        addContatoField();
    });

    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-contato')) {
            e.target.closest('.contato-item').remove();
            updateContatoRemoveButtons();
        }
    });

    // Inicializar botões de remoção
    updateEmailRemoveButtons();
    updateContatoRemoveButtons();
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\lavanderia\resources\views/estabelecimentos/create.blade.php ENDPATH**/ ?>