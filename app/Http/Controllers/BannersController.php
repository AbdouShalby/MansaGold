<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BannersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::all()->sortDesc();
        return view('banner/all', [
            'banners' => $banners
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('banner/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'banner' => 'required|mimes:jpeg,jpg,png,gif|max:100000',
            'banner_status' => 'required',
            'banner_url' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $banner = new Banner();
        $path = $request->file('banner')->store('/avatars/banners/' . Str::random(15), ['disk' => 'my_files']);
        $banner->banner_path = $path;
        $banner->banner_status = $request->banner_status;
        $banner->banner_url = $request->banner_url;
        $banner->save();

        return back()->with('success', __('banner.added-success'));
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
        $banner = Banner::where('id', $id)->get()->first();
        return view('banner/edit', [
            'banner' => $banner
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $banner = Banner::where('id', $id)->get()->first();

        if (!empty($banner)) {
            $validator = Validator::make($request->all(), [
                'banner_status' => 'required',
                'banner_url' => 'sometimes|string',
            ]);

            $status = $request->banner_status;
            $url = $request->banner_url;
            $updated_at = Carbon::now();

            DB::table('banners')->where('id', $id)->update([
                'banner_status' => $status,
                'banner_url' => $url,
                'updated_at' => $updated_at,
            ]);

            return back()->with('success', __('banner.updated-success'));
        } else {
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = Banner::findOrFail($id);

        if (!empty($banner->banner_path)) {
            $directory = dirname($banner->banner_path); // 'avatars/groups/Group One'
            File::exists($directory);
            File::deleteDirectory(public_path($directory));
        }

        $banner->delete();

        return back()->with('success', __('banner.deleted'));
    }
}
