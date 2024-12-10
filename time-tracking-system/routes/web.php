<?php

use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\WorkloadController;
use App\Http\Controllers\ProjectController;

// Welcome page
Route::view('/', 'welcome');

// Employee routes
Route::prefix('employees')->group(function () {
    Route::get('/', [EmployeeController::class, 'list'])->name('employees.list');
    Route::post('/', [EmployeeController::class, 'store']);
    Route::view('/add', 'employees.add')->name('employees.add');
    Route::get('/{id}', [EmployeeController::class, 'findById']);
    Route::put('/{id}', [EmployeeController::class, 'update']);
    Route::delete('/{id}', [EmployeeController::class, 'delete']);
});

// Workload routes
Route::prefix('workloads')->group(function () {
    Route::get('/', [WorkloadController::class, 'list'])->name('workloads.list');
    Route::post('/', [WorkloadController::class, 'store']);
    Route::view('/add', 'workloads.add')->name('workloads.add');
    Route::get('/{id}', [WorkloadController::class, 'findById']);
    Route::put('/{id}', [WorkloadController::class, 'update']);
    Route::delete('/{id}', [WorkloadController::class, 'delete']);
});

// Project routes
Route::prefix('projects')->group(function () {
    Route::get('/', [ProjectController::class, 'list'])->name('projects.list');
    Route::post('/', [ProjectController::class, 'store']);
    Route::view('/add', 'projects.add')->name('projects.add');
    Route::get('/{id}', [ProjectController::class, 'findById']);
    Route::put('/{id}', [ProjectController::class, 'update']);
    Route::delete('/{id}', [ProjectController::class, 'delete']);
    Route::get('/{id}/workloads', [ProjectController::class, 'getWorkloads']);
});