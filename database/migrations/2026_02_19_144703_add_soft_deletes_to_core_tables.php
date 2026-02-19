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
        Schema::table('empleados', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('contratos', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('deducciones', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('beneficios', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('cargos', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('incidencias', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('tipos_incidencia', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('empleados', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('contratos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('deducciones', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('beneficios', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('cargos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('incidencias', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('tipos_incidencia', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
