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
        Schema::create('niveis_acesso', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 50)->unique();
            $table->text('descricao')->nullable();
            $table->json('permissoes')->nullable(); // Armazena as permissões em JSON
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('niveis_acesso');
    }
};
