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
        Schema::create('credito_tipo', function (Blueprint $table) {
            $table->id();
            $table->string('tipo', 50);
            $table->boolean('habilitado')->default(1);
            $table->timestamps();
        });

        $tipos = [];
        $tipos[] = (object) array('tipo' => 'TIPO_1');
        $tipos[] = (object) array('tipo' => 'TIPO_2');
        $tipos[] = (object) array('tipo' => 'TIPO_3');

        foreach ($tipos as $value) {
            DB::table('credito_tipo')->insert([
                'tipo' => $value->tipo
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('credito_tipo');
        Schema::enableForeignKeyConstraints();
    }
};
