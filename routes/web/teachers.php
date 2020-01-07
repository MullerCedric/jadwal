<?php
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