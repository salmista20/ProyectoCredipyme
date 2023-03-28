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
        Schema::create('agencia', function (Blueprint $table) {
            $table->id();
            $table->string('agencia', 50);
            $table->string('direccion', 200);
        });
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
