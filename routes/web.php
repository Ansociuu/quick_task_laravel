<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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
| Phân quyền: Chỉ Super Admin mới có quyền truy cập CRUD Users
|--------------------------------------------------------------------------
*/
Route::resource('users', UserController::class)->middleware('superadmin');

/*
|--------------------------------------------------------------------------
| Khai báo từng Route tương ứng cho TaskController
|--------------------------------------------------------------------------
*/
Route::prefix('tasks')->name('tasks.')->controller(TaskController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/', 'store')->name('store');
    Route::get('/{task}', 'show')->name('show');
    Route::get('/{task}/edit', 'edit')->name('edit');
    Route::match(['put', 'patch'], '/{task}', 'update')->name('update');
    Route::delete('/{task}', 'destroy')->name('destroy');
});

require __DIR__.'/auth.php';
