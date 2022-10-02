<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesRotationsPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_rotation', function (Blueprint $table) {//1
            $table->date('date');
            $table->time('time');
            $table->bigInteger('students_number');
            $table->string('duration',5)->default("1:30");
            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('rotation_id');
            $table->foreign('rotation_id')->references('id')->on('rotations')->onDelete('cascade')->onUpdate('cascade');
            $table->primary(['course_id','rotation_id'],'insert_courses_into_program');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_rotation');
    }
}
