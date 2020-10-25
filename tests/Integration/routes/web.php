<?php

use Illuminate\Support\Facades\Route;
use Tests\Integration\App\Http\Controllers\UserController;

Route::get('/user/{user}', [UserController::class, 'show'])
    ->name('user.show')
    ->where('user', '\d+');

Route::post('user', [UserController::class, 'store'])
    ->name('user.store');

Route::get('request/{num}', function ($num) {
    return "Request {$num}";
});

Route::get('server-error', function () {
    abort(500, 'Server error');
});
