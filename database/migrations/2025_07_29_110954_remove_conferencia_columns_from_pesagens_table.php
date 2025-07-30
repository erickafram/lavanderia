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
        Schema::table('pesagens', function (Blueprint $table) {
            $table->dropColumn(['conferido', 'usuario_conferencia_id', 'data_conferencia']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesagens', function (Blueprint $table) {
            $table->boolean('conferido')->default(false);
            $table->unsignedBigInteger('usuario_conferencia_id')->nullable();
            $table->timestamp('data_conferencia')->nullable();

            $table->foreign('usuario_conferencia_id')->references('id')->on('usuarios');
        });
    }
};
