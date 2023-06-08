<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoldPricesController extends Controller
{
    public function goldPrices(Request $request) {
        $goldPrices = DB::table('gold_prices')->orderBy('created_at', 'desc')->take(5)->get();
        if (!empty($goldPrices) && count($goldPrices) > 0) {
            $response['success'] = 'Success';
            $response['message'] = 'Gold Prices';
            $response['prices'] = $goldPrices;
        } else {
            $response['faild'] = 'Faild';
            $response['message'] = 'No Prices';
            $response['prices'] = [];
        }
        return response()->json($response);
    }
}
