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
        Schema::table('enterprises', function (Blueprint $table) {
            $table->string('tax_number');
            $table->string('contact_name');
            $table->string('contact_phone');
            $table->string('contact_email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enterprises', function (Blueprint $table) {
            $table->dropColumn('contact_email');
            $table->dropColumn('contact_phone');
            $table->dropColumn('contact_name');
            $table->dropColumn('tax_number');
        });
    }
};
