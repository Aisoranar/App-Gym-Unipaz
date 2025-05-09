<?php
// database/migrations/2025_05_08_000000_crear_tabla_entradas_peso.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entradas_peso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('peso_actual_kg', 5, 2)->comment('Peso actual en kilogramos');
            $table->decimal('peso_ideal_kg', 5, 2)->nullable()->comment('Peso objetivo en kilogramos');
            $table->integer('altura_cm')->comment('Altura en centímetros');
            $table->decimal('imc', 4, 2)->comment('Índice de Masa Corporal calculado');
            $table->string('estado_peso', 30)->comment('Clasificación IMC');
            $table->date('fecha')->comment('Fecha del registro de peso');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entradas_peso');
    }
};