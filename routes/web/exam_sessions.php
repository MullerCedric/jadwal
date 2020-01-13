<?php
Route::get('/exam_sessions', [
    'as' => 'exam_sessions.index',
    'uses' => 'ExamSessionController@index'
])->middleware('createIfEmpty:exam_sessions');
Route::get('/exam_sessions/create', [
    'as' => 'exam_sessions.create',
    'uses' => 'ExamSessionController@create'
])->middleware('requiredBeforeCreate:exam_sessions');
Route::post('/exam_sessions', [
    'as' => 'exam_sessions.store',
    'uses' => 'ExamSessionController@store'
]);
Route::get('/exam_sessions/{id}', [
    'as' => 'exam_sessions.show',
    'uses' => 'ExamSessionController@show'
])->where('id', '[0-9]+')->middleware('editIfDraft:exam_sessions');
Route::get('/exam_sessions/{exam_session}/edit', [
    'as' => 'exam_sessions.edit',
    'uses' => 'ExamSessionController@edit'
])->where('exam_session', '[0-9]+')->middleware('can:update,exam_session, showIfSent:exam_sessions');

// Copy Exam Sessions
Route::post('/exam_sessions/{id}/copy', [
    'as' => 'exam_sessions.copy',
    'uses' => 'ExamSessionController@copy'
])->where('id', '[0-9]+');

// Draft Exam Sessions
Route::post('/draft_exam_sessions', [
    'as' => 'draft_exam_sessions.store',
    'uses' => 'DraftExamSessionController@store'
])->middleware('can:update,exam_session');

// Closed Exam Sessions
Route::get('/closed_exam_sessions', [
    'as' => 'closed_exam_sessions.index',
    'uses' => 'ClosedExamSessionController@index'
]);
Route::delete('/closed_exam_sessions/{exam_session}', [
    'as' => 'closed_exam_sessions.store',
    'uses' => 'ClosedExamSessionController@store'
])->where('exam_session', '[0-9]+')->middleware('can:update,exam_session');
Route::delete('/closed_exam_sessions/destroy/{exam_session}', [
    'as' => 'closed_exam_sessions.destroy',
    'uses' => 'ClosedExamSessionController@destroy'
])->where('exam_session', '[0-9]+')->middleware('can:update,exam_session');
