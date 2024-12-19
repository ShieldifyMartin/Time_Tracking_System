<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\WorkloadController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ChartController;

require __DIR__.'/auth.php';

// Welcome page
Route::view('/', 'welcome')->name('home');

// Employee routes
Route::prefix('employees')->name('employees.')->group(function () {
    Route::get('/', [EmployeeController::class, 'list'])->name('list');
    Route::get('/id/{id}', [EmployeeController::class, 'findById'])->name('show');
    
    // Admin-only routes
    Route::middleware(['auth'])->group(function () {
        Route::post('/', [EmployeeController::class, 'store'])->name('store');
        Route::get('/add', [EmployeeController::class, 'getCreateView'])->name('add');
        Route::put('/{id}', [EmployeeController::class, 'update'])->name('update');
        Route::get('/edit/{id}', [EmployeeController::class, 'getEditView'])->name('edit');
        Route::delete('/{id}', [EmployeeController::class, 'delete'])->name('delete');
    });
});

// Workload routes
Route::prefix('workloads')->name('workloads.')->group(function () {
    Route::get('/', [WorkloadController::class, 'list'])->name('list');
    Route::get('/id/{id}', [WorkloadController::class, 'findById'])->name('show');

    Route::middleware(['auth'])->group(function () {
        Route::post('/', [WorkloadController::class, 'store'])->name('store');
        Route::get('/add', [WorkloadController::class, 'getCreateView'])->name('add');
        Route::put('/{id}', [WorkloadController::class, 'update'])->name('update');
        Route::get('/edit/{id}', [WorkloadController::class, 'getEditView'])->name('edit');
        Route::delete('/{id}', [WorkloadController::class, 'delete'])->name('delete');
    });
});

// Project routes
Route::prefix('projects')->name('projects.')->group(function () {
    Route::get('/', [ProjectController::class, 'list'])->name('list');
    Route::get('/id/{id}', [WorkloadController::class, 'findById'])->name('show');
    Route::get('/{id}/workloads', [ProjectController::class, 'getWorkloads'])->name('workloads');

    Route::middleware(['auth'])->group(function () {
        Route::post('/', [ProjectController::class, 'store'])->name('store');
        Route::get('/add', [ProjectController::class, 'getCreateView'])->name('add');
        Route::get('/{id}', [ProjectController::class, 'findById'])->name('show');
        Route::put('/{id}', [ProjectController::class, 'update'])->name('update');
        Route::get('/edit/{id}', [ProjectController::class, 'getEditView'])->name('edit');
        Route::delete('/{id}', [ProjectController::class, 'delete'])->name('delete');
    });
});

// Reports routes
Route::prefix('reports')->group(function () {
    Route::get('/generate', [ReportController::class, 'generateReport'])->name('reports.generate');
});

// Chart route
Route::middleware(['auth'])->group(function () {
    Route::get('/charts', [ChartController::class, 'index'])->name('chart');
});

// Default Authentication routes
Auth::routes();
