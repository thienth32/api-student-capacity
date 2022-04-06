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
        Schema::create('major_skills', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedInteger('major_id');
            $table->foreign('major_id')->references('id')->on('majors')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->bigInteger('skill_id')->unsigned()->nullable();
            $table->foreign('skill_id')->references('id')->on('skills')->onDelete('cascade');
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
        Schema::dropIfExists('major_skills');
    }
};
