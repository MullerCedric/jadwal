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

// Preferences
Route::get('/preferences/{token}', [
    'as' => 'preferences.index',
    'uses' => 'PreferenceController@index'
])->where(['token' => '\w{5}\d{7}\w{4}']);
Route::get('/preferences/create/{token}/{exam_session}', [
    'as' => 'preferences.create',
    'uses' => 'PreferenceController@create'
])->where(['token' => '\w{5}\d{7}\w{4}', 'exam_session' => '[0-9]+']);
Route::post('/preferences/', [
    'as' => 'preferences.store',
    'uses' => 'PreferenceController@store'
]);
Route::get('/preferences/{preference}/{token?}', [
    'as' => 'preferences.show',
    'uses' => 'PreferenceController@show'
])->where(['preference' => '[0-9]+', 'token' => '\w{5}\d{7}\w{4}']);
Route::get('/preferences/{preference}/edit/{token?}', [
    'as' => 'preferences.edit',
    'uses' => 'PreferenceController@edit'
])->where(['preference' => '[0-9]+', 'token' => '\w{5}\d{7}\w{4}']);
// Draft Preferences
Route::post('/draft_preferences', [
    'as' => 'draft_preferences.store',
    'uses' => 'DraftPreferenceController@store'
]);
// Send Preferences
Route::post('/send_preferences/{preference}/{token?}', [
    'as' => 'send_preferences.send',
    'uses' => 'SendPreferenceController@send'
])->where(['preference' => '[0-9]+', 'token' => '\w{5}\d{7}\w{4}']);

Route::middleware(['auth'])->group(function () {
    Route::get('/', [
        'as' => 'dashboard',
        'uses' => 'ExamSessionController@index'
    ]);

    // Exam Sessions
    Route::get('/exam_sessions', [
        'as' => 'exam_sessions.index',
        'uses' => 'ExamSessionController@index'
    ]);
    Route::get('/exam_sessions/create', [
        'as' => 'exam_sessions.create',
        'uses' => 'ExamSessionController@create'
    ]);
    Route::post('/exam_sessions', [
        'as' => 'exam_sessions.store',
        'uses' => 'ExamSessionController@store'
    ]);
    Route::get('/exam_sessions/{id}', [
        'as' => 'exam_sessions.show',
        'uses' => 'ExamSessionController@show'
    ])->where('id', '[0-9]+');
    Route::get('/exam_sessions/{exam_session}/edit', [
        'as' => 'exam_sessions.edit',
        'uses' => 'ExamSessionController@edit'
    ])->where('exam_session', '[0-9]+');
    // Draft Exam Sessions
    Route::post('/draft_exam_sessions', [
        'as' => 'draft_exam_sessions.store',
        'uses' => 'DraftExamSessionController@store'
    ]);
    // Closed Exam Sessions
    Route::get('/closed_exam_sessions', [
        'as' => 'closed_exam_sessions.index',
        'uses' => 'ClosedExamSessionController@index'
    ]);
    Route::delete('/closed_exam_sessions/{exam_session}', [
        'as' => 'closed_exam_sessions.store',
        'uses' => 'ClosedExamSessionController@store'
    ])->where('exam_session', '[0-9]+');
    Route::delete('/closed_exam_sessions/destroy/{exam_session}', [
        'as' => 'closed_exam_sessions.destroy',
        'uses' => 'ClosedExamSessionController@destroy'
    ])->where('exam_session', '[0-9]+');

    // Locations
    Route::get('/locations', [
        'as' => 'locations.index',
        'uses' => 'LocationController@index'
    ]);
    Route::get('/locations/create', [
        'as' => 'locations.create',
        'uses' => 'LocationController@create'
    ]);
    Route::post('/locations', [
        'as' => 'locations.store',
        'uses' => 'LocationController@store'
    ]);
    Route::get('/locations/{location}', [
        'as' => 'locations.show',
        'uses' => 'LocationController@show'
    ])->where('location', '[0-9]+');
    Route::get('/locations/{location}/edit', [
        'as' => 'locations.edit',
        'uses' => 'LocationController@edit'
    ])->where('location', '[0-9]+');
    Route::put('/locations/{location}', [
        'as' => 'locations.update',
        'uses' => 'LocationController@update'
    ])->where('location', '[0-9]+');
    Route::delete('/locations/{location}', [
        'as' => 'locations.destroy',
        'uses' => 'LocationController@destroy'
    ])->where('location', '[0-9]+');
    // LocationTeacher
    Route::delete('/locationsteachers/{location}', [
        'as' => 'locationsteachers.destroy',
        'uses' => 'LocationTeacherController@destroy'
    ])->where('location', '[0-9]+');

    // Messages
    Route::get('/messages', [
        'as' => 'messages.index',
        'uses' => 'MessageController@index'
    ]);
    Route::get('/messages/create', [
        'as' => 'messages.create',
        'uses' => 'MessageController@create'
    ]);
    Route::post('/messages', [
        'as' => 'messages.store',
        'uses' => 'MessageController@store'
    ]);
    Route::get('/messages/{message}', [
        'as' => 'messages.show',
        'uses' => 'MessageController@show'
    ])->where('message', '[0-9]+');
    Route::get('/messages/{message}/edit', [
        'as' => 'messages.edit',
        'uses' => 'MessageController@edit'
    ])->where('message', '[0-9]+');
    Route::delete('/messages/{message}', [
        'as' => 'messages.destroy',
        'uses' => 'MessageController@destroy'
    ])->where('message', '[0-9]+');
    // Draft Messages
    Route::post('/draft_messages', [
        'as' => 'draft_messages.store',
        'uses' => 'DraftMessageController@store'
    ]);
    // Send Messages
    Route::post('/send_messages/{message}', [
        'as' => 'send_messages.send',
        'uses' => 'SendMessageController@send'
    ])->where('message', '[0-9]+');

    // Teacher
    Route::get('/teachers', [
        'as' => 'teachers.index',
        'uses' => 'TeacherController@index'
    ]);
    Route::get('/teachers/create', [
        'as' => 'teachers.create',
        'uses' => 'TeacherController@create'
    ]);
    Route::post('/teachers', [
        'as' => 'teachers.store',
        'uses' => 'TeacherController@store'
    ]);
    Route::get('/teachers/{teacher}', [
        'as' => 'teachers.show',
        'uses' => 'TeacherController@show'
    ])->where('teacher', '[0-9]+');
    Route::get('/teachers/{teacher}/edit', [
        'as' => 'teachers.edit',
        'uses' => 'TeacherController@edit'
    ])->where('teacher', '[0-9]+');
    Route::put('/teachers/{teacher}', [
        'as' => 'teachers.update',
        'uses' => 'TeacherController@update'
    ])->where('teacher', '[0-9]+');
    Route::delete('/teachers/{teacher}', [
        'as' => 'teachers.destroy',
        'uses' => 'TeacherController@destroy'
    ])->where('teacher', '[0-9]+');
});
