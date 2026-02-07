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
        Schema::table('contratos', function (Blueprint $table) {
            // Eliminamos la columna que pide el ID obligatorio
            $table->dropColumn('tipo_contrato_id');

            // Aseguramos que tipo_contrato (el texto) sea obligatorio ahora
            $table->string('tipo_contrato')->change();
        });
    }

    public function down(): void
    {
        Schema::table('contratos', function (Blueprint $table) {
            $table->unsignedBigInteger('tipo_contrato_id')->nullable();
        });
    }
};
