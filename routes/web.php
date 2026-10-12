
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\StockReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;



Route::get('/login', [LoginController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.submit');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('products', ProductController::class);

    Route::get('/stock-movements', [StockMovementController::class, 'index'])
        ->name('stock-movements.index');

    Route::get('/stock-movements/create', [StockMovementController::class, 'create'])
        ->name('stock-movements.create');

    Route::post('/stock-movements', [StockMovementController::class, 'store'])
        ->name('stock-movements.store');

    Route::get('/stock-reports', [StockReportController::class, 'index'])
        ->name('stock-reports.index');
});
