<?php

// database/migrations/xxxx_xx_xx_xxxxxx_add_columns_to_animes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToAnimesTable extends Migration
{
    public function up()
    {
        Schema::table('animes', function (Blueprint $table) {
            $table->boolean('airing')->nullable()->default(true); // Aggiungi il campo 'airing'
            $table->string('rating')->nullable(); // Aggiungi il campo 'rating'
            $table->float('score', 8, 2)->nullable(); // Aggiungi il campo 'score'
            $table->year('year')->nullable(); // Aggiungi il campo 'year'
        });
    }

    public function down()
    {
        Schema::table('animes', function (Blueprint $table) {
            $table->dropColumn(['airing', 'rating', 'score', 'year']);
        });
    }
}
