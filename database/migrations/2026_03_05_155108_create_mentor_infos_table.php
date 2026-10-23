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
        Schema::create('mentor_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('mentor_id')->unique();
            $table->integer('location')->comment('theo địa giới hành chính mới');
            $table->string('experience')->comment('kinh nghiệm làm việc');
            $table->string('education')->comment('học vấn');
            $table->string('position')->comment('vị trí công tác hiện tại');
            $table->text('note')->nullable()->comment('mô tả chi tiết');
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
        Schema::dropIfExists('mentor_infos');
    }
};
