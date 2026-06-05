<?php

use App\Http\Controllers\CatagoriesController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/users', function () {
//     return view('user');
// });

// Route::get('/customers', function () {
//     return view('customer');
// });

Route::get('/users', [UserController::class, 'index'])
    ->name('users.index');
Route::get('/customers', [CustomerController::class, 'index'])
    ->name('customers.index');
Route::get('/users/{id}', [UserController::class, 'show'])
    ->name('users.show')
    ->where('id', '[0-9]+');
Route::get('/users/{username}/{email}', [UserController::class, 'getUsernameEmail'])
    ->name('users.getUsernameEmail');

// Categories routes:
Route::get('/categories', [CatagoriesController::class, 'index'])
    ->name('categories.index');
Route::get('/categories/create', [CatagoriesController::class, 'create'])
    ->name('categories.create');
Route::post('/categories/store', [CatagoriesController::class, 'store'])
    ->name('categories.store');
Route::get('/categories/{id}', [CatagoriesController::class, 'edit'])
    ->name('categories.edit');
Route::put('/categories/{id}', [CatagoriesController::class, 'update'])
    ->name('categories.update');
Route::delete('/categories/{id}', [CatagoriesController::class, 'destroy'])
    ->name('categories.destroy');
