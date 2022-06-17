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
        Schema::create('contest_recruitments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('contest_id')->nullable();
            $table->unsignedBigInteger('recruitment_id')->nullable();
            $table->foreign('contest_id')->references('id')->on('contests')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('recruitment_id')->references('id')->on('recruitments')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('contest_recruitments');
    }
};
