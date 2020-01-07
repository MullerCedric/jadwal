<?php
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
