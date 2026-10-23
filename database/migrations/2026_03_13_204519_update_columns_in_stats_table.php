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
        Schema::table('stats', function (Blueprint $table) {
            $table->dropColumn('value');
            $table->dropColumn('unit');
            $table->renameColumn('status', 'type');
            $table->json('data');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stats', function (Blueprint $table) {
            $table->integer('value');
            $table->string('unit');
            $table->renameColumn('type', 'status');
            $table->dropColumn('data');
        });
    }
};
