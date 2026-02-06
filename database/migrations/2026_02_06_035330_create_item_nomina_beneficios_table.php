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
        Schema::create('item_nomina_beneficio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_nomina_id')->constrained('item_nomina')->onDelete('cascade');
            $table->foreignId('beneficio_id')->constrained('beneficios');
            $table->decimal('monto', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_nomina_beneficio');
    }
};
