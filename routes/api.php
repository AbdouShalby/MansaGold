<?php

use App\Http\Controllers\API\CodesController;
use App\Http\Controllers\API\GroupsController;
use App\Http\Controllers\API\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// User Controllers
Route::post('login', [UsersController::class, 'login'])->name('user-login');
Route::post('register', [UsersController::class, 'register'])->name('user-regsiter');
Route::post('update', [UsersController::class, 'update'])->name('user-update');
Route::post('userData', [UsersController::class, 'getUserData'])->name('user-data');

// Groups Controllers
Route::post('groups/all', [GroupsController::class, 'allGroups'])->name('all-groups');
Route::post('groups/my', [GroupsController::class, 'myGroups'])->name('my-groups');

// Codes Controllers
Route::post('codes/check', [CodesController::class, 'check'])->name('code-check');
