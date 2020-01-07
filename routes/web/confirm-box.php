<?php
Route::get('/confirm/cancel', function () {
    Session::flash('confirmBoxId', 'none');
    return redirect()->back();
})->name('confirm.cancel');
Route::get('/confirm/show/{confirmBoxId}', function ($confirmBoxId) {
    Session::flash('confirmBoxId', $confirmBoxId);
    return redirect()->back();
})->where(['confirmBoxId' => '[\w\-_]+'])->name('confirm.show');
