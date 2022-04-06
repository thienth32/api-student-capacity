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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('ponit');
            $table->unsignedBigInteger('exams_team_id');
            $table->unsignedBigInteger('judges_id');
            $table->foreign('exams_team_id')->references('id')->on('take_exams')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('judges_id')->references('id')->on('judges')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluations');
    }
};
