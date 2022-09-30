<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesRoomsRotationsUsersPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_room_rotation_user', function (Blueprint $table) {
            $table->date('date');
            $table->time('time');
            $table->string('roleIn');
            $table->unsignedBigInteger('num_student_in_room');//->default(100);
            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('room_id');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('rotation_id');
            $table->foreign('rotation_id')->references('id')->on('rotations')->onDelete('cascade')->onUpdate('cascade');
            //$table->unique(['rotation_id','course_id']);//??
            $table->primary(['course_id','room_id','user_id','rotation_id'], 'my_long_table_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_room_rotation_user');
    }
}