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

        $codeData = Code::where('id', $code->id)->first();
        $groupName = Group::where('id', $codeData->group_id)->first();

        DB::table('logs')->insert([
            'name' => 'code',
            'description' => __('logs.code.inserted', ['key' => $code->code_key, 'group' => $groupName->group_name, 'balance' => $code->code_balance, 'date' => $codeData->created_at]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

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
        $code = Code::where('id', $id)->get()->first();

        if (!empty($code)) {
            $validator = Validator::make($request->all(), [
                'key' => 'required|string|size:16',
                'group' => 'required|exists:groups,id',
                'balance' => 'required|min:1',
            ]);

            $group = $request->group;
            $balance = $request->balance;
            $updated_at = Carbon::now();

            DB::table('codes')->where('id', $id)->update([
                'group_id' => $group,
                'code_balance' => $balance,
                'updated_at' => $updated_at,
            ]);

            $codeData = Code::where('id', $code->id)->first();
            $groupName = Group::where('id', $codeData->group_id)->first();

            DB::table('logs')->insert([
                'name' => 'code',
                'description' => __('logs.code.updated', ['key' => $code->code_key, 'group' => $groupName->group_name, 'balance' => $code->code_balance, 'date' => $codeData->updated_at]),
                'created_at' => $code->created_at,
                'updated_at' => now(),
            ]);

            return back()->with('success', __('codes.updated-success'));
        } else {
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $code = Code::findOrFail($id);

        $codeData = Code::where('id', $code->id)->first();
        $groupName = Group::where('id', $codeData->group_id)->first();

        DB::table('logs')->insert([
            'name' => 'code',
            'description' => __('logs.code.deleted', ['key' => $code->code_key, 'group' => $groupName->group_name, 'balance' => $code->code_balance, 'date' => $codeData->created_at]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        $code->delete();

        return back()->with('success', __('codes.deleted'));
    }
}
