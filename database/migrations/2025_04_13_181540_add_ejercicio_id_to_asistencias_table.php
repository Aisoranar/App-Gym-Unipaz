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
        Schema::table('asistencias', function (Blueprint $table) {
            $table->unsignedBigInteger('ejercicio_id')->nullable()->after('fecha');
            $table->foreign('ejercicio_id')->references('id')->on('ejercicios')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asistencias', function (Blueprint $table) {
            $table->dropForeign(['ejercicio_id']);
            $table->dropColumn('ejercicio_id');
        });
    }
};
