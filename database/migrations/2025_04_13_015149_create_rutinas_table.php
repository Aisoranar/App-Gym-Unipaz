<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRutinasTable extends Migration
{
    public function up(): void
    {
        Schema::create('rutinas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->integer('dias_por_semana')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('rutinas');
    }
}
