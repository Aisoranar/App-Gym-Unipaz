<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecomendacionsTable extends Migration
{
    public function up(): void
    {
        Schema::create('recomendacions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');      // Usuario al que se le envía la recomendación
            $table->unsignedBigInteger('creado_por');     // Usuario (entrenador o superadmin) que crea la recomendación
            $table->text('contenido');
            $table->date('fecha');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('creado_por')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recomendacions');
    }
}
