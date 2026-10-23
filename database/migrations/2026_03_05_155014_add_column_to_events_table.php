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
        Schema::table('events', function (Blueprint $table) {
            $table->string('register_link')->nullable();
            $table->integer('interview_count')->comment('số lượt sinh viên phỏng vấn');
            $table->integer('jobs_opening_count')->comment('số vị trí tuyển dụng');
            $table->text('note')->comment('hiển thị ở mục thư ngỏ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('register_link');
            $table->dropColumn('interview_count');
            $table->dropColumn('jobs_opening_count');
            $table->dropColumn('note');
        });
    }
};
