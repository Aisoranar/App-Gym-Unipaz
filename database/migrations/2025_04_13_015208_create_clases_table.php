<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClasesTable extends Migration
{
    public function up(): void
    {
        Schema::create('clases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->text('objetivos')->nullable();
            $table->date('fecha');
            $table->time('hora_inicio');
            $table->time('hora_fin')->nullable();
            $table->string('nivel')->nullable();
            $table->integer('max_participantes')->nullable();
            $table->string('imagen')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clases');
    }
}