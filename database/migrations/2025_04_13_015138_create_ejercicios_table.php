<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEjerciciosTable extends Migration
{
    public function up(): void
    {
        Schema::create('ejercicios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            $table->string('nombre_ejercicio');
            $table->text('descripcion')->nullable();

            // Campos agregados directamente
            $table->enum('nivel_dificultad', ['Baja', 'Media', 'Alta'])->default('Media');
            $table->string('grupo_muscular')->nullable();
            $table->integer('series')->nullable();
            $table->integer('repeticiones')->nullable();
            $table->integer('calorias_aprox')->nullable()->comment('Calorías aproximadas por serie');
            $table->integer('duracion')->nullable(); // Duración en minutos
            $table->string('foto')->nullable();
            $table->string('video')->nullable();

            $table->date('fecha');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ejercicios');
    }
}
