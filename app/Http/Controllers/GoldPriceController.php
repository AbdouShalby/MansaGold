<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GoldPriceController extends Controller
{
    // $accessToken = env('GOLD_PRICES_API_TOKEN');
    public function getXauPrices()
    {
        $prices = [];
        $baseURL = 'https://www.goldapi.io/api';
        $accessToken = env('GOLD_PRICES_API_TOKEN');

        $response = Http::withHeaders([
            'x-access-token' => $accessToken,
        ])->get($baseURL . "/XAU/USD");

        if ($response->failed()) {
            $prices['success'] = false;
        }
        else{
            $data = $response->json();
            $prices['usd']['price_gram_24k'] = $data['price_gram_24k'];
            $prices['usd']['price_gram_22k'] = $data['price_gram_22k'];
            $prices['usd']['price_gram_21k'] = $data['price_gram_21k'];
            $prices['usd']['price_gram_20k'] = $data['price_gram_20k'];
            $prices['usd']['price_gram_18k'] = $data['price_gram_18k'];

        }

        $response = Http::withHeaders([
            'x-access-token' => $accessToken,
        ])->get($baseURL . "/XAU/EUR");

        if ($response->failed()) {
            $prices['success'] = false;
        }
        else{
            $data = $response->json();
            $prices['eur']['price_gram_24k'] = $data['price_gram_24k'];
            $prices['eur']['price_gram_22k'] = $data['price_gram_22k'];
            $prices['eur']['price_gram_21k'] = $data['price_gram_21k'];
            $prices['eur']['price_gram_20k'] = $data['price_gram_20k'];
            $prices['eur']['price_gram_18k'] = $data['price_gram_18k'];
        }

        $GRAMs = ['price_gram_24k','price_gram_22k','price_gram_21k','price_gram_20k','price_gram_18k'];
        foreach($GRAMs as $g)
        {
            DB::table('gold_prices')->insert([
                'name' => $g,
                'dollar' => 'USD',
                'dollar_price' => $prices['usd'][$g],
                'euro' => 'EUR',
                'euro_price' => $prices['eur'][$g],
                'dinar' => '',
                'dinar_price' => 0.0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
        return $prices;
    }
}
