<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQrScansTable extends Migration
{
    public function up()
    {
        Schema::create('qr_scans', function (Blueprint $table) {
            $table->id();
            // Usuario que escaneó
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            // Sesión QR escaneada
            $table->foreignId('qr_code_session_id')->constrained('qr_code_sessions')->onDelete('cascade');
            $table->string('carrera');
            $table->date('fecha');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('qr_scans');
    }
}
