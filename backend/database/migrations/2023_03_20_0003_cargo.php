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
        Schema::create('cargo', function (Blueprint $table) {
            $table->id();
            $table->string('cargo', 50);
            $table->boolean('habilitado')->default(1);
            $table->longText('datos_creacion')->nullable();
            $table->longText('datos_actualizacion')->nullable();
            $table->timestamps();
        });

        $cargos = [];
        $cargos[] = (object) array('cargo' => 'ASESOR DE NEGOCIOS', 'habilitado' => 1);
        $cargos[] = (object) array('cargo' => 'JEFE DE CRÉDITOS', 'habilitado' => 1);
        $cargos[] = (object) array('cargo' => 'AUXILIAR DE OPERACIONES', 'habilitado' => 1);
        $cargos[] = (object) array('cargo' => 'JEFE DE OPERACIONES', 'habilitado' => 1);
        $cargos[] = (object) array('cargo' => 'GERENTE DE CRÉDITOS', 'habilitado' => 1);
        $cargos[] = (object) array('cargo' => 'GERENTE DE OPERACIONES', 'habilitado' => 1);
        $cargos[] = (object) array('cargo' => 'JEFE DE TECNOLOGÍAS DE LA INFORMACIÓN', 'habilitado' => 1);
        $cargos[] = (object) array('cargo' => 'ASISTENTE DE CRÉDITOS', 'habilitado' => 1);

        foreach ($cargos as $value) {
            DB::table('cargo')->insert([
                'cargo' => $value->cargo,
                'habilitado' => $value->habilitado
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('cargo');
        Schema::enableForeignKeyConstraints();
    }
};
