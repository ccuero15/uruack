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
        Schema::table('item_nomina_deduccion', function (Blueprint $table) {
            $table->string('descripcion')->nullable()->after('monto');
            $table->unsignedBigInteger('deduccion_id')->nullable()->change();
        });

        Schema::table('item_nomina_beneficio', function (Blueprint $table) {
            $table->string('descripcion')->nullable()->after('monto');
            $table->unsignedBigInteger('beneficio_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_nomina_deduccion', function (Blueprint $table) {
            $table->dropColumn('descripcion');
            $table->unsignedBigInteger('deduccion_id')->nullable(false)->change();
        });

        Schema::table('item_nomina_beneficio', function (Blueprint $table) {
            $table->dropColumn('descripcion');
            $table->unsignedBigInteger('beneficio_id')->nullable(false)->change();
        });
    }
};
