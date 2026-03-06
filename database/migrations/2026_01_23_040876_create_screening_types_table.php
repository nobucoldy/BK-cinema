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
        Schema::create('screening_types', function (Blueprint $table) {
            $table->id();
            $table->string('format');     // 2D, 3D, IMAX
            $table->string('language');   // SUB, DUB
            $table->string('label');      // 2D - SUB
            $table->integer('extra_price')->default(0);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('screening_types');
    }
};