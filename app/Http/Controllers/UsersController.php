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
            'email' => 'required|email',
            'password' => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/|confirmed',
            'phone' => 'required|numeric|min:10',
            'country' => 'required|string|max:40',
            'status' => 'required|boolean',
            'role' => 'required|numeric|max:1',
            'avatar' => 'sometimes|mimes:jpeg,jpg,png,gif|max:100000'
        ]);

        //------------------------ i'm typed all validation need to test and countinue ------------------------//

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $group = new Group();
        $group->group_name = $request->group_name;
        $group->current_subscription = 0;
        $group->group_max_subscription = $request->group_max;
        $group->group_status = 0;
        $path = $request->file('group_avatar')->store('/avatars/groups/' . $group->group_name, ['disk' => 'my_files']);
        $group->group_avatar = $path;
        $group->created_at = Carbon::now();
        $group->updated_at = Carbon::now();
        $group->save();

        return back()->with('success', __('groups.added-success'));
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
        $group = Group::where('id', $id)->get()->first();
        return view('group/edit', [
            'group' => $group
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $group = Group::where('id', $id)->get()->first();

        if (!empty($group)) {
            $validator = Validator::make($request->all(), [
                'group_name' => 'required|string|max:100|unique:groups,group_name',
                'group_max' => 'required',
                'group_status' => 'required',
                'group_avatar' => 'file'
            ]);

            if ($request->file()) {
                $directory = dirname($group->group_avatar); // 'avatars/groups/Group One'
                if (File::exists($directory)) {
                    File::deleteDirectory(public_path($directory));
                }
                $group_avatar = $request->file('group_avatar')->store('/avatars/groups/' . $group->group_name, ['disk' => 'my_files']);
            } else {
                $group_avatar = $group->group_avatar;
            }

            $group_name = $request->group_name;
            $group_max = $request->group_max;
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
