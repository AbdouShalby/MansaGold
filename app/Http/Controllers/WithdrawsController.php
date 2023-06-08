<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserBalance;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithdrawsController extends Controller
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
