<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('att1_id')->constrained('players');
            $table->foreignId('dif1_id')->constrained('players');
            $table->foreignId('att2_id')->constrained('players');
            $table->foreignId('dif2_id')->constrained('players');
            $table->integer('deltaa1');
            $table->integer('deltad1');
            $table->integer('deltaa2');
            $table->integer('deltad2');
            $table->integer('pt1');
            $table->integer('pt2');
            $table->boolean('hidden');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
