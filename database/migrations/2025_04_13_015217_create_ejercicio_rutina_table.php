<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEjercicioRutinaTable extends Migration
{
    public function up(): void
    {
        Schema::create('ejercicio_rutina', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rutina_id');
            $table->unsignedBigInteger('ejercicio_id');
            $table->timestamps();
            
            $table->foreign('rutina_id')->references('id')->on('rutinas')->onDelete('cascade');
            $table->foreign('ejercicio_id')->references('id')->on('ejercicios')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('ejercicio_rutina');
    }
}
