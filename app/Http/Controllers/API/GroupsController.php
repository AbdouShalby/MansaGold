<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\SubscribedGroup;
use App\Models\User;
use Illuminate\Http\Request;

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
                foreach ($groups as $group) {
                    $subscribed_users = SubscribedGroup::where('group_id', $group->id)->pluck('user_id');
                    $users = User::whereIn('id', $subscribed_users)->get();
                    $groupData['users'] = $users;
                    $groupsData[] = $groupData['users'];
                }
                $groupsArray = $groups->toArray();

                // Add $groupsData as a new key to each group in $groupsArray
                foreach ($groupsArray as $key => $group) {
                    $groupsArray[$key]['users'] = $groupsData[$key];
                }

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
                if (!empty($myGroups) && count($myGroups) > 0) {
                    $totalBalance = 0;
                    $groupsData = [];
                    foreach ($myGroups as $group) {
                        $totalBalance += $group->code_balance;
                        $groupData = Group::where('id', $group->group_id)->get()->toArray();
                        // fetch users for the current group and their code_balance
                        $users = User::select('users.*', 'subscribed_groups.code_balance', 'users.token')
                            ->join('subscribed_groups', 'subscribed_groups.user_id', '=', 'users.id')
                            ->where('subscribed_groups.group_id', $group->group_id)
                            ->get()
                            ->toArray();
                        // add users data to the group data
                        $groupData[0]['users'] = $users;
                        $groupsData[] = $groupData[0];
                    }
                    $groupsArray = $myGroups->toArray();
                    $response['success'] = 'Success';
                    $response['message'] = 'Groups';
                    $response['totalBalance'] = $totalBalance;
                    $response['myGroups'] = $groupsArray;
                    $response['myGroupsData'] = $groupsData;
                } else {
                    $response['success'] = 'Failed';
                    $response['message'] = 'No Groups';
                }
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
