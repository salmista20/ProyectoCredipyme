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
        Schema::create('credito_subcategoria', function (Blueprint $table) {
            $table->id();
            $table->string('subcategoria', 50);
            $table->string('descripcion', 200);
            $table->bigInteger('categoria_id');
            $table->tinyint('habilitado')->default(1);
            $table->timestamps();
        });

        $subcategorias = [];
        $subcategorias[] = (object) array('subcategoria' => 'SUBCATEGORIA_1');
        $subcategorias[] = (object) array('subcategoria' => 'SUBCATEGORIA_2');
        
        foreach ($subcategorias as $value) {
            DB::table('credito_subcategoria')->insert([
                'subcategoria' => $value->subcategoria
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('credito_subcategorias');
        Schema::enableForeignKeyConstraints();
    }
};
