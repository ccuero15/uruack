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
        Schema::create('concepts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['assignment', 'deduction']);
            $table->decimal('value', 10, 2); // Fixed amount or percentage (if is_percentage true)
            $table->boolean('is_percentage')->default(false); // If true, value is % of base_salary
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('concepts');
    }
};
