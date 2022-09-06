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
        Schema::table('result_capacity', function (Blueprint $table) {
            $table->integer('donot_answer')->default(0);
            $table->integer('false_answer')->default(0);
            $table->integer('true_answer')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('result_capacity', function (Blueprint $table) {
            $table->dropColumn('donot_answer');
            $table->dropColumn('false_answer');
            $table->dropColumn('true_answer');
        });
    }
};