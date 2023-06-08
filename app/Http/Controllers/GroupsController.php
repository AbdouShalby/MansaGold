<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\SubscribedGroup;
use App\Models\User;
use App\Models\UserBalance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class GroupsController extends Controller
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
        $groups = Group::all()->sortDesc();
        return view('group/all', [
            'groups' => $groups
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('group/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'group_name' => 'required|string|max:100|unique:groups,group_name',
            'group_max' => 'required',
            'group_gain' => 'required',
            'group_avatar' => 'required|file'
        ]);

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
        $group->group_gain = $request->group_gain;
        $path = $request->file('group_avatar')->store('/avatars/groups/' . $group->group_name, ['disk' => 'my_files']);
        $group->group_avatar = $path;
        $group->created_at = Carbon::now();
        $group->updated_at = Carbon::now();
        $group->save();

        DB::table('logs')->insert([
            'name' => 'group',
            'description' => __('logs.group.inserted', ['name' => $group->group_name]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

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
                'group_gain' => 'required',
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
            $group_gain = $request->group_gain;
            if (($request->group_status - $group->group_status ) != 1 && $group->group_status != 2) {
                return back()->with('error', __('groups.magnificent-first'));
            }
            if($group->group_status == 2)
            {
                $group_status = 0;
            }
            else
            {
                $group_status = $request->group_status;
            }

            $updated_at = Carbon::now();

            if ($group_status == 2) {
                $subGroups = SubscribedGroup::where('group_id', $group->id)->get();
                $groupGain = DB::table('groups')->where('id', $group->id)->value('group_gain');
                foreach ($subGroups as $sub) {
                    $totalGet = ($sub->code_balance * $groupGain);
                    UserBalance::query()->where('user_id', $sub->user_id)->update([
                        'balance' => DB::raw('balance + ' . $sub->code_balance),
                        'total_get' => DB::raw('total_get + ' . $totalGet)
                    ]);
                }

                DB::table('groups')->where('id', $id)->update([
                    'group_name' => $group_name,
                    'group_max_subscription' => $group_max,
                    'group_gain' =>$group_gain,
                    'group_status' => $group_status,
                    'group_avatar' => $group_avatar,
                    'updated_at' => $updated_at
                ]);

                DB::table('logs')->insert([
                    'name' => 'group',
                    'description' => __('logs.group.updated-money', ['name' => $group->group_name]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                DB::table('groups')->where('id', $id)->update([
                    'group_name' => $group_name,
                    'group_max_subscription' => $group_max,
                    'group_gain' =>$group_gain,
                    'group_status' => $group_status,
                    'group_avatar' => $group_avatar,
                    'updated_at' => $updated_at
                ]);

                DB::table('logs')->insert([
                    'name' => 'group',
                    'description' => __('logs.group.updated', ['name' => $group->group_name]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            return back()->with('success', __('groups.updated-success'));
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

        DB::table('logs')->insert([
            'name' => 'group',
            'description' => __('logs.group.deleted', ['name' => $group->group_name]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $group->delete();

        return back()->with('success', __('groups.deleted'));
    }

    public function investor($id)
    {
        $investors = SubscribedGroup::where('group_id', $id)->orderByDesc('id')->paginate(20);
        $users = User::all();
        return view('group/investor', [
            'investors' => $investors,
            'users' => $users,
        ]);
    }
}
