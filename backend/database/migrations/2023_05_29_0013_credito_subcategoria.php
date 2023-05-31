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
            $table->string('descripcion', 200)->default('')->nullable();
            $table->unsignedBigInteger('categoria_id');
            $table->boolean('habilitado')->default(1);
            $table->timestamps();

            $table->foreign('categoria.id')->references('id')->on('credito_categoria');
        });
        $subcategorias = [];
             $subcategorias[] = (object) array('subcategoria' => 'CATEGORIA_1', 'descripcion' => 'DESCRIPCION_1');
             $subcategorias[] = (object) array('subcategoria' => 'CATEGORIA_2', 'descripcion' => 'DESCRIPCION_2');

        foreach ($subcategorias as $value) {
            DB::table('credito_subcategoria')->insert([
                'subcategoria' => $value->subcategoria, 
                'descripcion' => $value->descripcion,
                'habilitado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('credito_subcategoria');
        Schema::enableForeignKeyConstraints();
    }
};
