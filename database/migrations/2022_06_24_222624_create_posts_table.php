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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->longText('content')->nullable();
            $table->longText('description')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->integer('postable_id')->nullable();
            $table->string('postable_type')->nullable();
            $table->string('external_link')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->string('link_to')->nullable();
            $table->integer('status')->default(1);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('posts');
    }
};
