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
        Schema::table('sponsors', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('logo');
            $table->integer('event_id');
            $table->integer('sponsor_id');
            $table->unique(['event_id', 'sponsor_id'], 'sponsor_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sponsors', function (Blueprint $table) {
            $table->string('name');
            $table->string('logo');
            $table->dropUnique('sponsor_unique');
            $table->dropColumn('event_id');
            $table->dropColumn('sponsor_id');
        });
    }
};
