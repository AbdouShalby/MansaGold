<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserBalance;
use App\Models\Video;
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
                if ($userBalance >= $amount) {
                    DB::table('user_balances')->where('user_id', $user->id)->decrement('balance', $amount);
                    DB::table('withdraw')->insert([
                        'user_id' => $user->id,
                        'amount' => $amount,
                        'status' => 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $response['success'] = 'Success';
                    $response['message'] = 'Sucessfully';
                    $response['status'] = 'Pending';
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
