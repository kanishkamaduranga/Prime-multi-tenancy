<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;



Route::middleware('web')->group(function () {
    Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

    Route::get('/', function () {
        return view('welcome');
    });
});
