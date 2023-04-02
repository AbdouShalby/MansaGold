<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Code;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CodesController extends Controller
{
    public function check(Request $request) {
        $token = $request->get('token');
        $code = $request->get('code');

        try {
            $user = User::where('token', $token)->first();

            if (!empty($user)) {
                $checkCode = Code::where('code_key', $code)->first();
                if (!empty($checkCode)) {
//                    if ($checkCode->code_status != 1) {
                        DB::table('subscribed_groups')->insert([
                            'user_id' => $user->id,
                            'group_id' => $checkCode->group_id,
                            'code_id' => $checkCode->id,
                            'code_balance' => $checkCode->code_balance,
                            'subscribed_at' => now()
                        ]);
                        DB::table('codes')->where(['id' => $checkCode->id])->update(['code_status' => 1]);
                        DB::table('groups')->where('id', $checkCode->group_id)->increment('current_subscription', $checkCode->code_balance);
                        DB::table('users')->where(['id' => $checkCode->id])->update(['status' => 1]);

                        $code = Code::where('id',$checkCode->id )->first();
                        $group = Group::where('id', $code->group_id)->first();

                        DB::table('logs')->insert([
                            'name' => 'code',
                            'description' => __('logs.code.used', ['key' => $code->code_key, 'group' => $group->group_name, 'balance' => $code->code_balance, 'user' => $user->name]),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        $response['success'] = 'Success';
                        $response['message'] = 'Sucessfully';
//                    } else {
//                        $response['success'] = 'Failed';
//                        $response['message'] = 'Code Already Used';
//                    }
                } else {
                    $response['success'] = 'Failed';
                    $response['message'] = 'Wrong Code';
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
