<?php

use App\Http\Controllers\GroupsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CodesController;
use App\Http\Controllers\BannersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/check-code-exists/{code}', function ($code) {
        return DB::table('codes')->where('code_key', $code)->exists() ? 'true' : 'false';
    });

    // Groups
    Route::get('groups', [GroupsController::class, 'index'])->name('all.groups');
    Route::get('group/create', [GroupsController::class, 'create'])->name('create.group');
    Route::post('group/store', [GroupsController::class, 'store'])->name('store.group');
    Route::get('group/edit/{id}', [GroupsController::class, 'edit'])->name('edit.group');
    Route::post('group/update/{id}', [GroupsController::class, 'update'])->name('update.group');
    Route::get('group/delete/{id}', [GroupsController::class, 'destroy'])->name('delete.group');

    // Users
    Route::get('users', [UsersController::class, 'index'])->name('all.users');
    Route::get('user/create', [UsersController::class, 'create'])->name('create.user');
    Route::post('user/store', [UsersController::class, 'store'])->name('store.user');
    Route::get('user/edit/{id}', [UsersController::class, 'edit'])->name('edit.user');
    Route::post('user/update/{id}', [UsersController::class, 'update'])->name('update.user');
    Route::get('user/delete/{id}', [UsersController::class, 'destroy'])->name('delete.user');

    // Codes
    Route::get('codes', [CodesController::class, 'index'])->name('all.codes');
    Route::get('code/create', [CodesController::class, 'create'])->name('create.code');
    Route::post('code/store', [CodesController::class, 'store'])->name('store.code');
    Route::get('code/edit/{id}', [CodesController::class, 'edit'])->name('edit.code');
    Route::post('code/update/{id}', [CodesController::class, 'update'])->name('update.code');
    Route::get('code/delete/{id}', [CodesController::class, 'destroy'])->name('delete.code');

    // Banners
    Route::get('banners', [BannersController::class, 'index'])->name('all.banners');
    Route::get('banner/create', [BannersController::class, 'create'])->name('create.banner');
    Route::post('banner/store', [BannersController::class, 'store'])->name('store.banner');
    Route::get('banner/edit/{id}', [BannersController::class, 'edit'])->name('edit.banner');
    Route::post('banner/update/{id}', [BannersController::class, 'update'])->name('update.banner');
    Route::get('banner/delete/{id}', [BannersController::class, 'destroy'])->name('delete.banner');

    Route::post('search', [HomeController::class, 'search'])->name('search');
});
