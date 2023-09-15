<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DailyDataController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MonthlyDataController;
use App\Http\Controllers\TransactionController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

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
    return redirect()->route('login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('transactions')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('transactions');
        Route::get('/create', [TransactionController::class, 'create'])->name('transactions.create');
        Route::post('/store', [TransactionController::class, 'store'])->name('transactions.store');
        Route::get('/edit/{id}', [TransactionController::class, 'edit'])->name('transactions.edit');
        Route::put('/update/{id}', [TransactionController::class, 'update'])->name('transactions.update');
        Route::get('/delete/{id}', [TransactionController::class, 'delete'])->name('transactions.delete');
    });

    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('categories');
        Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/store', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::post('/{id}/update', [CategoryController::class, 'update'])->name('categories.update');
        Route::get('/delete/{id}', [CategoryController::class, 'delete'])->name('categories.delete');
        Route::get('/transaction/{id}/view', [CategoryController::class, 'viewTransaction'])->name('categories.transaction.view');
    });

    Route::get('/monthly-datasets',[MonthlyDataController::class, 'index'])->name('monthlyData');
    Route::get('/daily-datasets',[DailyDataController::class, 'index'])->name('dailyData');
});