<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Empacotamento;
use App\Models\Status;

echo "📦 EMPACOTAMENTOS ATUAIS:\n";
$empacotamentos = Empacotamento::with(['status', 'coleta.estabelecimento'])->get();
foreach ($empacotamentos as $emp) {
    echo "ID: {$emp->id} | QR: {$emp->codigo_qr} | Status: {$emp->status->nome} (ID: {$emp->status_id})\n";
}

echo "\n🎯 ATUALIZAR EMPACOTAMENTO MAIS RECENTE PARA TESTE:\n";
$prontoStatus = Status::where('nome', 'Pronto para motorista')->first();
$emp = Empacotamento::orderBy('id', 'desc')->first(); // Pegar o mais recente
if ($emp && $prontoStatus) {
    $emp->update(['status_id' => $prontoStatus->id]);
    echo "✅ Empacotamento {$emp->codigo_qr} (ID: {$emp->id}) atualizado para 'Pronto para motorista'\n";
    
    echo "\n📦 VERIFICAÇÃO APÓS ATUALIZAÇÃO:\n";
    $emp->refresh();
    echo "QR: {$emp->codigo_qr} | Status: {$emp->status->nome}\n";
}
?>
