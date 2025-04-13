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
            $table->integer('series')->nullable();
            $table->integer('repeticiones')->nullable();
            $table->integer('duracion')->nullable();  // Duración en minutos
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
