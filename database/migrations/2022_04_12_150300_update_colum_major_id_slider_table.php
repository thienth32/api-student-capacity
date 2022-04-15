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
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropForeign('sliders_major_id_foreign');
            $table->dropColumn('major_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->unsignedInteger('major_id');
            $table->foreign('major_id')->references('id')->on('majors')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }
};
