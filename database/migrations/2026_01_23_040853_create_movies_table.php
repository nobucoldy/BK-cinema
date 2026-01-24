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
        Schema::create('movies', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('description')->nullable();
    $table->string('genre')->nullable();
    $table->integer('duration'); // phút
    $table->date('release_date')->nullable();
    $table->integer('base_price')->default(60000);
    $table->string('poster_url')->nullable();
    $table->string('trailer_url')->nullable();
    $table->string('movie_backdrop')->nullable();
    $table->enum('status', ['showing', 'coming_soon', 'stopped'])->default('coming_soon');

    $table->unsignedBigInteger('director_id')->nullable();
    $table->foreign('director_id')
          ->references('id')
          ->on('directors')
          ->onDelete('set null');

    $table->timestamps();
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};