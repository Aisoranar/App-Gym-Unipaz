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
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Entrenador que creó la sesión
            $table->string('nombre');
            $table->boolean('activo')->default(true);
            $table->string('codigo')->unique(); // Código QR único
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('qr_code_sessions');
    }
}
