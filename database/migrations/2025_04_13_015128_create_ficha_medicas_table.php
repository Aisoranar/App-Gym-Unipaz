<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFichaMedicasTable extends Migration
{
    public function up(): void
    {
        Schema::create('ficha_medicas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            
            $table->string('apellidos');
            $table->string('nombre');
            $table->date('fecha_nacimiento');
            $table->integer('edad');
            $table->enum('sexo', ['F', 'M']);
            $table->string('domicilio');
            $table->string('barrio')->nullable();
            $table->string('telefonos')->nullable();
            
            $table->string('tipo_sangre');
            $table->enum('factor_rh', ['Positivo', 'Negativo']);
            $table->enum('lateralidad', ['Diestro', 'Zurdo']);
            
            $table->string('actividad_fisica')->nullable();
            $table->integer('frecuencia_semanal')->nullable();
            $table->string('nombre_padre')->nullable();
            $table->string('nombre_madre')->nullable();
            $table->string('nombre_acudiente')->nullable();
            $table->string('parentesco')->nullable();
            
            $table->text('lesiones')->nullable();
            $table->text('alergias')->nullable();
            $table->boolean('padece_enfermedad')->default(false);
            $table->string('enfermedad')->nullable();
            
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('ficha_medicas');
    }
}
