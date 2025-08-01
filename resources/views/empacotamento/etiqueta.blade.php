<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etiqueta - {{ $empacotamento->codigo_qr ?: 'Empacotamento' }}</title>
    <style>
        @page {
            size: 6cm 4cm;
            margin: 0; /* Remove margens da página */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            width: 6cm;
            height: 4cm;
            font-family: Arial, sans-serif;
            font-size: 8px;
            line-height: 1.1;
            background: white;
            overflow: hidden;
        }

        .container-etiqueta {
            width: 6cm;
            height: 4cm;
            padding: 2mm; /* Pequeno padding para não colar nas bordas */
        }

        .etiqueta {
            width: 100%;
            height: 100%;
            border: 1px solid #000;
            padding: 3px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            page-break-inside: avoid;
            break-inside: avoid;
        }
        
        .header {
            text-align: center;
            border-bottom: 1px solid #000;
            padding-bottom: 2px;
            margin-bottom: 3px;
        }

        .logo {
            font-size: 8px;
            font-weight: bold;
            margin-bottom: 1px;
        }

        .codigo {
            font-size: 7px;
            font-weight: bold;
            background: #000;
            color: white;
            padding: 1px 3px;
            margin: 1px 0;
        }
        
        .info-section {
            margin-bottom: 2px;
            flex-grow: 1;
        }

        .info-title {
            font-weight: bold;
            font-size: 6px;
            margin-bottom: 1px;
            text-transform: uppercase;
            border-bottom: 1px solid #ccc;
        }

        .info-content {
            font-size: 6px;
            margin-bottom: 2px;
        }
        
        .pecas-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 5px;
            margin-bottom: 2px;
        }

        .pecas-table th,
        .pecas-table td {
            border: 1px solid #000;
            padding: 1px 2px;
            text-align: left;
        }

        .pecas-table th {
            background: #f0f0f0;
            font-weight: bold;
            font-size: 5px;
        }
        
        .qr-section {
            text-align: center;
            margin-top: auto;
            border-top: 1px solid #000;
            padding-top: 2px;
        }

        .qr-code {
            margin: 0 auto 1px;
        }

        .qr-text {
            font-size: 5px;
            font-weight: bold;
        }
        
        @media print {
            @page {
                size: 6cm 4cm;
                margin: 0;
            }

            * {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            html, body {
                width: 6cm !important;
                height: 4cm !important;
                margin: 0 !important;
                padding: 0 !important;
                overflow: hidden !important;
            }

            .container-etiqueta {
                width: 6cm !important;
                height: 4cm !important;
                margin: 0 !important;
                padding: 2mm !important;
            }

            .etiqueta {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                -webkit-break-inside: avoid !important;
            }

            .no-print {
                display: none !important;
            }
        }
        
        .print-button {
            position: fixed;
            top: 10px;
            right: 10px;
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            z-index: 1000;
        }
        
        .print-button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <button class="print-button no-print" onclick="window.print()">🖨️ Imprimir Etiqueta</button>

    <div class="container-etiqueta">
        <div class="etiqueta">
        <!-- Header -->
        <div class="header">
            <div class="logo">LAVANDERIA</div>
            <div class="codigo">{{ $empacotamento->codigo_qr ?: 'CÓDIGO NÃO GERADO' }}</div>
            <div style="font-size: 6px;">{{ $empacotamento->data_empacotamento->format('d/m/Y') }}</div>
        </div>
        
        <!-- Informações Básicas -->
        <div class="info-section">
            <div class="info-content">
                <strong>{{ Str::limit($empacotamento->coleta->estabelecimento->razao_social, 25) }}</strong><br>
                <strong>{{ $empacotamento->coleta->numero_coleta }}</strong> - {{ number_format($empacotamento->coleta->peso_total, 1, ',', '.') }}kg
            </div>
        </div>
        
        <!-- Peças -->
        <div class="info-section">
            @if($empacotamento->coleta->pecas->count() > 0)
                <table class="pecas-table">
                    <tbody>
                        @foreach($empacotamento->coleta->pecas->take(3) as $peca)
                            <tr>
                                <td>{{ Str::limit($peca->tipo ? $peca->tipo->nome : 'N/A', 12) }}</td>
                                <td>{{ $peca->quantidade_empacotada > 0 ? $peca->quantidade_empacotada : $peca->quantidade }}</td>
                            </tr>
                        @endforeach
                        @if($empacotamento->coleta->pecas->count() > 3)
                            <tr>
                                <td colspan="2" style="text-align: center;">...</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div style="font-size: 5px; text-align: center;">
                    Total: {{ $empacotamento->coleta->pecas->sum(function($p) { return $p->quantidade_empacotada > 0 ? $p->quantidade_empacotada : $p->quantidade; }) }} peças
                </div>
            @else
                <div class="info-content">Sem peças</div>
            @endif
        </div>
        
        <!-- QR Code -->
        <div class="qr-section">
            <div class="qr-code">
                @if($empacotamento->codigo_qr)
                    {!! QrCode::size(40)->generate($empacotamento->codigo_qr) !!}
                @else
                    <div style="width: 40px; height: 40px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; font-size: 6px;">
                        Erro
                    </div>
                @endif
            </div>
            <div class="qr-text">
                {{ $empacotamento->codigo_qr ?: 'N/A' }}
            </div>
        </div>
    </div>
    </div>

    <script>
        // Auto-print quando a página carregar (opcional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
