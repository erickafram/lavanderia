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
        Schema::table('anotacoes', function (Blueprint $table) {
            $table->string('pagina_nome', 150)->nullable()->after('pagina');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anotacoes', function (Blueprint $table) {
            $table->dropColumn('pagina_nome');
        });
    }
};
