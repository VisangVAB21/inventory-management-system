<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockTransactionController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingsController;

/*
|--------------------------------------------------------------------------
| REDIRECT AWAL
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |----------------------
    | DASHBOARD
    |----------------------
    */
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    /*
    |----------------------
    | LOGOUT
    |----------------------
    */
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/login')->with('success', 'Berhasil logout!');
    })->name('logout');


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
    /*
    |--------------------------------------------------------------------------
    | CRUD (CLEAN RESOURCE ROUTES ONLY)
    |--------------------------------------------------------------------------
    */

    

    // CATEGORY
    Route::resource('categories', CategoryController::class);

    // PRODUCT
    Route::resource('products', ProductController::class);
    Route::post('/products/{id}/opname', [ProductController::class, 'opname']);

    // SUPPLIER
    Route::resource('suppliers', SupplierController::class);

    /*
    |--------------------------------------------------------------------------
    | STOCK TRANSACTIONS
    |--------------------------------------------------------------------------
    */
    Route::get('/transactions', [StockTransactionController::class, 'index']);

    /*
    |--------------------------------------------------------------------------
    | STOCK IN
    |--------------------------------------------------------------------------
    */
    Route::resource('stock_in', StockInController::class);

    
    /*
    |--------------------------------------------------------------------------
    | STOCK OUT
    |--------------------------------------------------------------------------
    */
    Route::resource('stock_out', StockOutController::class);

    
    /*
    |--------------------------------------------------------------------------
    | USER CONTROLLER
    |--------------------------------------------------------------------------
    */
    Route::resource('users', App\Http\Controllers\UserController::class);

    
    /*
    |--------------------------------------------------------------------------
    | ACTIVITY LOG
    |--------------------------------------------------------------------------
    */
    Route::get('/activity-log', [ActivityLogController::class, 'index'])
    ->name('activity.index');

    /*
    |--------------------------------------------------------------------------
    | REPORT
    |--------------------------------------------------------------------------
    */
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export/pdf', [ReportController::class, 'exportPdf'])->name('reports.pdf');
    Route::get('/reports/export/excel', [ReportController::class, 'exportExcel'])->name('reports.excel');
      

     /*
    |--------------------------------------------------------------------------
    | SETTINGS POLICY
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Admin Settings - KHUSUS ADMIN
  // === ROUTE SETTINGS ===
// === ROUTE SETTINGS ===
// Settings Route
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])
         ->name('admin.settings');
         
    Route::put('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])
         ->name('admin.settings.update');
});
});

// routes/web.php
    Route::patch('/stock-in/{id}/check', [StockInController::class, 'checkStockIn'])->name('stock-in.check');
    Route::patch('/stock-out/{id}/prepare', [StockOutController::class, 'prepareStockOut'])->name('stock-out.prepare');
    
    });