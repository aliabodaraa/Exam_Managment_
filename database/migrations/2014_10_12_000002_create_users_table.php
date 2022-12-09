<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('number_of_observation')->default(8);
            $table->string('role')->nullable(true);
            $table->string('temporary_role')->nullable(true);
            $table->string('city')->default("اللاذفية");
            $table->integer('is_active')->default(1);
            $table->string('property')->nullable();//  7/12/2022
            $table->unsignedBigInteger('department_id')->nullable(true);//for does not miss importing data
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('faculty_id');//->nullable(true);//for does not miss importing data
            $table->foreign('faculty_id')->references('id')->on('faculties')->onDelete('cascade')->onUpdate('cascade');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
