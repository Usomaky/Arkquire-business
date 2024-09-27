<?php

use App\Http\Controllers\Admin\BusinessController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\PropertyController;


Route::post('/login', function(){});

Route::middleware(['super_admin'])->group(function () {
    // dashboard routes
    Route::get('/dashboard', function(){
        return Inertia::render('Admin/Dashboard');
    });

    // User routes
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users/{id}/status', [UserController::class, 'updateStatus']);
    Route::post('/users/{id}/usertype', [UserController::class, 'updateType']);

    // Business routes
    Route::get('/businesses', [BusinessController::class, 'index']);
    Route::put('/business/{id}', [BusinessController::class, 'update']);
    Route::put('/businesses/{id}/status', [BusinessController::class, 'updateStatus']);
    Route::delete('/businesses/{id}', [BusinessController::class, 'destroy']);
    Route::put('/businesses/disable/{id}', [BusinessController::class, 'disable']);
    Route::put('/businesses/enable/{id}', [BusinessController::class, 'enable']);


    // category routes
    Route::get('/category', [CategoryController::class, 'index']);

    Route::post('/category',
        [CategoryController::class, 'store']
    );

    Route::put('/category/{id}', [CategoryController::class, 'update']);
    Route::put('/category/disable/{id}', [CategoryController::class, 'disable']);
    Route::put('/category/enable/{id}', [CategoryController::class, 'enable']);

    Route::delete('/category/{id}', [CategoryController::class, 'destroy']);

    // Property routes
    Route::get('/property', [PropertyController::class, 'index']);

    Route::post('/property',
        [PropertyController::class, 'store']
    );

    Route::put('/property/{id}', [PropertyController::class, 'update']);
    Route::put('/property/disable/{id}', [PropertyController::class, 'disable']);
    Route::put('/property/enable/{id}', [PropertyController::class, 'enable']);

    Route::delete('/property/{id}', [PropertyController::class, 'destroy']);

    
});
