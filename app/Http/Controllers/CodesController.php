<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\Group;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CodesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $codes = Code::all()->sortDesc();
        return view('code/all', [
            'codes' => $codes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $groups = Group::where('group_status', '=', 0)->get();
        return view('code/create', [
            'groups' => $groups
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required|string|size:16',
            'group' => 'required|exists:groups,id',
            'balance' => 'required|min:1',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $code = new Code();
        $code->code_key = $request->key;
        $code->group_id = $request->group;
        $code->code_balance = $request->balance;
        $code->save();

        return back()->with('success', __('codes.added-success'));
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
        $code = Code::where('id', $id)->get()->first();
        $groups = Group::where('group_status', '=', 0)->get();
        $code_group = Group::where('id', $code->group_id)->get()->first();
        return view('code/edit', [
            'code' => $code,
            'groups' => $groups,
            'code_group' => $code_group
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

            return back()->with('success', __('users.updated-success'));
        } else {
            return back();
        }
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

        $user->delete();


        return back()->with('success', __('users.deleted'));
    }
}
