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
        Schema::create('judges_rounds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('judge_id');
            $table->unsignedBigInteger('round_id');
            $table->foreign('judge_id')->references('id')->on('judges')->onUpdate('cascade')->onUpdate('cascade');
            $table->foreign('round_id')->references('id')->on('rounds')->onUpdate('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('judges_rounds');
    }
};
