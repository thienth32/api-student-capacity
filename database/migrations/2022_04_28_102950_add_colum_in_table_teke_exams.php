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
            $table->longText('result_url')->nullable();
            $table->integer('final_point')->nullable();
            $table->string('mark_comment')->nullable();
            $table->string('status')->default(1)->comment('0 là hủy bài , 1 là đang làm , 2 là đã nộp  bài');
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
            $table->dropColumn('status');
            $table->dropColumn('mark_comment');
            $table->dropColumn('final_point');
            $table->dropColumn('result_url');
        });
    }
};