<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\Group;
use App\Models\SubscribedGroup;
use App\Models\User;
use App\Models\UserBalance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all()->sortDesc();
        return view('user/all', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'phone' => 'required|min:10|unique:users,phone',
            'country' => 'required|string|max:40',
            'status' => 'required|boolean',
            'role' => 'required|numeric|max:1',
            'user_avatar' => 'sometimes|mimes:jpeg,jpg,png,gif|max:100000'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = md5($request->password);
        $user->phone = $request->phone;
        $user->country = $request->country;
        $user->status = $request->status;
        $user->role = $request->role;
        $path = $request->file('user_avatar')->store('/avatars/users/' . $user->name, ['disk' => 'my_files']);
        $user->user_avatar = $path;
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        $user->save();

        DB::table('user_balances')->insert(['user_id' => $user->id, 'balance' => 0, 'created_at' => now(), 'updated_at' => now()]);

        DB::table('logs')->insert([
            'name' => 'user',
            'description' => __('logs.user.inserted', ['name' => $user->name]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', __('users.added-success'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::where('id', $id)->get()->first();
        $allGroups = Group::all();
        $allCodes = Code::all();
        $count_sub_groups = SubscribedGroup::where('user_id', $id)->count();
        $sub_groups = SubscribedGroup::where('user_id', $id)->get();
        $count_invest = SubscribedGroup::where('user_id', $id)->sum('code_balance');

        $subscribedGroups = SubscribedGroup::where('user_id', $id)->get();
        $groups = Group::whereIn('id', $subscribedGroups->pluck('group_id'))
            ->where('group_status', '!=', 2)
            ->get();
        $activeInvest = SubscribedGroup::whereIn('group_id', $groups->pluck('id'))
            ->select('group_id', DB::raw('SUM(code_balance) as total_balance'))
            ->groupBy('group_id')
            ->get();
        $totalActiveInvest = $activeInvest->sum('total_balance');

        if (UserBalance::where('user_id', $id)->exists()) {
            $balance = UserBalance::where('user_id', $id)->value('balance');
        } else {
            $balance = 0;
        }
        return view('user/edit', [
            'user' => $user,
            'allGroups' => $allGroups,
            'allCodes' => $allCodes,
            'count_sub_groups' => $count_sub_groups,
            'sub_groups' => $sub_groups,
            'activeInvest' => $activeInvest,
            'totalActiveInvest' => $totalActiveInvest,
            'count_invest' => $count_invest,
            'balance' => $balance,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::where('id', $id)->get()->first();

        if (!empty($user)) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:100',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|min:10|unique:users,phone',
                'country' => 'required|string|max:40',
                'status' => 'required|boolean',
                'role' => 'required|numeric|max:1',
                'user_avatar' => 'sometimes|mimes:jpeg,jpg,png,gif|max:100000'
            ]);

            if ($request->file()) {
                $directory = dirname($user->user_avatar);
                if (File::exists($directory)) {
                    File::deleteDirectory(public_path($directory));
                }
                $user_avatar = $request->file('user_avatar')->store('/avatars/users/' . $user->name, ['disk' => 'my_files']);
            } else {
                $user_avatar = $user->user_avatar;
            }

            $name = $request->name;
            $email = $request->email;
            $phone = $request->phone;
            $country = $request->country;
            $status = $request->status;
            $role = $request->role;
            $updated_at = Carbon::now();

            DB::table('users')->where('id', $id)->update([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'country' => $country,
                'status' => $status,
                'role' => $role,
                'user_avatar' => $user_avatar,
                'updated_at' => $updated_at,
            ]);

            DB::table('logs')->insert([
                'name' => 'user',
                'description' => __('logs.user.updated', ['name' => $user->name]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return back()->with('success', __('users.updated-success'));
        } else {
            return back();
        }
    }

    /**
     * Remove user avatar
     */
    public function deleteAvatar(Request $request, $id) {
        DB::table('users')->update(['user_avatar' => null]);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if (!empty($user->user_avatar)) {
            $directory = dirname($user->user_avatar); // 'avatars/groups/Group One'
            File::exists($directory);
            File::deleteDirectory(public_path($directory));
        }

        DB::table('logs')->insert([
            'name' => 'user',
            'description' => __('logs.user.deleted', ['name' => $user->name]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user->delete();


        return back()->with('success', __('users.deleted'));
    }
}
