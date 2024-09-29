<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string("nombres", 50);
            $table->string("apellidos", 50);
            $table->date("fecha_nac")->nullable();
            $table->boolean("estado")->default(true);
            $table->bigInteger("user_id")->unsigned();
            $table->foreign("user_id")->references("id")->on("users");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
