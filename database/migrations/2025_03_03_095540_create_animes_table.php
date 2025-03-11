<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('animes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mal_id')->unique();
            $table->string('title');
            $table->text('synopsis')->nullable();
            $table->string('image_url')->nullable();
            $table->integer('episodes')->nullable();
            $table->string('status')->nullable();
            $table->boolean('airing')->nullable();
            $table->string('rating')->nullable();
            $table->float('score')->nullable();
            $table->integer('year')->nullable();
            $table->json('genres')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animes');
    }
};
