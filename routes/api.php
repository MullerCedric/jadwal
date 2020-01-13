<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function () {
    // Draft Exam Sessions
    Route::post('/draft_exam_sessions', [
        'as' => 'api.draft_exam_sessions.store',
        'uses' => 'Api\DraftExamSessionController@store'
    ]);

// Draft Messages
    Route::post('/draft_messages', [
        'as' => 'api.draft_messages.store',
        'uses' => 'Api\DraftMessageController@store'
    ]);

// Draft Preferences
    Route::post('/draft_preferences', [
        'as' => 'api.draft_preferences.store',
        'uses' => 'Api\DraftPreferenceController@store'
    ]);
});
