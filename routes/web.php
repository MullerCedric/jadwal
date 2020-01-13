<?php

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


Auth::routes();

// Confirm box
require 'web/confirm-box.php';

// Preferences
require 'web/preferences.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/', [
        'as' => 'dashboard',
        'uses' => 'ExamSessionController@index'
    ])->middleware('createIfEmpty:exam_sessions');

    // Exam Sessions
    require 'web/exam_sessions.php';

    // Locations
    require 'web/locations.php';

    // Messages
    require 'web/messages.php';

    // Teachers
    require 'web/teachers.php';

    // Users
    Route::get('/users/fetchToken', [
        'as' => 'user.fetchApiToken',
        'uses' => 'UserController@fetchApiToken'
    ]);
});
