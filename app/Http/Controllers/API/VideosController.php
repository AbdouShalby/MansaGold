<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideosController extends Controller
{
    public function getVideo(Request $request) {
        $videoLang = $request->get('lang');

        if (!empty($videoLang)) {
            $video = Video::where('lang', $videoLang)->first();
            if (!empty($video)) {
                $response['success'] = 'Success';
                $response['message'] = 'Video Data';
                $response['video'] = $video;
            } else {
                $response['faild'] = 'Faild';
                $response['message'] = 'Wrong Lang';
            }
        }
        return response()->json($response);
    }
}
