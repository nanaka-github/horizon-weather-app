<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FiveDaysController extends Controller
{
    public function showForm()
    {
        return view('fivedays');
    }

    public function searchFive(Request $request)
    {
        $location = $request->input('location');
        $apiKey = env('WEATHERAPI_KEY');

        // 地名をURLエンコードする
        $encodedLocation = urlencode($location);

        //http://api.weatherapi.com/v1/forecast.json?key={YOUR_API_KEY}&q={CITY}&days=5&lang=ja （$responce内をまとめたもの）= APIエンドポイント
        $response = Http::get("http://api.weatherapi.com/v1/forecast.json", [
            'key' => $apiKey,
            'q' => $location,
            'days' => 5,
            'lang' => 'ja'
        ]);

        if ($response->successful()) {
            $forecastData = $response->json();

             // レスポンスデータをログに記録
            \Log::info('Forecast API Response:', $forecastData);
            // -> このコードを追加することで、APIから取得したデータがLaravelのログに記録される。ログファイルはstorage/logs/laravel.logへ。

            //view名を正式なファイル名（検索結果後のviewファイル名）にしないと映らない
            return view('search.search-five', [
                'forecastData' => $forecastData,
                'location' => $location
            ]);
        } else {
            return view('search.search-five', [
                'error' => '天気データの取得に失敗しました。',
                'location' => $location // ここで location を渡す
            ]);
        }
    }
}
