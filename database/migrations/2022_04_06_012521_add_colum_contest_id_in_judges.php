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
        Schema::table('judges', function (Blueprint $table) {
            $table->bigInteger('contest_id')->unsigned()->nullable();
            $table->foreign('contest_id')->references('id')->on('contests')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('judges', function (Blueprint $table) {
        });
    }
};
