<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Sistema de Gestão de Lavanderia'); ?></title>

    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f4ff',
                            100: '#e0e9ff',
                            200: '#c7d6fe',
                            300: '#a5b8fc',
                            400: '#8b93f8',
                            500: '#7c6df2',
                            600: '#6d4de6',
                            700: '#5d3dcb',
                            800: '#4c32a4',
                            900: '#402d82',
                        }
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    },
                    fontSize: {
                        'xs': ['0.65rem', { lineHeight: '1rem' }],
                        'sm': ['0.75rem', { lineHeight: '1.25rem' }],
                        'base': ['0.8rem', { lineHeight: '1.4rem' }],
                        'lg': ['0.9rem', { lineHeight: '1.5rem' }],
                        'xl': ['1rem', { lineHeight: '1.6rem' }],
                        '2xl': ['1.2rem', { lineHeight: '1.8rem' }],
                        '3xl': ['1.5rem', { lineHeight: '2rem' }],
                    }
                }
            }
        }
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-gray-50 font-sans text-sm">
    <div class="flex min-h-screen">
        <!-- Mobile menu button -->
        <div class="lg:hidden fixed top-4 left-4 z-50">
            <button id="mobile-menu-button" class="p-3 bg-slate-900 text-white rounded-xl shadow-xl border border-slate-700 backdrop-blur-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        <!-- Sidebar -->
        <nav id="sidebar" class="fixed lg:static inset-y-0 left-0 z-40 w-72 bg-white border-r border-gray-200 shadow-lg transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="p-6 border-b border-gray-200 bg-white">
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <div class="w-12 h-12 bg-gray-900 rounded-xl flex items-center justify-center shadow-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </div>
                            <div class="absolute -top-1 -right-1 w-5 h-5 bg-green-500 rounded-full border-2 border-white shadow-sm"></div>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">212lavanderia</h2>
                            <p class="text-gray-500 text-sm">Sistema de Gestão</p>
                        </div>
                    </div>
                </div>

                <!-- Menu Principal -->
                <div class="flex-1 px-4 py-6 overflow-y-auto bg-white">
                    <div class="space-y-3">

                        <!-- Dashboard - Não mostrar para motoristas -->
                        <?php if(!auth()->user()->nivelAcesso || auth()->user()->nivelAcesso->nome !== 'Motorista'): ?>
                        <div class="mb-6">
                            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3 px-3">Principal</h3>
                            <div class="space-y-1">
                                <a href="<?php echo e(route('painel')); ?>" class="group flex items-center px-4 py-3 text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-xl transition-all duration-200 <?php echo e(request()->routeIs('painel') ? 'bg-gray-100 text-gray-900 shadow-sm' : ''); ?>">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-xl <?php echo e(request()->routeIs('painel') ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-600 group-hover:bg-gray-200'); ?> transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v3H8V5z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="font-semibold text-sm">Dashboard</p>
                                        <p class="text-xs text-gray-500">Visão geral do sistema</p>
                                    </div>
                                </a>

                                <a href="<?php echo e(route('acompanhar-coletas')); ?>" class="group flex items-center px-4 py-3 text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-xl transition-all duration-200 <?php echo e(request()->routeIs('acompanhar-coletas') ? 'bg-gray-100 text-gray-900 shadow-sm' : ''); ?>">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-xl <?php echo e(request()->routeIs('acompanhar-coletas') ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-600 group-hover:bg-gray-200'); ?> transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="font-semibold text-sm">Acompanhar Coletas</p>
                                        <p class="text-xs text-gray-500">Monitorar progresso</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Operações - Não mostrar para motoristas -->
                        <?php if(!auth()->user()->nivelAcesso || auth()->user()->nivelAcesso->nome !== 'Motorista'): ?>
                        <div class="mb-6">
                            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3 px-3">Operações</h3>
                            <div class="space-y-1">
                                <?php if(auth()->user()->temPermissao('estabelecimentos.visualizar')): ?>
                                <a href="<?php echo e(route('estabelecimentos.index')); ?>" class="group flex items-center px-4 py-3 text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-xl transition-all duration-200 <?php echo e(request()->routeIs('estabelecimentos.*') ? 'bg-gray-100 text-gray-900 shadow-sm' : ''); ?>">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-xl <?php echo e(request()->routeIs('estabelecimentos.*') ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-600 group-hover:bg-gray-200'); ?> transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="font-semibold text-sm">Estabelecimentos</p>
                                        <p class="text-xs text-gray-500">Gerenciar clientes</p>
                                    </div>
                                </a>
                                <?php endif; ?>

                                <?php if(auth()->user()->temPermissao('coletas.visualizar')): ?>
                                <a href="<?php echo e(route('coletas.index')); ?>" class="group flex items-center px-4 py-3 text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-xl transition-all duration-200 <?php echo e(request()->routeIs('coletas.*') ? 'bg-gray-100 text-gray-900 shadow-sm' : ''); ?>">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-xl <?php echo e(request()->routeIs('coletas.*') ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-600 group-hover:bg-gray-200'); ?> transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="font-semibold text-sm">Coletas</p>
                                        <p class="text-xs text-gray-500">Agendar e gerenciar</p>
                                    </div>
                                </a>
                                <?php endif; ?>

                                <?php if(auth()->user()->temPermissao('pesagem.visualizar')): ?>
                                <a href="<?php echo e(route('pesagem.index')); ?>" class="group flex items-center px-4 py-3 text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-xl transition-all duration-200 <?php echo e(request()->routeIs('pesagem.*') ? 'bg-gray-100 text-gray-900 shadow-sm' : ''); ?>">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-xl <?php echo e(request()->routeIs('pesagem.*') ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-500 group-hover:bg-gray-200'); ?> transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16l3-1m-3 1l-3-1"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="font-semibold text-sm">Pesagem</p>
                                        <p class="text-xs text-gray-500">Controle de peso</p>
                                    </div>
                                    <?php if(request()->routeIs('pesagem.*')): ?>
                                    <div class="ml-auto w-2 h-2 bg-orange-600 rounded-full"></div>
                                    <?php endif; ?>
                                </a>
                                <?php endif; ?>

                                <?php if(auth()->user()->temPermissao('empacotamento.visualizar')): ?>
                                <a href="<?php echo e(route('empacotamento.index')); ?>" class="group flex items-center px-4 py-3 text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-xl transition-all duration-200 <?php echo e(request()->routeIs('empacotamento.*') ? 'bg-gray-100 text-gray-900 shadow-sm' : ''); ?>">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-xl <?php echo e(request()->routeIs('empacotamento.*') ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-500 group-hover:bg-gray-200'); ?> transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="font-semibold text-sm">Empacotamento</p>
                                        <p class="text-xs text-gray-500">Finalizar pedidos</p>
                                    </div>
                                    <?php if(request()->routeIs('empacotamento.*')): ?>
                                    <div class="ml-auto w-2 h-2 bg-purple-600 rounded-full"></div>
                                    <?php endif; ?>
                                </a>
                                <?php endif; ?>

                                <?php if(auth()->user()->temPermissao('motorista.visualizar')): ?>
                                <a href="<?php echo e(route('motorista.dashboard')); ?>" class="group flex items-center px-4 py-3 text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-xl transition-all duration-200 <?php echo e(request()->routeIs('motorista.*') ? 'bg-gray-100 text-gray-900 shadow-sm' : ''); ?>">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-xl <?php echo e(request()->routeIs('motorista.*') ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-500 group-hover:bg-gray-200'); ?> transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0h6m-6 0l-1 12a2 2 0 002 2h6a2 2 0 002-2L16 7"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="font-semibold text-sm">Motorista</p>
                                        <p class="text-xs text-gray-500">Entregas e QR Code</p>
                                    </div>
                                    <?php if(request()->routeIs('motorista.*')): ?>
                                    <div class="ml-auto w-2 h-2 bg-green-600 rounded-full"></div>
                                    <?php endif; ?>
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Menu específico para Motoristas -->
                        <?php if(auth()->user()->nivelAcesso && auth()->user()->nivelAcesso->nome === 'Motorista'): ?>
                        <div class="mb-4">
                            <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 px-3">Entregas</h3>
                            <a href="<?php echo e(route('motorista.dashboard')); ?>" class="group flex items-center px-4 py-3 text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-xl transition-all duration-200 <?php echo e(request()->routeIs('motorista.*') ? 'bg-gray-100 text-gray-900 shadow-sm' : ''); ?>">
                                <div class="flex items-center justify-center w-10 h-10 rounded-xl <?php echo e(request()->routeIs('motorista.*') ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-500 group-hover:bg-gray-200'); ?> transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0h6m-6 0l-1 12a2 2 0 002 2h6a2 2 0 002-2L16 7"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="font-semibold text-sm">Dashboard</p>
                                    <p class="text-xs text-gray-500">Gerenciar entregas</p>
                                </div>
                                <?php if(request()->routeIs('motorista.*')): ?>
                                <div class="ml-auto w-2 h-2 bg-green-600 rounded-full"></div>
                                <?php endif; ?>
                            </a>
                        </div>
                        <?php endif; ?>



                        <!-- Administração -->
                        <?php if(auth()->user()->temPermissao('usuarios.visualizar') || auth()->user()->temPermissao('relatorios.visualizar')): ?>
                        <div class="mb-4">
                            <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 px-3">Administração</h3>
                            <div class="space-y-1">
                                <?php if(auth()->user()->temPermissao('usuarios.visualizar')): ?>
                                <a href="<?php echo e(route('usuarios.index')); ?>" class="group flex items-center px-4 py-3 text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-xl transition-all duration-200 <?php echo e(request()->routeIs('usuarios.*') ? 'bg-gray-100 text-gray-900 shadow-sm' : ''); ?>">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-xl <?php echo e(request()->routeIs('usuarios.*') ? 'bg-indigo-100 text-indigo-600' : 'bg-gray-100 text-gray-500 group-hover:bg-gray-200'); ?> transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="font-semibold text-sm">Usuários</p>
                                        <p class="text-xs text-gray-500">Gerenciar usuários</p>
                                    </div>
                                    <?php if(request()->routeIs('usuarios.*')): ?>
                                    <div class="ml-auto w-2 h-2 bg-indigo-600 rounded-full"></div>
                                    <?php endif; ?>
                                </a>
                                <?php endif; ?>

                                <?php if(auth()->user()->temPermissao('relatorios.visualizar')): ?>
                                <a href="<?php echo e(route('relatorios.index')); ?>" class="group flex items-center px-4 py-3 text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-xl transition-all duration-200 <?php echo e(request()->routeIs('relatorios.*') ? 'bg-gray-100 text-gray-900 shadow-sm' : ''); ?>">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-xl <?php echo e(request()->routeIs('relatorios.*') ? 'bg-slate-100 text-slate-600' : 'bg-gray-100 text-gray-500 group-hover:bg-gray-200'); ?> transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="font-semibold text-sm">Relatórios</p>
                                        <p class="text-xs text-gray-500">Análises e estatísticas</p>
                                    </div>
                                    <?php if(request()->routeIs('relatorios.*')): ?>
                                    <div class="ml-auto w-2 h-2 bg-slate-600 rounded-full"></div>
                                    <?php endif; ?>
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Menu do usuário -->
                <div class="p-4 border-t border-gray-100 mt-auto">
                    <div class="relative">
                        <div class="flex items-center px-3 py-2 bg-gray-50 hover:bg-gray-100 rounded-lg transition-all duration-200 cursor-pointer" onclick="toggleUserMenu()">
                            <div class="relative">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-blue-700 rounded-lg flex items-center justify-center">
                                    <span class="text-white font-semibold text-sm"><?php echo e(strtoupper(substr(auth()->user()->nome, 0, 2))); ?></span>
                                </div>
                                <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 rounded-full border-2 border-white shadow-sm"></div>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-gray-900 font-semibold text-sm text-sm"><?php echo e(Str::limit(auth()->user()->nome, 20)); ?></p>
                                <p class="text-gray-500 text-xs"><?php echo e(auth()->user()->email); ?></p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" id="userMenuIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>

                        <!-- Dropdown do usuário -->
                        <div id="userMenu" class="hidden absolute bottom-full left-0 right-0 mb-2 bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
                            <a href="#" class="flex items-center px-3 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-all duration-200">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <div>
                                    <p class="font-semibold text-sm">Meu Perfil</p>
                                    <p class="text-xs text-gray-400">Configurações da conta</p>
                                </div>
                            </a>
                            <div class="border-t border-gray-100"></div>
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="w-full flex items-center px-3 py-2 text-gray-600 hover:text-red-600 hover:bg-red-50 transition-all duration-200">
                                    <svg class="w-5 h-5 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    <div class="text-left">
                                        <p class="font-semibold text-sm">Sair do Sistema</p>
                                        <p class="text-xs text-gray-400">Encerrar sessão</p>
                                    </div>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Overlay para mobile -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden hidden"></div>

        <!-- Main content -->
        <main class="flex-1 bg-gradient-to-br from-gray-50 to-gray-100 lg:ml-0 min-h-screen">
            <div class="p-3 sm:p-4 lg:p-8 pt-16 lg:pt-8">
                <!-- Alertas -->
                <?php if(session('success')): ?>
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-green-800 font-semibold text-sm"><?php echo e(session('success')); ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-red-800 font-semibold text-sm"><?php echo e(session('error')); ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </main>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        function toggleUserMenu() {
            const menu = document.getElementById('userMenu');
            const icon = document.getElementById('userMenuIcon');

            menu.classList.toggle('hidden');
            icon.style.transform = menu.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
        }

        // Mobile menu functionality
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            function toggleMobileMenu() {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            }

            mobileMenuButton.addEventListener('click', toggleMobileMenu);
            overlay.addEventListener('click', toggleMobileMenu);

            // Fechar menu ao clicar fora
            document.addEventListener('click', function(event) {
                const userMenu = document.getElementById('userMenu');
                const userMenuButton = event.target.closest('[onclick="toggleUserMenu()"]');

                if (!userMenuButton && !userMenu.contains(event.target)) {
                    userMenu.classList.add('hidden');
                    document.getElementById('userMenuIcon').style.transform = 'rotate(0deg)';
                }
            });

            // Fechar sidebar mobile ao redimensionar para desktop
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.add('hidden');
                }
            });
        });
    </script>

    <!-- Caixa de Anotações Flutuante -->
    <?php echo $__env->make('components.notes-box', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\wamp64\www\lavanderia\resources\views/layouts/app.blade.php ENDPATH**/ ?>