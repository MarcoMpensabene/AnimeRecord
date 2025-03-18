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
        Schema::create('anime_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->foreignId('anime_id')->constrained('animes')->onDelete('cascade');
            $table->enum('status', ['watching', 'completed', 'plan_to_watch', 'dropped'])->default('plan_to_watch');
            $table->integer('episodes_watched')->default(0);
            $table->integer('rating')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Ensure a profile can only have one record per anime
            $table->unique(['profile_id', 'anime_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anime_records');
    }
};