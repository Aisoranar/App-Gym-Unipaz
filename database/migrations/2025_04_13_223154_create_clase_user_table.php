<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClaseUserTable extends Migration
{
    public function up(): void
    {
        Schema::create('clase_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clase_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('clase_id')
                  ->references('id')
                  ->on('clases')
                  ->onDelete('cascade');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->unique(['clase_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clase_user');
    }
}