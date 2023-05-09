<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->down();
        Schema::create('permiso', function (Blueprint $table) {
            $table->id();
            $table->string('modulo', 50);
            $table->string('submodulo', 50);
            $table->longText('datos_creacion')->nullable();
            $table->longText('datos_actualizacion')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('permiso');
        Schema::enableForeignKeyConstraints();
    }
};
