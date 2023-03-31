<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Code;
use App\Models\Group;
use App\Models\SubscribedGroup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupsController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function allGroups(Request $request)
    {
        $token = $request->get('token');

        try {
            $user = User::where('token', $token)->first();

            if (!empty($user)) {
                $groups = Group::all();
                $groupsArray = $groups->toArray();
                $response['success'] = 'Success';
                $response['message'] = 'Groups';
                $response['groups'] = $groupsArray;
            } else {
                $response['success'] = 'Failed';
                $response['message'] = 'Wrong Token';
            }
        } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
            $response['success'] = 'Failed';
            $response['error'] = 'Wrong UID';
        }
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     */
    public function myGroups(Request $request)
    {
        $token = $request->get('token');

        try {
            $user = User::where('token', $token)->first();
            if (!empty($user)) {
                $myGroups = SubscribedGroup::select('subscribed_groups.*', 'groups.group_name', 'groups.current_subscription')
                    ->where('user_id', $user->id)
                    ->join('groups', 'subscribed_groups.group_id', '=', 'groups.id')
                    ->get();
                $totalBalance = 0;
                $groupsData = [];
                foreach ($myGroups as $group) {
                    $totalBalance += $group->code_balance;
                    $groupsData = Group::where('id', $group->group_id)->get();
                }
                $groupsArray = $myGroups->toArray();
                $response['success'] = 'Success';
                $response['message'] = 'Groups';
                $response['totalBalance'] = $totalBalance;
                $response['myGroups'] = $groupsArray;
                $response['myGroupsData'] = $groupsData;
            } else {
                $response['success'] = 'Failed';
                $response['message'] = 'Wrong Token';
            }
        } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
            $response['success'] = 'Failed';
            $response['error'] = 'Wrong Token';
        }
        return response()->json($response);
    }
}
