<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesRotationsUsersPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_rotation_user', function (Blueprint $table) {//2Objection
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('rotation_id');
            $table->unsignedBigInteger('course_id');
            $table->foreign(['rotation_id','course_id'])->references(['rotation_id','course_id'])->on('course_rotation')->onDelete('cascade')->onUpdate('cascade');
            $table->primary(['course_id','user_id','rotation_id'],'courses_objections_ids');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_rotation_user');
    }
}
