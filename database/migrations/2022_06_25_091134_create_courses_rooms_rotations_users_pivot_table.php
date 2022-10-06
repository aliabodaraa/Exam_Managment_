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
        Schema::create('course_room_rotation_user', function (Blueprint $table) {//3
            $table->string('roleIn');
            $table->unsignedBigInteger('rotation_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('room_id');
            $table->foreign(['rotation_id','course_id','room_id'])->references(['rotation_id','course_id','room_id'])->on('course_room_rotation')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->primary(['rotation_id','course_id','room_id','user_id'],'assign_users_in_rooms');
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
