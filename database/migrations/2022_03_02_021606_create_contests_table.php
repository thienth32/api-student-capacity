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
        Schema::create('contests', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('img', 255);
            $table->datetime('date_start');
            $table->datetime('register_deadline');
            $table->text('description');
            $table->unsignedInteger('major_id');
            $table->boolean('status')->default(true);
            $table->foreign('major_id')->references('id')->on('majors')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('contests');
    }
};
