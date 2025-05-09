<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQrCodeSessionsTable extends Migration
{
    public function up()
    {
        Schema::create('qr_code_sessions', function (Blueprint $table) {
            $table->id();
            // Entrenador que creó la sesión
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nombre');
            $table->string('actividad');            
            $table->boolean('activo')->default(true);
            // Código QR alfanumérico único
            $table->string('codigo')->unique();
            // Ruta de la imagen PNG generada para el QR
            $table->string('qr_image')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('qr_code_sessions');
    }
}
