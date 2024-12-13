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
    Route::get('/{id}', [EmployeeController::class, 'findById'])->name('show');
    
    // Admin-only routes
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('/', [EmployeeController::class, 'store'])->name('store');
        Route::get('/add', [EmployeeController::class, 'getCreateView'])->name('add');
        Route::get('/edit/{id}', [EmployeeController::class, 'getEditView'])->name('edit');
        Route::put('/{id}', [EmployeeController::class, 'update'])->name('update');
        Route::delete('/{id}', [EmployeeController::class, 'delete'])->name('delete');
    });
});

// Workload routes
Route::prefix('workloads')->name('workloads.')->group(function () {
    Route::get('/', [WorkloadController::class, 'list'])->name('list');
    Route::post('/', [WorkloadController::class, 'store'])->name('store');
    Route::get('/add', [WorkloadController::class, 'getCreateView'])->name('add');
    Route::get('/{id}', [WorkloadController::class, 'findById'])->name('show');
    
    Route::put('/{id}', [WorkloadController::class, 'update'])->name('update');
    Route::get('/edit/{id}', [WorkloadController::class, 'getEditView'])->name('edit');
    Route::delete('/{id}', [WorkloadController::class, 'delete'])->name('delete');
});

// Project routes
Route::prefix('projects')->group(function () {
    Route::get('/', [ProjectController::class, 'list'])->name('projects.list');
    Route::post('/', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/add', [ProjectController::class, 'getCreateView'])->name('projects.add');
    Route::get('/{id}', [ProjectController::class, 'findById'])->name('projects.show');
    Route::get('/{id}/workloads', [ProjectController::class, 'getWorkloads'])->name('projects.workloads');
    
    Route::put('/{id}', [ProjectController::class, 'update'])->name('projects.update');
    Route::get('/edit/{id}', [ProjectController::class, 'getEditView'])->name('projects.edit');
    Route::delete('/{id}', [ProjectController::class, 'delete'])->name('projects.delete');
});

// Reports routes
Route::prefix('reports')->group(function () {
    Route::get('/generate', [ReportController::class, 'generateReport'])->name('reports.generate');
    Route::get('/test-pdf', function() {
        $pdf = PDF::loadHTML('<h1>Hello, PDF!</h1>');
        return $pdf->download('test.pdf');
    });
});

// Chart route
Route::get('/charts', [ChartController::class, 'index'])->name('chart');

// Default Authentication routes
Auth::routes();
