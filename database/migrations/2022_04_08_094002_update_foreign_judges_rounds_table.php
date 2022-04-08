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
        Schema::table('judges_rounds', function (Blueprint $table) {
            $table->dropForeign('judges_rounds_judge_id_foreign');
            $table->dropForeign('judges_rounds_round_id_foreign');
            $table->foreign('judge_id')->references('id')->on('judges')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('round_id')->references('id')->on('rounds')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('judges_rounds', function (Blueprint $table) {
            $table->foreign('judge_id')->references('id')->on('judges')->onUpdate('cascade')->onUpdate('cascade');
            $table->foreign('round_id')->references('id')->on('rounds')->onUpdate('cascade')->onUpdate('cascade');
        });
    }
};
