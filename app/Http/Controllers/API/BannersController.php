<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Video;
use Illuminate\Http\Request;

class BannersController extends Controller
{
    public function getBanners(Request $request) {
        $banners = Banner::all();
        if (!empty($banners) && count($banners) > 0) {
            $response['success'] = 'Success';
            $response['message'] = 'Banners Data';
            $response['banners'] = $banners;
        } else {
            $response['faild'] = 'Faild';
            $response['message'] = 'No Banners';
        }
        return response()->json($response);
    }
}
