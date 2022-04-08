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
        Schema::table('take_exams', function (Blueprint $table) {
            $table->dropForeign('take_exams_round_team_id_foreign');
            $table->foreign('round_team_id')->references('id')->on('round_teams')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('take_exams', function (Blueprint $table) {
            $table->foreign('round_team_id')->references('id')->on('round_teams')->onUpdate('cascade')->onUpdate('cascade');
        });
    }
};
