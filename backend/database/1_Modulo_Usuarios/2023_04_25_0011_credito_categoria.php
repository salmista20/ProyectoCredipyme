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
        Schema::create('credito_categoria', function (Blueprint $table) {
            $table->id();
            $table->string('categoria', 50);
            $table->string('descripcion', 200);
            $table->tinyint('habilitado')->default(1);
            $table->timestamps();
        });

        $categorias = [];
        $categorias[] = (object) array('categoria' => 'CATEGORIA_1');
        $categorias[] = (object) array('categoria' => 'CATEGORIA_2');
        
        foreach ($categorias as $value) {
            DB::table('credito_categoria')->insert([
                'categoria' => $value->categoria
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('credito_categorias');
        Schema::enableForeignKeyConstraints();
    }
};
