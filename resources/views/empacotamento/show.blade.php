@extends('layouts.app')

@section('title', 'Detalhes do Empacotamento')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">
                <svg class="inline w-5 h-5 sm:w-6 sm:h-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                📦 Empacotamento {{ $empacotamento->codigo_qr }}
            </h1>
            <p class="text-sm text-gray-600">Detalhes do empacotamento e rastreamento</p>
        </div>
        <div class="flex gap-2 mt-3 sm:mt-0">
            <a href="{{ route('empacotamento.etiqueta', $empacotamento->id) }}"
               target="_blank"
               class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                Gerar Etiqueta
            </a>
            <a href="{{ route('empacotamento.reimprimir-qr', $empacotamento->id) }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Reimprimir QR
            </a>
            <a href="{{ route('empacotamento.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Voltar
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <!-- Detalhes do Empacotamento -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
                <div class="p-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Detalhes do Empacotamento
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Código: <span class="font-mono font-bold text-blue-600">{{ $empacotamento->codigo_qr }}</span></p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Status Atual -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-900 mb-3">Status Atual</h4>
                            <div class="flex items-center">
                                <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium"
                                      style="background-color: {{ $empacotamento->status->cor }}20; color: {{ $empacotamento->status->cor }};">
                                    <div class="w-2 h-2 rounded-full mr-2" style="background-color: {{ $empacotamento->status->cor }};"></div>
                                    {{ $empacotamento->status->nome }}
                                </span>
                            </div>
                        </div>

                        <!-- Data de Empacotamento -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-900 mb-3">Data de Empacotamento</h4>
                            <div class="text-lg font-bold text-gray-900">{{ $empacotamento->data_empacotamento->format('d/m/Y') }}</div>
                            <div class="text-sm text-gray-600">{{ $empacotamento->data_empacotamento->format('H:i:s') }}</div>
                        </div>

                        <!-- Responsável -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-900 mb-3">Responsável pelo Empacotamento</h4>
                            <div class="text-gray-900 font-medium">{{ $empacotamento->usuarioEmpacotamento->nome }}</div>
                        </div>
                    </div>

                    @if($empacotamento->observacoes_empacotamento)
                        <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <h4 class="font-semibold text-yellow-800 mb-2">Observações do Empacotamento</h4>
                            <p class="text-yellow-700">{{ $empacotamento->observacoes_empacotamento }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Informações do Hotel/Estabelecimento -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
                <div class="p-4 border-b border-gray-100 bg-gradient-to-r from-green-50 to-emerald-50">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Informações do Hotel
                    </h3>
                </div>
                <div class="p-6">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mt-1 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <div>
                                <h4 class="font-bold text-blue-900 text-lg">Hotel: {{ $empacotamento->coleta->estabelecimento->razao_social }}</h4>
                                @if($empacotamento->coleta->estabelecimento->nome_fantasia)
                                    <p class="text-blue-700 text-sm mt-1">{{ $empacotamento->coleta->estabelecimento->nome_fantasia }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900">{{ $empacotamento->coleta->numero_coleta }}</div>
                            <div class="text-sm text-gray-600">Número da Coleta</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900">{{ number_format($empacotamento->coleta->peso_total, 1, ',', '.') }} kg</div>
                            <div class="text-sm text-gray-600">Peso Total</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900">R$ {{ number_format($empacotamento->coleta->valor_total, 2, ',', '.') }}</div>
                            <div class="text-sm text-gray-600">Valor Total</div>
                        </div>
                    </div>

                    @if($empacotamento->coleta->estabelecimento->endereco)
                        <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                            <div class="text-sm text-gray-600">Endereço:</div>
                            <div class="text-gray-900">{{ $empacotamento->coleta->estabelecimento->endereco }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Peças Coletadas e Empacotadas -->
            @if($empacotamento->coleta->pecas->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="p-4 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-pink-50">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Peças Coletadas e Empacotadas
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Relação detalhada das peças processadas</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Peça</th>
                                    <th class="px-6 py-4 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">Quantidade Coletada</th>
                                    <th class="px-6 py-4 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">Quantidade Entregue</th>
                                    <th class="px-6 py-4 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">Peso (kg)</th>
                                    <th class="px-6 py-4 text-right text-sm font-bold text-gray-700 uppercase tracking-wider">Valor</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($empacotamento->coleta->pecas as $peca)
                                    <tr class="hover:bg-blue-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-3 h-3 bg-purple-500 rounded-full mr-3"></div>
                                                <div class="text-sm font-medium text-gray-900">{{ $peca->tipo->nome }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                {{ $peca->quantidade }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                {{ $peca->quantidade }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 font-medium">
                                            {{ number_format($peca->peso, 2, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-gray-900">
                                            R$ {{ number_format($peca->subtotal, 2, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-right text-sm font-bold text-gray-900">Total:</td>
                                    <td class="px-6 py-4 text-center text-sm font-bold text-gray-900">
                                        {{ number_format($empacotamento->coleta->peso_total, 2, ',', '.') }} kg
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-bold text-gray-900">
                                        R$ {{ number_format($empacotamento->coleta->valor_total, 2, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            @endif
        </div>

        <div class="lg:col-span-1 space-y-6">
            <!-- Código QR -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h4"></path>
                        </svg>
                        Código QR
                    </h3>
                </div>
                <div class="p-6 text-center">
                    <div class="mb-4">
                        {!! QrCode::size(150)->generate($empacotamento->codigo_qr) !!}
                    </div>
                    <div class="text-lg font-mono font-bold text-gray-900 mb-2">
                        {{ $empacotamento->codigo_qr }}
                    </div>
                    <div class="text-sm text-gray-600 mb-4">
                        Escaneie este código para realizar a entrega
                    </div>

                    <!-- Status Atual -->
                    <div class="border-t pt-4">
                        <span class="text-sm font-medium text-gray-700">Status:</span>
                        <div class="mt-2">
                            <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium"
                                  style="background-color: {{ $empacotamento->status->cor }}20; color: {{ $empacotamento->status->cor }};">
                                <div class="w-2 h-2 rounded-full mr-2" style="background-color: {{ $empacotamento->status->cor }};"></div>
                                {{ $empacotamento->status->nome }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informações de Entrega -->
            @if($empacotamento->status->nome === 'Entregue')
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="p-4 border-b border-gray-100 bg-gradient-to-r from-green-50 to-emerald-50">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Entrega Realizada
                        </h3>
                    </div>
                    <div class="p-4">
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                            <svg class="w-8 h-8 text-green-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <p class="text-green-800 font-medium">Empacotamento entregue com sucesso</p>
                            <p class="text-green-600 text-sm mt-1">Processo finalizado</p>
                        </div>
                    </div>
                </div>
            @else
                <!-- Aguardando Entrega -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="p-4 border-b border-gray-100 bg-gradient-to-r from-yellow-50 to-orange-50">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Aguardando Entrega
                        </h3>
                    </div>
                    <div class="p-4">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center">
                            <svg class="w-8 h-8 text-yellow-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-yellow-800 font-medium">Aguardando Entrega</p>
                            <p class="text-yellow-600 text-sm mt-1">O empacotamento ainda não foi entregue</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- QR Code -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                        </svg>
                        Código QR
                    </h3>
                </div>
                <div class="p-4 text-center">
                    <div class="text-sm text-gray-600 mb-2">{{ $empacotamento->codigo_qr }}</div>
                    <div class="text-xs text-gray-500">Use este código para rastreamento</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Entrega -->
@if($empacotamento->podeSerEntregue() && !$empacotamento->foiEntregue())
<div id="modalEntrega" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Confirmar Entrega</h3>
            <form method="POST" action="{{ route('empacotamento.confirmar-entrega', $empacotamento->id) }}">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="nome_recebedor" class="block text-sm font-medium text-gray-700 mb-2">
                        Nome do Recebedor <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nome_recebedor" id="nome_recebedor" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                </div>
                
                <div class="mb-4">
                    <label for="data_entrega" class="block text-sm font-medium text-gray-700 mb-2">
                        Data/Hora da Entrega <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" name="data_entrega" id="data_entrega" required
                           value="{{ now()->format('Y-m-d\TH:i') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                </div>
                
                <div class="mb-4">
                    <label for="observacoes_entrega" class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
                    <textarea name="observacoes_entrega" id="observacoes_entrega" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm"
                              placeholder="Observações sobre a entrega..."></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="fecharModalEntrega()" 
                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 text-sm font-medium rounded-lg">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg">
                        Confirmar Entrega
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
function abrirModalEntrega() {
    document.getElementById('modalEntrega').classList.remove('hidden');
}

function fecharModalEntrega() {
    document.getElementById('modalEntrega').classList.add('hidden');
}

// Fechar modal ao clicar fora
document.getElementById('modalEntrega').addEventListener('click', function(e) {
    if (e.target === this) {
        fecharModalEntrega();
    }
});
</script>
@endpush
@endsection
