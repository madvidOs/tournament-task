<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayoffGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('playoff_games', function (Blueprint $table) {
            $table->id();
            $table->integer('id_team1');
            $table->integer('id_team2');
            $table->integer('goal_team1');
            $table->integer('goal_team2');
            $table->integer('id_group');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('playoff_games');
    }
}
