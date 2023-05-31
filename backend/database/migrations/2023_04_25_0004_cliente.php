<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $this->down();

        schema::create('cliente', function (Blueprint $table) {

            $table->id();
            $table->string('dni', 8);
            $table->string('apellido_paterno', 50);
            $table->string('apellido_materno', 50);
            $table->string('nombres', 100);
            $table->date('fecha_nacimiento');
            $table->string('estado_civil', 50);
            $table->char('genero', 1);
            $table->string('email', 100)->nullable();
            $table->integer('expediente')->nullable();
            $table->unsignedBigInteger('asesor_id')->nullable();
            $table->unsignedBigInteger('agencia_id')->nullable();
            $table->string('direccion', 500);
            $table->unsignedBigInteger('departamento_id')->nullable();
            $table->unsignedBigInteger('provincia_id')->nullable();
            $table->unsignedBigInteger('distrito_id')->nullable();
            $table->string('referencia_direccion', 500);
            $table->longText('telefonos')->nullable();
            $table->string('imagen_dni', 50)->nullable();
            $table->string('notas', 500)->nullable();

            $table->longText('datos_creacion')->nullable();
            $table->longText('datos_actualizacion')->nullable();
            $table->timestamps();

            $table->foreign('agencia_id')->references('id')->on('agencia');
            $table->foreign('asesor_id')->references('id')->on('usuario');
            $table->foreign('departamento_id')->references('id')->on('departamento');
            $table->foreign('provincia_id')->references('id')->on('provincia');
            $table->foreign('distrito_id')->references('id')->on('distrito');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('cliente');
        Schema::enableForeignKeyConstraints();
    }
};
