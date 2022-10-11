<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['namespace' => 'App\Http\Controllers'], function()
{
    /**
     * Home Routes
     */
    Route::get('/', 'HomeController@index')->name('home.index');

    Route::group(['middleware' => ['guest']], function() {
        /**
         * Login Routes
         */
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login.perform');

    });

    Route::group(['middleware' => ['auth']], function() {
            /**
             * Logout Routes
             */
            Route::get('/logout', 'LogoutController@perform')->name('logout.perform');

            /**
             * User Routes
             */
            Route::group(['prefix' => 'users'], function() {
                Route::get('/', 'UsersController@index')->name('users.index');
                Route::get('/create', 'UsersController@create')->name('users.create');
                Route::post('/create', 'UsersController@store')->name('users.store');
                Route::get('/{user}/show', 'UsersController@show')->name('users.show');
                Route::get('/{user}/observations', 'UsersController@observations')->name('users.observations');
                Route::get('/{user}/edit', 'UsersController@edit')->name('users.edit');
                Route::patch('/{user}/update', 'UsersController@update')->name('users.update');
                Route::delete('/{user}/delete', 'UsersController@destroy')->name('users.destroy');
                Route::patch('/{user}/isActive', 'UsersController@isActive')->name('users.isActive');
                Route::get('/{user}/profile', 'UsersController@profile')->name('users.profile');
            });

            /**
             * Course Routes
             */
            Route::group(['prefix' => 'courses'], function() {
                Route::get('/', 'CoursesController@index')->name('courses.index');
                Route::get('/create', 'CoursesController@create')->name('courses.create');
                Route::post('/create', 'CoursesController@store')->name('courses.store');
                Route::delete('/{course}/delete', 'CoursesController@destroy')->name('courses.destroy');

            });

            /**
             * Room Routes
             */
            Route::group(['prefix' => 'rooms'], function() {
                Route::get('/index', 'RoomsController@index')->name('rooms.index');
                Route::get('/create', 'RoomsController@create')->name('rooms.create');
                Route::post('/create', 'RoomsController@store')->name('rooms.store');
                Route::get('/{room}/edit', 'RoomsController@edit')->name('rooms.edit');
                Route::patch('/{room}/update', 'RoomsController@update')->name('rooms.update');
                Route::get('/{room}/show', 'RoomsController@show')->name('rooms.show');
                Route::delete('/{room}/delete', 'RoomsController@destroy')->name('rooms.destroy');
                Route::patch('/{room}/isActive', 'RoomsController@isActive')->name('rooms.isActive');
            });
            
            /**
             * Rotation Routes
             */
            Route::group(['prefix' => 'rotations'], function() {
                //Rotation CURD
                Route::get('/index', 'RotationsController@index')->name('rotations.index');
                Route::get('/create', 'RotationsController@create')->name('rotations.create');
                Route::post('/create', 'RotationsController@store')->name('rotations.store');
                Route::get('/{rotation}/edit', 'RotationsController@edit')->name('rotations.edit');
                Route::patch('/{rotation}/update', 'RotationsController@update')->name('rotations.update');
                Route::delete('/{rotation}/delete', 'RotationsController@destroy')->name('rotations.destroy');
                //Rotation CURD
                //Rotation ExamProgram
                Route::get('/{rotation}/show', 'CourseRotation_ExamProgramController@show')->name('rotations.program.show');
                Route::get('/{rotation}/create', 'CourseRotation_ExamProgramController@add_course_to_the_program')->name('rotations.program.add_course_to_the_program');
                Route::post('/{rotation}/store', 'CourseRotation_ExamProgramController@store_course_to_the_program')->name('rotations.program.store_course_to_the_program');
                Route::get('/{rotation}/course/{course}/delete_course_from_program', 'CourseRotation_ExamProgramController@delete_course_from_program')->name('rotations.course.delete_course_from_program');
                //Rotation ExamProgram
                //Rotation Objections
                Route::get('/{rotation}/objections/create', 'CourseRotationUser_ObjectionController@create')->name('rotations.objections.create');
                Route::post('/{rotation}/objections/create', 'CourseRotationUser_ObjectionController@store')->name('rotations.objections.store');
                Route::get('/{rotation}/objections/edit', 'CourseRotationUser_ObjectionController@edit')->name('rotations.objections.edit');
                Route::patch('/{rotation}/objections/update', 'CourseRotationUser_ObjectionController@update')->name('rotations.objections.update');
                //Rotation Objections
                //Distribute Students && Members of Faculty
                Route::post('/{rotation}/distributeStudents', 'RotationsController@distributeStudents')->name('rotations.distributeStudents');
                Route::post('/{rotation}/distributeMembersOfFaculty', 'RotationsController@distributeMembersOfFaculty')->name('rotations.distributeMembersOfFaculty');
            });
                        
            /**
             * Course with Rotation Routes
             */
            Route::group(['prefix' => 'rotations'], function() {
                Route::get('/{rotation}/course/{course}/room/{specific_room}', 'CourseRotationController@get_room_for_course')->name('rotations.get_room_for_course');
                Route::patch('/{rotation}/course/{course}/room/{specific_room}', 'CourseRotationController@customize_room_for_course')->name('rotations.customize_room_for_course');
                Route::get('/{rotation}/course/{course}/show', 'CourseRotationController@show')->name('rotations.course.show');
                Route::get('/{rotation}/course/{course}/edit', 'CourseRotationController@edit')->name('rotations.course.edit');
                Route::patch('/{rotation}/course/{course}/update', 'CourseRotationController@update')->name('rotations.course.update');
            });
        });
    });



//Livewires
     Route::get('/search', \App\Http\Livewire\Search::class)->name('search');