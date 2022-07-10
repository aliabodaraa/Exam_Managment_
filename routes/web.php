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
                Route::get('/{user}/edit', 'UsersController@edit')->name('users.edit');
                Route::patch('/{user}/update', 'UsersController@update')->name('users.update');
                Route::delete('/{user}/delete', 'UsersController@destroy')->name('users.destroy');
            });

            /**
             * Course Routes
             */
            Route::group(['prefix' => 'courses'], function() {
                Route::get('/index', 'CoursesController@index')->name('courses.index');
                Route::get('/create', 'CoursesController@create')->name('courses.create');
                Route::post('/create', 'CoursesController@store')->name('courses.store');
                Route::get('/{course}/edit', 'CoursesController@edit')->name('courses.edit');
                Route::patch('/{course}/update', 'CoursesController@update')->name('courses.update');
                Route::get('/{course}/show', 'CoursesController@show')->name('courses.show');
                Route::delete('/{course}/delete', 'CoursesController@destroy')->name('courses.destroy');
                Route::get('/{course}/room/{specific_room}', 'CoursesController@get_room_for_course')->name('courses.room_for_course');
                Route::patch('/{course}/room/{specific_room}', 'CoursesController@customize_room_for_course')->name('courses.room_for_course');
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
            });
        });
    });
