<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RainRadarController extends Controller
{
    public function showForm()
    {
        return view('rainradar');
    }

    public function searchRadar(Request $request)
    {
        $location = $request->input('location');
        $apiKey = env('WEATHERAPI_KEY');

        //API
        $weatherResponse = Http::get("http://api.weatherapi.com/v1/current.json", [
            'key' => $apiKey,
            'q' => $location,
            'lang' => 'ja'
        ]);

        if ($weatherResponse->successful()) {
            $weatherData = $weatherResponse->json();
            $lat = $weatherData['location']['lat'];
            $lon = $weatherData['location']['lon'];

            // 静的マップ画像のURLを生成
            $mapUrl = "https://storage.tenki.jp/archive/radar/2020/04/12/15/00/00/japan-detail-large.jpg";

            //view名を正式なファイル名（検索結果後のviewファイル名）にしないと映らない
            return view('search.search-radar', [
                'mapUrl' => $mapUrl,
                'location' => $location
            ]);
        } else {
            return view('search.search-radar', ['error' => '天気データの取得に失敗しました。']);
        }
    }
}
