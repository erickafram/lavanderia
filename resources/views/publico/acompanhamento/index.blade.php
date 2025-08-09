@extends('layouts.public')

@section('title', 'Acompanhe sua Coleta')

@section('content')
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
                <form method="POST" action="{{ route('acompanhamento.buscar') }}" class="space-y-6">
                    @csrf

                    <!-- Mensagens de erro -->
                    @if(session('error'))
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="space-y-4">
                        <label for="busca" class="block text-lg font-medium text-gray-900">
                            CNPJ ou Número da Coleta
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   id="busca" 
                                   name="busca" 
                                   value="{{ old('busca') }}"
                                   class="w-full px-6 py-5 text-lg border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300 bg-gray-50 hover:bg-white @error('busca') border-red-500 @enderror"
                                   placeholder="Digite seu CNPJ ou número da coleta..."
                                   required>
                            <div class="absolute inset-y-0 right-0 pr-6 flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                        @error('busca')
                            <div class="flex items-center space-x-2 mt-3 text-red-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-sm font-medium">{{ $message }}</p>
                            </div>
                        @enderror
                    </div>

                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-5 px-8 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl text-lg">
                        <span class="flex items-center justify-center space-x-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <span>Consultar Agora</span>
                        </span>
                    </button>
                </form>
                
                <!-- Informações adicionais -->
                <div class="mt-8 pt-8 border-t border-gray-100 text-center">
                    <p class="text-gray-600 mb-4">Exemplo de formatos aceitos:</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="font-medium text-gray-900">CNPJ</p>
                            <p class="text-sm text-gray-600">12.345.678/0001-90</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="font-medium text-gray-900">Número da Coleta</p>
                            <p class="text-sm text-gray-600">COL-2024-001</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Como Funciona -->
    <div class="bg-gray-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                    Como Funciona nosso Serviço
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Um processo simples, eficiente e totalmente transparente
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="text-center">
                    <div class="relative mb-8">
                        <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0h6m-6 0l-1 12a2 2 0 002 2h6a2 2 0 002-2L16 7"></path>
                            </svg>
                        </div>
                        <div class="absolute top-6 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            <span class="bg-white text-blue-600 rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold shadow-md">1</span>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Coleta Agendada</h3>
                    <p class="text-gray-600 leading-relaxed text-lg">
                        Agendamos a coleta das suas peças no horário mais conveniente para você
                    </p>
                </div>

                <div class="text-center">
                    <div class="relative mb-8">
                        <div class="w-20 h-20 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                            </svg>
                        </div>
                        <div class="absolute top-6 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            <span class="bg-white text-green-600 rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold shadow-md">2</span>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Processamento</h3>
                    <p class="text-gray-600 leading-relaxed text-lg">
                        Suas peças passam por lavagem profissional, pesagem e empacotamento cuidadoso
                    </p>
                </div>

                <div class="text-center">
                    <div class="relative mb-8">
                        <div class="w-20 h-20 bg-purple-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="absolute top-6 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            <span class="bg-white text-purple-600 rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold shadow-md">3</span>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Entrega</h3>
                    <p class="text-gray-600 leading-relaxed text-lg">
                        Devolvemos suas peças limpas, organizadas e no prazo combinado
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Nossos Diferenciais -->
    <div class="bg-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                    Por que escolher a 212lavanderia?
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Comprometidos com a excelência e satisfação dos nossos clientes
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Tecnologia Avançada</h3>
                    <p class="text-gray-600">Equipamentos modernos para melhor resultado</p>
                </div>
                
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Cuidado Especial</h3>
                    <p class="text-gray-600">Tratamento personalizado para cada peça</p>
                </div>
                
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-yellow-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Pontualidade</h3>
                    <p class="text-gray-600">Cumprimos rigorosamente os prazos</p>
                </div>
                
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Segurança</h3>
                    <p class="text-gray-600">Suas peças estão sempre protegidas</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
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
@endpush
@endsection

