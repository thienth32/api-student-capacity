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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('description')->nullable();
            $table->string('logo')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->integer('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('branch_id')->default(0);
        });
        Schema::table('enterprises', function (Blueprint $table) {
            $table->unsignedBigInteger('branch_id')->default(0);
            $table->string('address')->nullable();
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->string('contact_name')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('career_source')->nullable();
            $table->string('career_require')->nullable();
            $table->string('position')->nullable();
            $table->integer('career_type')->default(1);
            $table->unsignedBigInteger('major_id');
            $table->unsignedBigInteger('branch_id')->default(0);
        });
        Schema::table('recruitments', function (Blueprint $table) {
            $table->unsignedBigInteger('branch_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branches');

        Schema::table('recruitments', function (Blueprint $table) {
            $table->dropColumn('branch_id');
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('contact_name');
            $table->dropColumn('contact_phone');
            $table->dropColumn('contact_email');
            $table->dropColumn('career_source');
            $table->dropColumn('career_require');
            $table->dropColumn('position');
            $table->dropColumn('career_type');
            $table->dropColumn('major_id');
            $table->dropColumn('branch_id');
        });
        Schema::table('enterprises', function (Blueprint $table) {
            $table->dropColumn('branch_id');
            $table->dropColumn('address');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('branch_id');
        });
    }
};
