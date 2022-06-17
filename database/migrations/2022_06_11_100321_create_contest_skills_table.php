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
        Schema::create('contest_skills', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('contest_id')->nullable();
            $table->unsignedBigInteger('skill_id')->nullable();
            $table->foreign('contest_id')->references('id')->on('contests')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('skill_id')->references('id')->on('skills')->onUpdate('cascade')->onDelete('cascade');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contest_skills');
    }
};
