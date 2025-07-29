<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('entregas', function (Blueprint $table) {
            $table->foreignId('empacotamento_id')->constrained('empacotamento')->onDelete('cascade');
            $table->foreignId('motorista_saida_id')->nullable()->constrained('usuarios');
            $table->foreignId('motorista_entrega_id')->nullable()->constrained('usuarios');
            $table->foreignId('status_id')->constrained('status');
            $table->datetime('data_saida')->nullable();
            $table->datetime('data_entrega')->nullable();
            $table->datetime('data_confirmacao_recebimento')->nullable();
            $table->string('nome_recebedor')->nullable();
            $table->text('assinatura_recebedor')->nullable();
            $table->text('assinatura_cliente')->nullable();
            $table->text('observacoes_entrega')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entregas', function (Blueprint $table) {
            $table->dropForeign(['empacotamento_id']);
            $table->dropForeign(['motorista_saida_id']);
            $table->dropForeign(['motorista_entrega_id']);
            $table->dropForeign(['status_id']);
            $table->dropColumn([
                'empacotamento_id', 'motorista_saida_id', 'motorista_entrega_id', 'status_id',
                'data_saida', 'data_entrega', 'data_confirmacao_recebimento',
                'nome_recebedor', 'assinatura_recebedor', 'assinatura_cliente', 'observacoes_entrega'
            ]);
        });
    }
};
