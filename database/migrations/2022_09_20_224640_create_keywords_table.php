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
        Schema::create('keywords', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('keyword');
            $table->string('keyword_en');
            $table->string('keyword_slug');
            $table->integer('type')->default(0)->comment('0 là key thuộc bài viết , 1 là thuộc tuyển dụng , 2 là thuông test năng lực ');
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('keywords');
    }
};
