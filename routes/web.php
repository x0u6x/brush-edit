<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DocumentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('custom-auth/welcome-login');
});

//アカウント管理ルート
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->controller(DocumentController::class)->group(function () {
    Route::get('documents/directory', 'index')->name('document.index');
    Route::get('documents/create', 'create')->name('document.create');
    Route::get('documents/{id}/edit', 'edit')->name('document.edit');
    Route::delete('documents/{id}', 'destroy')->name('document.destroy');
    Route::get('documents/{id}/preview', 'preview')->name('document.preview');
});

require __DIR__ . '/auth.php';
