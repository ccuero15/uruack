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
        Schema::table('ejecucion_nomina', function (Blueprint $table) {
            $table->text('comentario')->nullable()->after('estado');
            $table->decimal('total_pagado', 15, 2)->default(0)->after('comentario');
        });
    }
 
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ejecucion_nomina', function (Blueprint $table) {
            $table->dropColumn(['comentario', 'total_pagado']);
        });
    }
};
