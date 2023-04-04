<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->down();
        Schema::create('rol', function (Blueprint $table) {
            $table->id();
            $table->string('rol', 50);
            $table->longText('datos_creacion')->nullable();
            $table->longText('datos_actualizacion')->nullable();
            $table->timestamps();
        });

        $roles = [];
        $roles[] = (object) array('rol' => 'ADMINISTRADOR');
        $roles[] = (object) array('rol' => 'USUARIO');

        foreach ($roles as $value) {
            DB::table('rol')->insert([
                'rol' => $value->rol
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('rol');
        Schema::enableForeignKeyConstraints();
    }
};
