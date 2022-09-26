<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObjectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objections', function (Blueprint $table) {
            $table->date('date');
            $table->time('time');
            $table->string('type');
            $table->date('suggest_date');
            $table->time('suggest_time');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('course_room_user')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('rotation_id');
            $table->foreign('rotation_id')->references('id')->on('rotations')->onDelete('cascade')->onUpdate('cascade');
            $table->primary(['user_id','date','time','rotation_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('objections');
    }
}
