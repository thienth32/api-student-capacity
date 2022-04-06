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
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('failed_jobs', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('permissions', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('sponsors', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('majors', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('contests', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('enterprises', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('donors', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('rounds', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('type_exams', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('teams', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('members', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('judges', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('results', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('round_teams', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('exams', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('take_exams', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('judges_rounds', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('evaluations', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('sliders', function (Blueprint $table) {
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
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('evaluations', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('judges_rounds', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('take_exams', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('exams', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('round_teams', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('results', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('judges', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('members', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('teams', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('type_exams', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('rounds', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('donors', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('enterprises', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('contests', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('majors', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('sponsors', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('failed_jobs', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
