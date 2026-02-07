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
            // Solo añadimos si no existen para evitar errores
            if (!Schema::hasColumn('contratos', 'salario_base')) {
                $table->decimal('salario_base', 12, 2)->default(0);
            }
            if (!Schema::hasColumn('contratos', 'tipo_contrato')) {
                $table->string('tipo_contrato')->nullable();
            }
            if (!Schema::hasColumn('contratos', 'fecha_fin')) {
                $table->date('fecha_fin')->nullable();
            }
            if (!Schema::hasColumn('contratos', 'estado')) {
                $table->string('estado')->default('Vigente');
            }
        });
    }

    public function down(): void
    {
        Schema::table('contratos', function (Blueprint $table) {
            $table->dropColumn(['salario_base', 'tipo_contrato', 'fecha_fin', 'estado']);
        });
    }
};
