<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\PermissionController;
use App\Http\Controllers\Master\RoleController;
use App\Http\Controllers\Master\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
}); 

Route::name('dashboard.')->middleware(['auth:web',config('jetstream.auth_session'),'verified'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
});

Route::name('master.')->prefix('master')->middleware(['auth:web',config('jetstream.auth_session'),'verified'])->group(function () {
    // user
    Route::name('user.')->controller(UserController::class)->prefix('user')->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/data', 'data')->name('data');
        Route::get('/show/{user:id}', 'show')->name('show');
        Route::post('/insert', 'insert')->name('insert');
        Route::post('/update/{user:id}', 'update')->name('update');
        Route::post('/delete/{user:id}', 'delete')->name('delete');
        Route::post('/reset_2fa/{user:id}', 'reset_2fa')->name('reset_2fa');
    });

    // role
    Route::name('role.')->controller(RoleController::class)->prefix('role')->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/data', 'data')->name('data');
        Route::get('/detail/{role:id}', 'detail')->name('detail');
        Route::post('/insert', 'insert')->name('insert');
        Route::post('/update/{role:id}', 'update')->name('update');
        Route::post('/delete/{role:id}', 'delete')->name('delete');
    });

    // permission
    Route::name('permission.')->controller(PermissionController::class)->prefix('permission')->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/data', 'data')->name('data');
        Route::get('/detail/{permission:id}', 'detail')->name('detail');
        Route::post('/insert', 'insert')->name('insert');
        Route::post('/update/{permission:id}', 'update')->name('update');
        Route::post('/delete/{permission:id}', 'delete')->name('delete');
    });
});