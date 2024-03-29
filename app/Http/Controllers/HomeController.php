<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Logs;
use App\Models\User;
use App\Models\UserBalance;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $latestGroups = Group::latest('created_at')->take(5)->get();
        $countOfUsers = User::all()->count();
        $countOfGroups = Group::all()->count();
        $countOfGroupsCompleted = Group::where('group_status', 2)->count();
        $countOfInvest = Group::pluck('current_subscription')->sum();
        return view('home', [
            'latestGroups' => $latestGroups,
            'totalUsers' => $countOfUsers,
            'totalGroups' => $countOfGroups,
            'countOfGroupsCompleted' => $countOfGroupsCompleted,
            'totalInvest' => $countOfInvest
        ]);
    }

    public function logs(Request $request) {
        $logs = Logs::orderByDesc('id')->paginate(20);
        return view('logs', [
            'logs' => $logs,
        ]);
    }

    public function withdraws(Request $request) {
        $withdraws = Withdraw::orderByDesc('id')->paginate(20);
        $users = User::all();
        return view('withdraws', [
            'withdraws' => $withdraws,
            'users' => $users,
        ]);
    }

    public function withdrawApprove(Request $request, $id) {
        Withdraw::where('id', $id)->update(['status' => 1]);
        return back();
    }

    public function withdrawCancel(Request $request, $id) {
        $withdraw = Withdraw::where('id', $id)->first();
        UserBalance::where('user_id', $withdraw->user_id)
            ->update(['balance' => DB::raw('balance + ' . $withdraw->amount)]);
        $withdraw->update(['status' => 2]);
        return back();
    }
}
