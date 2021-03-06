<?php
Route::get('/messages', [
    'as' => 'messages.index',
    'uses' => 'MessageController@index'
])->middleware('createIfEmpty:messages');
Route::get('/messages/create', [
    'as' => 'messages.create',
    'uses' => 'MessageController@create'
])->middleware('requiredBeforeCreate:messages');
Route::post('/messages', [
    'as' => 'messages.store',
    'uses' => 'MessageController@store'
]);
Route::get('/messages/{message}', [
    'as' => 'messages.show',
    'uses' => 'MessageController@show'
])->where('message', '[0-9]+')->middleware('can:crudExisting,message, editIfDraft:messages');
Route::get('/messages/{message}/edit', [
    'as' => 'messages.edit',
    'uses' => 'MessageController@edit'
])->where('message', '[0-9]+')->middleware('can:crudExisting,message, showIfSent:messages');
Route::delete('/messages/{message}', [
    'as' => 'messages.destroy',
    'uses' => 'MessageController@destroy'
])->where('message', '[0-9]+')->middleware('can:crudExisting,message');

// Draft Messages
Route::post('/draft_messages', [
    'as' => 'draft_messages.store',
    'uses' => 'DraftMessageController@store'
]);

// Send Messages
Route::post('/send_messages/{message}', [
    'as' => 'send_messages.send',
    'uses' => 'SendMessageController@send'
])->where('message', '[0-9]+')->middleware('can:crudExisting,message');
