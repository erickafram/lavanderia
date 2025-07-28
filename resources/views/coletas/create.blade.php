@extends('layouts.app')

@section('title', 'Nova Coleta - Sistema de Gestão de Lavanderia')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
    <div>
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">
            <svg class="inline w-5 h-5 sm:w-6 sm:h-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Nova Coleta
        </h1>
        <p class="text-sm text-gray-600">Agende uma nova coleta de roupas</p>
    </div>
    <div class="flex gap-2 mt-3 sm:mt-0">
        <a href="{{ route('coletas.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition-colors duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Voltar
        </a>
    </div>
</div>

<!-- Formulário -->
<form method="POST" action="{{ route('coletas.store') }}" class="space-y-6">
    @csrf
    
    <!-- Informações Básicas -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Informações da Coleta
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Estabelecimento -->
            <div>
                <label for="estabelecimento_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Estabelecimento *
                </label>
                <select id="estabelecimento_id" 
                        name="estabelecimento_id" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm @error('estabelecimento_id') border-red-500 @enderror"
                        required>
                    <option value="">Selecione um estabelecimento</option>
                    @foreach($estabelecimentos as $estabelecimento)
                        <option value="{{ $estabelecimento->id }}" {{ old('estabelecimento_id') == $estabelecimento->id ? 'selected' : '' }}>
                            {{ $estabelecimento->razao_social }}
                            @if($estabelecimento->nome_fantasia)
                                ({{ $estabelecimento->nome_fantasia }})
                            @endif
                        </option>
                    @endforeach
                </select>
                @error('estabelecimento_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Data de Agendamento -->
            <div>
                <label for="data_agendamento" class="block text-sm font-medium text-gray-700 mb-2">
                    Data e Hora do Agendamento *
                </label>
                <input type="datetime-local" 
                       id="data_agendamento" 
                       name="data_agendamento" 
                       value="{{ old('data_agendamento') }}"
                       min="{{ now()->format('Y-m-d\TH:i') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm @error('data_agendamento') border-red-500 @enderror"
                       required>
                @error('data_agendamento')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Observações -->
        <div class="mt-6">
            <label for="observacoes" class="block text-sm font-medium text-gray-700 mb-2">
                Observações
            </label>
            <textarea id="observacoes"
                      name="observacoes"
                      rows="3"
                      placeholder="Observações sobre a coleta..."
                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm @error('observacoes') border-red-500 @enderror">{{ old('observacoes') }}</textarea>
            @error('observacoes')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Motorista Acompanhante -->
        <div class="mt-6">
            <label for="acompanhante_id" class="block text-sm font-medium text-gray-700 mb-2">
                Motorista Acompanhante <span class="text-gray-500 text-xs">(opcional)</span>
            </label>
            <select id="acompanhante_id"
                    name="acompanhante_id"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm @error('acompanhante_id') border-red-500 @enderror">
                <option value="">Selecione um motorista</option>
                @foreach($motoristas as $motorista)
                    <option value="{{ $motorista->id }}" {{ old('acompanhante_id') == $motorista->id ? 'selected' : '' }}>
                        {{ $motorista->nome }}
                    </option>
                @endforeach
            </select>
            @error('acompanhante_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Informações Adicionais -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h4 class="text-sm font-semibold text-blue-800 mb-1">Próximo Passo</h4>
                    <p class="text-sm text-blue-700">
                        Após criar a coleta, você será direcionado para adicionar as peças coletadas.
                        Isso permite um controle mais preciso do processo de coleta.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Botões -->
    <div class="flex flex-col sm:flex-row gap-3 sm:justify-end">
        <a href="{{ route('coletas.index') }}" 
           class="inline-flex items-center justify-center px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-700 text-sm font-medium rounded-xl transition-colors duration-200">
            Cancelar
        </a>
        <button type="submit" 
                class="inline-flex items-center justify-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Agendar Coleta
        </button>
    </div>
</form>
@endsection


