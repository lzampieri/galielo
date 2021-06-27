<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCcupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ccups', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('pl1_id')->constrained('players');
            $table->foreignId('pl2_id')->constrained('players');
            $table->foreignId('game1')->constrained('games');
            $table->foreignId('game2')->constrained('games');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ccups');
    }
}
