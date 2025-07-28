<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etiqueta - <?php echo e($empacotamento->codigo_qr ?: 'Empacotamento'); ?></title>
    <style>
        @page {
            size: 6cm 4cm;
            margin: 0.2cm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 8px;
            line-height: 1.1;
            margin: 0;
            padding: 0;
            background: white;
        }

        .etiqueta {
            width: 100%;
            height: 100%;
            border: 1px solid #000;
            padding: 3px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
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
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .no-print {
                display: none;
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
    
    <div class="etiqueta">
        <!-- Header -->
        <div class="header">
            <div class="logo">LAVANDERIA</div>
            <div class="codigo"><?php echo e($empacotamento->codigo_qr ?: 'CÓDIGO NÃO GERADO'); ?></div>
            <div style="font-size: 6px;"><?php echo e($empacotamento->data_empacotamento->format('d/m/Y')); ?></div>
        </div>
        
        <!-- Informações Básicas -->
        <div class="info-section">
            <div class="info-content">
                <strong><?php echo e(Str::limit($empacotamento->coleta->estabelecimento->razao_social, 25)); ?></strong><br>
                <strong><?php echo e($empacotamento->coleta->numero_coleta); ?></strong> - <?php echo e(number_format($empacotamento->coleta->peso_total, 1, ',', '.')); ?>kg
            </div>
        </div>
        
        <!-- Peças -->
        <div class="info-section">
            <?php if($empacotamento->coleta->pecas->count() > 0): ?>
                <table class="pecas-table">
                    <tbody>
                        <?php $__currentLoopData = $empacotamento->coleta->pecas->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $peca): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e(Str::limit($peca->tipo ? $peca->tipo->nome : 'N/A', 12)); ?></td>
                                <td><?php echo e($peca->quantidade_empacotada > 0 ? $peca->quantidade_empacotada : $peca->quantidade); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if($empacotamento->coleta->pecas->count() > 3): ?>
                            <tr>
                                <td colspan="2" style="text-align: center;">...</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div style="font-size: 5px; text-align: center;">
                    Total: <?php echo e($empacotamento->coleta->pecas->sum(function($p) { return $p->quantidade_empacotada > 0 ? $p->quantidade_empacotada : $p->quantidade; })); ?> peças
                </div>
            <?php else: ?>
                <div class="info-content">Sem peças</div>
            <?php endif; ?>
        </div>
        
        <!-- QR Code -->
        <div class="qr-section">
            <div class="qr-code">
                <?php if($empacotamento->codigo_qr): ?>
                    <?php echo QrCode::size(40)->generate($empacotamento->codigo_qr); ?>

                <?php else: ?>
                    <div style="width: 40px; height: 40px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; font-size: 6px;">
                        Erro
                    </div>
                <?php endif; ?>
            </div>
            <div class="qr-text">
                <?php echo e($empacotamento->codigo_qr ?: 'N/A'); ?>

            </div>
        </div>
    </div>
    
    <script>
        // Auto-print quando a página carregar (opcional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
<?php /**PATH C:\wamp64\www\lavanderia\resources\views/empacotamento/etiqueta.blade.php ENDPATH**/ ?>