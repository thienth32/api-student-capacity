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
        Schema::table('rounds', function (Blueprint $table) {

            $table->integer('max_questions_exam')->nullable();
            $table->integer('time_exam')->nullable();
            $table->integer('time_type_exam')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rounds', function (Blueprint $table) {
            $table->dropColumn('max_questions_exam');
            $table->dropColumn('time_exam');
            $table->dropColumn('time_type_exam');
        });
    }
};