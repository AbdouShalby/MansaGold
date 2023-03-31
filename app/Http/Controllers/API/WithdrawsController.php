<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserBalance;
use App\Models\Video;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithdrawsController extends Controller
{
    public function withdraw(Request $request) {
        $token = $request->get('token');
        $amount = $request->get('amount');

        try {
            $user = User::where('token', $token)->first();

            if (!empty($user)) {
                $userBalance = UserBalance::where('user_id', $user->id)->first();
                if ($userBalance->balance >= $amount) {
                    DB::table('user_balances')->where('user_id', $user->id)->decrement('balance', $amount);
                    $withdrawID = DB::table('withdraws')->insertGetId([
                        'user_id' => $user->id,
                        'amount' => $amount,
                        'status' => 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $response['success'] = 'Success';
                    $response['message'] = 'Sucessfully';
                    $response['status'] = 'Pending';
                    $response['withdraw ID'] = $withdrawID;
                } else {
                    $response['success'] = 'Failed';
                    $response['message'] = 'No Enough Balance';
                }
            } else {
                $response['success'] = 'Failed';
                $response['message'] = 'Wrong Token';
            }
        } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
            $response['success'] = 'Failed';
            $response['error'] = 'Wrong Data';
        }
        return response()->json($response);
    }

    public function withdrawCheck(Request $request) {
        $token = $request->get('token');
        $withdrawID = $request->get('withdrawID');

        try {
            $user = User::where('token', $token)->first();

            if (!empty($user)) {
                $checkWithdraw = Withdraw::where('user_id', $user->id)->where('id', $withdrawID)->first();
                if (!empty($checkWithdraw)) {
                    if ($checkWithdraw->status == 0) {
                        $response['withdraw ID'] = $withdrawID;
                        $response['status'] = 'Pending';
                    } elseif ($checkWithdraw->status == 1) {
                        $response['withdraw ID'] = $withdrawID;
                        $response['status'] = 'Approved';
                    } else {
                        $response['withdraw ID'] = $withdrawID;
                        $response['status'] = 'Cancelled';
                    }
                } else {
                    $response['success'] = 'Failed';
                    $response['message'] = 'No Enough Balance';
                }
            } else {
                $response['success'] = 'Failed';
                $response['message'] = 'Wrong Token';
            }
        } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
            $response['success'] = 'Failed';
            $response['error'] = 'Wrong Data';
        }
        return response()->json($response);
    }
}
