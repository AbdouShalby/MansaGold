<?php

use App\Http\Controllers\GoldPriceController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CodesController;
use App\Http\Controllers\BannersController;
use App\Http\Controllers\WithdrawsController;
use App\Http\Controllers\TopicSubscriptionController;
use App\Models\Code;
use App\Models\Group;
use App\Models\Logs;
use App\Models\User;
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

Route::get('/gold-prices', [GoldPriceController::class, 'getXauPrices'])->name('get-Xau-prices');

Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/check-code-exists/{code}', function ($code) {
        return DB::table('codes')->where('code_key', $code)->exists() ? 'true' : 'false';
    });

    // Groups
    Route::prefix('groups')->group(function () {
        Route::get('/', [GroupsController::class, 'index'])->name('all.groups');
        Route::get('create', [GroupsController::class, 'create'])->name('create.group');
        Route::post('store', [GroupsController::class, 'store'])->name('store.group');
        Route::get('edit/{id}', [GroupsController::class, 'edit'])->name('edit.group');
        Route::post('update/{id}', [GroupsController::class, 'update'])->name('update.group');
        Route::get('delete/{id}', [GroupsController::class, 'destroy'])->name('delete.group');
        Route::get('investor/{id}', [GroupsController::class, 'investor'])->name('investor.group');

        Route::post('/search', function () {
            // Check for search input
            if (request('search')) {
                $searchedGroups = Group::where('group_name', 'like', '%' . request('search') . '%')->get();
            } else {
                $searchedGroups = Group::all();
            }
            return view('group/all')->with('searchedGroups', $searchedGroups);
        })->name('groups.search');

        Route::get('/get-group-subscription', function (Illuminate\Http\Request $request) {
            $groupId = $request->query('groupId');

            $group = Group::findOrFail($groupId); // Retrieve the group from the database by id

            $currentSubscription = $group->current_subscription; // Get the current_subscription of the group

            return response()->json(['currentSubscription' => $currentSubscription]);
        });


    });


    // Users
    Route::prefix('users')->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name('all.users');
        Route::get('create', [UsersController::class, 'create'])->name('create.user');
        Route::post('store', [UsersController::class, 'store'])->name('store.user');
        Route::get('edit/{id}', [UsersController::class, 'edit'])->name('edit.user');
        Route::post('update/{id}', [UsersController::class, 'update'])->name('update.user');
        Route::get('delete/{id}', [UsersController::class, 'destroy'])->name('delete.user');
        Route::get('delete-avatar/{id}', [UsersController::class, 'deleteAvatar'])->name('delete.avatar');

        Route::post('/search', function () {
            // Check for search input
            if (request('search')) {
                $searchedUsers = User::where('name', 'like', '%' . request('search') . '%')
                    ->orWhere('email', 'like', '%' . request('search') . '%')
                    ->orWhere('phone', 'like', '%' . request('search') . '%')
                    ->orWhere('country', 'like', '%' . request('search') . '%')
                    ->get();
            } else {
                $searchedUsers = User::all();
            }
            return view('user/all')->with('searchedUsers', $searchedUsers);
        })->name('users.search');
    });


    // Codes
    Route::prefix('codes')->group(function () {
        Route::get('/', [CodesController::class, 'index'])->name('all.codes');
        Route::get('create', [CodesController::class, 'create'])->name('create.code');
        Route::post('store', [CodesController::class, 'store'])->name('store.code');
        Route::get('edit/{id}', [CodesController::class, 'edit'])->name('edit.code');
        Route::post('update/{id}', [CodesController::class, 'update'])->name('update.code');
        Route::get('delete/{id}', [CodesController::class, 'destroy'])->name('delete.code');

        Route::post('/search', function () {
            // Check for search input
            if (request('search')) {
                $searchedCodes = Code::where('code_key', 'like', '%' . request('search') . '%')
                    ->orWhere('code_balance', 'like', '%' . request('search') . '%')
                    ->get();
            } else {
                $searchedCodes = Code::all();
            }
            return view('code/all')->with('searchedCodes', $searchedCodes);
        })->name('codes.search');
    });


    // Banners
    Route::prefix('banners')->group(function () {
        Route::get('/', [BannersController::class, 'index'])->name('all.banners');
        Route::get('create', [BannersController::class, 'create'])->name('create.banner');
        Route::post('store', [BannersController::class, 'store'])->name('store.banner');
        Route::get('edit/{id}', [BannersController::class, 'edit'])->name('edit.banner');
        Route::post('update/{id}', [BannersController::class, 'update'])->name('update.banner');
        Route::get('delete/{id}', [BannersController::class, 'destroy'])->name('delete.banner');
        Route::post('search', [BannersController::class, 'search'])->name('banners.search');
    });


    // Logs
    Route::prefix('logs')->group(function () {
        Route::get('/', [LogsController::class, 'logs'])->name('logs');

        Route::post('/search', function () {
            // Check for search input
            if (request('search')) {
                $searchedLogs = Logs::where('name', 'like', '%' . request('search') . '%')
                    ->orWhere('description', 'like', '%' . request('search') . '%')
                    ->get();
            } else {
                $searchedLogs = Logs::all();
            }
            return view('logs')->with('searchedLogs', $searchedLogs);
        })->name('logs.search');
    });


    // Withdraws
    Route::prefix('withdraws')->group(function () {
        Route::get('/', [WithdrawsController::class, 'withdraws'])->name('withdraws');
        Route::get('approve/{id}', [WithdrawsController::class, 'withdrawApprove'])->name('withdraw-approve');
        Route::get('cancel/{id}', [WithdrawsController::class, 'withdrawCancel'])->name('withdraw-cancel');
        Route::post('search', [WithdrawsController::class, 'search'])->name('withdraws.search');
    });

    Route::get('locale/{locale}',function($locale){
        Session::put('locale',$locale);
        return redirect()->back();
    })->name('switchLang');
});
