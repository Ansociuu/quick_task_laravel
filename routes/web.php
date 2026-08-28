<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route chuyển đổi ngôn ngữ (Tiếng Việt / Tiếng Anh)
Route::get('/lang/{locale}', [LanguageController::class, 'switchLanguage'])->name('lang.switch');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Phân quyền: Sử dụng Gate 'is-super-admin' trong UserController thay
| cho middleware. Route không cần khai báo middleware ở đây nữa.
|--------------------------------------------------------------------------
*/
Route::resource('users', UserController::class);

/*
|--------------------------------------------------------------------------
| Khai báo từng Route tương ứng cho TaskController
|--------------------------------------------------------------------------
*/
Route::prefix('tasks')->name('tasks.')->controller(TaskController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/', 'store')->name('store');
    Route::get('/{id}', 'show')->name('show');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::match(['put', 'patch'], '/{id}', 'update')->name('update');
    Route::delete('/{id}', 'destroy')->name('destroy');
});

require __DIR__.'/auth.php';
