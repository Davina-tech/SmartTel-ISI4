<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('accueil');
})->name('accueil');


Route::middleware(['auth'])->group(function () {
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
});




Route::get('/sources', function () {
    return view('sources');
})->name('sources');

Route::get('/analyses', function () {
    return view('analyses');
})->name('analyses');

Route::get('/parametres', function () {
    return view('parametres');
})->name('parametres');
Route::get('/login', function () {
    return view('login');
})->name('login');


Route::get('/register', function () {
    return view('register');
})->name('register');

use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

use App\Http\Controllers\SourceController;

Route::get('/sources', [SourceController::class, 'index'])->name('sources');
Route::post('/sources/import', [SourceController::class, 'import'])->name('sources.import');
Route::post('/sources/api', [SourceController::class, 'api'])->name('sources.api');
