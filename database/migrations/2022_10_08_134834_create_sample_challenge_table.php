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
        Schema::create('sample_challenge', function (Blueprint $table) {
            $table->id();
            $table->longText('code');
            $table->unsignedBigInteger('challenge_id');
            $table->unsignedBigInteger('code_language_id');
            $table->foreign('challenge_id')->references('id')->on('challenges')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('code_language_id')->references('id')->on('code_language')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sample_challenge');
    }
};