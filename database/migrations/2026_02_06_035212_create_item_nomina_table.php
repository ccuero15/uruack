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
        Schema::create('item_nomina', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ejecucion_id')->constrained('ejecucion_nomina')->onDelete('cascade');
            $table->foreignId('empleado_id')->constrained('empleados');
            $table->decimal('salario_bruto', 12, 2);
            $table->decimal('total_deducciones', 12, 2)->default(0);
            $table->decimal('total_beneficios', 12, 2)->default(0);
            $table->decimal('salario_neto', 12, 2);

            // Evita que un empleado tenga dos registros en la misma nómina
            $table->unique(['ejecucion_id', 'empleado_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_nomina');
    }
};
