<?php

use App\Http\Controllers\ChatGptController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/show-aichatgpt-text', [ChatGptController::class, 'showAichatgpt'])->name('show-aichatgpt.text');

Route::post('/api/show-aichatgpt-text', [ChatGptController::class, 'showResponse'])->name('api.show-aichatgpt.text');
Route::post('/api/show-aidalle-text', [ChatGptController::class, 'showResponseWithImage'])->name('api.show-aidalle.text');

