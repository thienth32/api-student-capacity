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
        Schema::table('results', function (Blueprint $table) {
            $table->dropForeign('results_team_id_foreign');
            $table->dropForeign('results_round_id_foreign');
            $table->dropColumn('team_id');
            $table->dropColumn('round_id');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('results', function (Blueprint $table) {
            $table->unsignedBigInteger('team_id');
            $table->unsignedBigInteger('round_id');
            $table->foreign('team_id')->references('id')->on('teams')->onUpdate('cascade')->onUpdate('cascade');
            $table->foreign('round_id')->references('id')->on('rounds')->onUpdate('cascade')->onUpdate('cascade');
        });
    }
};
