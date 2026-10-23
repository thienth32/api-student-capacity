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
            $table->unsignedInteger('created_by');
            $table->string('thumbnail');
            $table->integer('status');
            $table->datetime('start_at');
            $table->datetime('end_at');
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
            $table->dropColumn('created_by');
            $table->dropColumn('thumbnail');
            $table->dropColumn('status');
            $table->dropColumn('start_at');
            $table->dropColumn('end_at');
        });
    }
};
