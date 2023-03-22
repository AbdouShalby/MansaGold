<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all()->sortDesc();
        return view('user/all', [
            'users' => $users
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
        return view('user/edit', [
            'user' => $user
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
                'old_password' => 'required|min:6',
                'new_password' => 'required|min:6|confirmed',
                'phone' => 'required|min:10|unique:users,phone',
                'country' => 'required|string|max:40',
                'status' => 'required|boolean',
                'role' => 'required|numeric|max:1',
                'user_avatar' => 'sometimes|mimes:jpeg,jpg,png,gif|max:100000'
            ]);

            if ($request->file()) {
                $directory = dirname($user->user_avatar); // 'avatars/groups/Group One'
                if (File::exists($directory)) {
                    File::deleteDirectory(public_path($directory));
                }
                $user_avatar = $request->file('user_avatar')->store('/avatars/users/' . $user->name, ['disk' => 'my_files']);
            } else {
                $user_avatar = $user->user_avatar;
            }

            if ($request->old_password) {
                $hashed_old_password = md5($request->old_password);
                $user = User::where('id', $user->id)->first();
                if ($user->password !== $hashed_old_password) {
                    return back()->with('errors', __('groups.wrong-old-pass'));
                }
            }

            $name = $request->name;
            $email = $request->email;
            $group_status = $request->group_status;
            $updated_at = Carbon::now();

            DB::table('groups')->where('id', $id)->update([
                'group_name' => $group_name,
                'group_max_subscription' => $group_max,
                'group_status' => $group_status,
                'group_avatar' => $group_avatar,
                'updated_at' => $updated_at
            ]);

            return back()->with('success', __('groups.added-success'));
        } else {
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $group = Group::findOrFail($id);

        if (!empty($group->group_avatar)) {
            $directory = dirname($group->group_avatar); // 'avatars/groups/Group One'
            File::exists($directory);
            File::deleteDirectory(public_path($directory));
        }

        $group->delete();


        return back()->with('success', __('groups.deleted'));
    }
}
