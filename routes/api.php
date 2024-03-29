<?php

use App\Http\Controllers\API\BannersController;
use App\Http\Controllers\API\CodesController;
use App\Http\Controllers\API\GoldPricesController;
use App\Http\Controllers\API\GroupsController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\UsersController;
use App\Http\Controllers\API\VideosController;
use App\Http\Controllers\API\WithdrawsController;
use App\Http\Controllers\GoldPriceController;
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

// Videos Controllers
Route::post('video', [VideosController::class, 'getVideo'])->name('get-video');

// Banners Controllers
Route::post('banners', [BannersController::class, 'getBanners'])->name('get-banners');

// Gold Prices Controllers
Route::post('gold/prices', [GoldPricesController::class, 'goldPrices'])->name('gold-prices');

// Withdraws Controllers
Route::post('withdraw', [WithdrawsController::class, 'withdraw'])->name('withdraw');
Route::post('withdraw/check', [WithdrawsController::class, 'withdrawCheck'])->name('withdraw-check');

// Notifications Controllers
Route::post('send-notification', [NotificationController::class, 'sendNotification'])->name('sendNotification');
