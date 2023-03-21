<?php

use App\Http\Controllers\GroupsController;
use App\Http\Controllers\HomeController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');

// Groups
Route::get('groups', [GroupsController::class, 'index'])->name('all.groups');
Route::get('group/craete', [GroupsController::class, 'create'])->name('create.group');
Route::post('group/store', [GroupsController::class, 'store'])->name('store.group');
Route::get('group/show/{$id}', [GroupsController::class, 'show'])->name('show.group');
Route::get('group/edit/{$id}', [GroupsController::class, 'edit'])->name('edit.group');
Route::post('group/update/{$id}', [GroupsController::class, 'update'])->name('update.group');
Route::get('group/delete/{$id}', [GroupsController::class, 'destroy'])->name('delete.group');
