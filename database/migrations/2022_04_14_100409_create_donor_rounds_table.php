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
        Schema::create('donor_rounds', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('round_id')->unsigned()->nullable();
            $table->foreign('round_id')->references('id')->on('rounds')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('donor_id')->unsigned()->nullable();
            $table->foreign('donor_id')->references('id')->on('donors')->onUpdate('cascade')->onDelete('cascade');
            $table->softDeletes();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donor_rounds');
    }
};
