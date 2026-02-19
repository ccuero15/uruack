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
        Schema::table('tipos_incidencia', function (Blueprint $table) {
            $table->enum('tipo_ajuste', ['Suma', 'Resta', 'Informativo'])->after('afecta_pago')->default('Informativo');
            $table->decimal('factor', 5, 2)->after('tipo_ajuste')->default(1.0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tipos_incidencia', function (Blueprint $table) {
            $table->dropColumn(['tipo_ajuste', 'factor']);
        });
    }
};
