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
    Schema::create('seats', function (Blueprint $table) {
    $table->id();
    $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
    $table->string('seat_code');
    $table->enum('seat_type', ['normal', 'vip','couple'])->default('normal');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};