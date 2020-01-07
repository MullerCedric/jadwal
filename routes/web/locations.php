<?php
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
