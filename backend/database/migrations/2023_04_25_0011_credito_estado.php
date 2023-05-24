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

        Schema::create('credito_estado', function (Blueprint $table) {
            $table->id();
            $table->string('estado', 50);
            $table->boolean('habilitado')->default(1);
            $table->timestamps(); //created_at updated_at
        });

        //Llenar datos
        $estados = [];
        $estados[] = (object) array('estado' => 'SOLICITADO');
        $estados[] = (object) array('estado' => 'APROBADO');
        $estados[] = (object) array('estado' => 'DENEGADO');

        foreach ($estados as $value) {
            DB::table('credito_estado')->insert([
                'estado' => $value->estado
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('credito_estado');
        Schema::enableForeignKeyConstraints();
    }
};
