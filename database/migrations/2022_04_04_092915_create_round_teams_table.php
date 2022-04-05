<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('round_teams', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('team_id');
            $table->unsignedBigInteger('round_id');
            $table->foreign('team_id')->references('id')->on('teams')->onUpdate('cascade')->onUpdate('cascade');
            $table->foreign('round_id')->references('id')->on('rounds')->onUpdate('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('round_teams');
    }
};
