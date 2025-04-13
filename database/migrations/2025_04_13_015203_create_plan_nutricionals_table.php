<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanNutricionalsTable extends Migration
{
    public function up(): void
    {
        Schema::create('plan_nutricionals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->integer('calorias_diarias')->nullable();
            $table->text('recomendaciones')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('plan_nutricionals');
    }
}
