<?php
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
