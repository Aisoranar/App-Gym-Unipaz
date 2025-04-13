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
            $table->json('dias')->nullable();             // Array con los días de la semana seleccionados (ej. ["Lunes", "Miércoles", "Viernes"])
            $table->date('fecha_inicio')->nullable();       // Fecha en la que inicia la rutina
            $table->date('fecha_fin')->nullable();          // Fecha en la que se espera finalizar o reevaluar la rutina
            $table->time('hora_inicio')->nullable();        // Hora de inicio de cada sesión
            $table->time('hora_fin')->nullable();           // Hora de término de cada sesión
            $table->string('estado')->default('pendiente');   // estado de la rutina (pendiente, en curso, finalizada)
            $table->string('objetivo')->nullable();         // Meta u objetivo de la rutina (ej. ganar masa muscular)
            $table->string('intensidad')->nullable();       // Intensidad (baja, media, alta)
            $table->text('notas')->nullable();              // Notas o comentarios adicionales
            $table->timestamps();
            
            // Llave foránea para relacionar la rutina con el usuario
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('rutinas');
    }
}
