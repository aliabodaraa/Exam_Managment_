<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesRoomsRotationsPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_room_rotation', function (Blueprint $table) {//2
            $table->unsignedBigInteger('num_student_in_room');
            //$table->foreign('course_id')->references('course_id')->on('course_rotation')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('room_id');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('rotation_id');
            $table->unsignedBigInteger('course_id');
            //$table->foreign('rotation_id')->references('rotation_id')->on('course_rotation')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign(['rotation_id','course_id'])->references(['rotation_id','course_id'])->on('course_rotation')->onDelete('cascade')->onUpdate('cascade');
            $table->primary(['course_id','room_id','rotation_id'],'distribution_of_students_to_the_rooms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_room_rotation');
    }
}
