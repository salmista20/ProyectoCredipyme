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
        Schema::create('agencia', function (Blueprint $table) {
            $table->id();
            $table->string('agencia', 50);
            $table->string('direccion', 200);
        });

        $agencias = [];
        $agencias[] = (object) array('agencia' => 'ADMINISTRATIVA', 'direccion' => 'JR. CUARZO 125');
        $agencias[] = (object) array('agencia' => 'HUANCAYO', 'direccion' => 'PROLG. HUANUCO 317');
        $agencias[] = (object) array('agencia' => 'EL TAMBO', 'direccion' => 'JR. PARRA DEL RIEGO 655');
        $agencias[] = (object) array('agencia' => 'CHILCA', 'direccion' => 'JR. AUGUSTO B. LEGUIA 787');
        $agencias[] = (object) array('agencia' => 'PAMPAS', 'direccion' => 'JR. LIMA 145');
        $agencias[] = (object) array('agencia' => 'HUANCAVELICA', 'direccion' => 'JR. AGUSTIN GAMARRA 240');

        foreach ($agencias as $value) {
            DB::table('agencia')->insert([
                'agencia' => $value->agencia,
                'direccion' => $value->direccion
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('agencia');
        Schema::enableForeignKeyConstraints();
    }
};
