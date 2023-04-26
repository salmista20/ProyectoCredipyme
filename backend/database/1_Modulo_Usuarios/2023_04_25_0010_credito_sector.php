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
        Schema::create('credito_sector', function (Blueprint $table) {
            $table->id();
            $table->string('sector', 50);
            $table->boolean('habilitado')->default(1);
            $table->timestamps();
        });

        $sectores = [];
        $sectores[] = (object) array('sector' => 'SECTOR_1');
        $sectores[] = (object) array('sector' => 'SECTOR_2');

        foreach ($sectores as $value) {
            DB::table('credito_sector')->insert([
                'sector' => $value->sector
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('credito_sector');
        Schema::enableForeignKeyConstraints();
    }
};
