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
        Schema::create('recibos_pago', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_nomina_id')->unique()->constrained('item_nomina')->onDelete('cascade');
            $table->date('fecha_emision');
            $table->string('codigo_verificacion', 100)->nullable();
            $table->string('ruta_pdf', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recibos_pago');
    }
};
