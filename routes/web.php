<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Cách 1: Dùng Route::resource cho UserController
|--------------------------------------------------------------------------
| Tự động tạo đầy đủ 7 routes chuẩn RESTful kèm theo route names (users.index, users.create...)
*/
Route::resource('users', UserController::class);

/*
|--------------------------------------------------------------------------
| Cách 2: Viết rõ từng Route tương ứng với các methods của TaskController
|--------------------------------------------------------------------------
| Sử dụng Route Group (prefix & name prefix) để gom nhóm các route của Task
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
