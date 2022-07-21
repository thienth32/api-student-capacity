<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultCapacityDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('result_capacity_detail', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('result_capacity_id');
            $table->foreign('result_capacity_id')->references('id')->on('result_capacity')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('question_id')->nullable();
            $table->integer('answer_id')->nullable();
            $table->longText('code_onl')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('result_capacity_detail');
    }
}