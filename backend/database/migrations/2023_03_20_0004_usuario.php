<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->down();
        Schema::create('usuario', function (Blueprint $table) {
            $table->id();
            $table->string('usuario', 20);
            $table->string('clave', 50);
            $table->string('apellido_paterno', 50);
            $table->string('apellido_materno', 50);
            $table->string('nombres', 50);
            $table->string('dni', 10);
            $table->unsignedBigInteger('rol_id');
            $table->unsignedBigInteger('cargo_id');
            $table->unsignedBigInteger('agencia_id');
            $table->boolean('habilitado')->default(1);
            $table->longText('datos_creacion')->nullable();
            $table->longText('datos_actualizacion')->nullable();
            $table->timestamps();

            $table->foreign('rol_id')->references('id')->on('rol');
            $table->foreign('cargo_id')->references('id')->on('cargo');
            $table->foreign('agencia_id')->references('id')->on('agencia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('usuario');
        Schema::enableForeignKeyConstraints();
    }
};
