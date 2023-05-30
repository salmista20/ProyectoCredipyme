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
            $table->string('descripcion', 200)->default('')->nullable();
            $table->boolean('habilitado')->default(1);
            $table->timestamps();
        });
        $categorias = [];
             $categorias[] = (object) array('categoria' => 'CATEGORIA_1', 'descripcion' => 'DESCRIPCION_1');
             $categorias[] = (object) array('categoria' => 'CATEGORIA_2', 'descripcion' => 'DESCRIPCION_2');

        foreach ($categorias as $value) {
            DB::table('credito_categoria')->insert([
                'categoria' => $value->categoria, 
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
        Schema::dropIfExists('credito_categoria');
        Schema::enableForeignKeyConstraints();
    }
};
