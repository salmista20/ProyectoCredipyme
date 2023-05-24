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
        Schema::create('credito_producto', function (Blueprint $table) {
            $table->id();
            $table->string('producto', 50);
            $table->boolean('habilitado')->default(1);
            $table->timestamps();
        });

        $productos = [];
        $productos[] = (object) array('producto' => 'PRODUCTO_1');
        $productos[] = (object) array('producto' => 'PRODUCTO_2');

        foreach ($productos as $value) {
            DB::table('credito_producto')->insert([
                'producto' => $value->producto
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('credito_producto');
        Schema::enableForeignKeyConstraints();
    }
};
