<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\PermissionController;
use App\Http\Controllers\Master\RoleController;
use App\Http\Controllers\Master\UmkmController;
use App\Http\Controllers\Master\UserController;
use App\Http\Controllers\Portal\AuthController as PortalAuthController;
use App\Http\Controllers\Portal\ProfileController as PortalProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::name('dashboard.')->middleware(['auth:web', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('home');
});

Route::post('/profile/update', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update_ajax')->middleware('auth');

Route::name('master.')->prefix('master')->middleware(['auth:web', config('jetstream.auth_session'), 'verified'])->group(function () {
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

    // umkm
    Route::name('umkm.')->controller(UmkmController::class)->prefix('umkm')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/datatable', 'datatable')->name('datatable');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/import', 'import')->name('import');
        Route::post('/import', 'processImport')->name('process-import');
        Route::post('/import-fix', 'storeImportFix')->name('store-import-fix');
        Route::get('/download-template', 'downloadTemplate')->name('download-template');
        Route::get('/{umkm}', 'show')->name('show');
        Route::get('/{umkm}/edit', 'edit')->name('edit');
        Route::put('/{umkm}', 'update')->name('update');
        Route::post('/{umkm}/change-status', 'changeStatus')->name('change-status');
        Route::delete('/{umkm}', 'destroy')->name('destroy');
    });
});

Route::middleware(['auth:web', config('jetstream.auth_session'), 'verified'])->group(function () {
    // Auth protected routes if any remaining
});

// Regional Data Helpers (AJAX) - Public for Portal Access
Route::controller(\App\Http\Controllers\Api\RegionController::class)->prefix('ajax/region')->group(function () {
    Route::get('/provinces', 'provinces')->name('api.provinces');
    Route::get('/cities/{provinceId}', 'cities')->name('api.cities');
    Route::get('/districts/{cityId}', 'districts')->name('api.districts');
    Route::get('/villages/{districtId}', 'villages')->name('api.villages');
});

// Portal UMKM Routes
Route::prefix('portal')->name('portal.')->group(function () {
    Route::middleware('umkm.guest')->group(function () {
        Route::get('/login', [PortalAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [PortalAuthController::class, 'login'])->name('login.post');
    });

    Route::middleware('umkm.auth')->group(function () {
        Route::post('/logout', [PortalAuthController::class, 'logout'])->name('logout');
        Route::get('/profile', [PortalProfileController::class, 'show'])->name('profile');
        Route::get('/profile/edit', [PortalProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [PortalProfileController::class, 'update'])->name('profile.update');

        // Business Plan Routes
        Route::get('/business-plan', [\App\Http\Controllers\Portal\BusinessPlanController::class, 'index'])->name('business-plan.index');
        Route::get('/business-plan/step/{step}', [\App\Http\Controllers\Portal\BusinessPlanController::class, 'showStep'])->name('business-plan.step');
        Route::post('/business-plan/step/{step}', [\App\Http\Controllers\Portal\BusinessPlanController::class, 'storeStep'])->name('business-plan.store');
    });
});
