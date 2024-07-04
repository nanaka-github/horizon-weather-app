<?php
// Contorollerファイル：web.php はあくまでもルーティングを定義するためのファイルなので、ルートのコードが長くなってくると見通しが悪くなってしまう
// そのためルーティングごとの処理は、Controllerと呼ばれるファイルに置くことが推奨されている
// web.php から呼び出していて、web.phpと.blade.phpとの仲介役

// ドットインストール 基本機能＃13、＃14 Controllerのメソッドを作ろう

// 'Controlleファイル'：直接いじらなくてもこのファイルがないとHomeControllerファイルもエラーになる

namespace App\Http\Controllers;

use Illuminate\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon; //このコードでは、 \Carbon\Carbon::parse を使用して日付を解析し、 dayOfWeek プロパティを使用して対応する曜日を取得しています


// HomeController クラス = ホーム画面に関連する動きや処理をまとめるところ
// classの特徴：
// 1. 再利用性：一度定義したクラスを再利用することで、同じコードを繰り返し書く必要がなくなります。
// 2. 整理整頓：関連するデータとメソッドを一つのクラスにまとめることで、コードが整理され、読みやすくなります。
// 3. 拡張性：クラスを拡張して、新しい機能を追加することが容易になります。

class HomeController extends Controller
{
    // ナビゲーションメニューの項目
    protected $nav = [
        'Home',
        'Rain Radar',
        'Five Days'
    ];

    public function home()
    {
        // 挨拶メッセージを取得
        $greetingMessage = $this->getGreetingMessage();
        // 今日の日付を取得
        $currentDate = now()->format('Y年n月j日');
        // 曜日を取得
        $dayOfWeek = now()->dayOfWeek;
        // 曜日を日本語に変換
        $daysOfWeek = ['日曜日', '月曜日', '火曜日', '水曜日', '木曜日', '金曜日', '土曜日'];
        $dayOfWeekJapanese = $daysOfWeek[$dayOfWeek];
        // 最終的なメッセージを作成
        $finalGreetingMessage = $greetingMessage . "今日は{$currentDate}、{$dayOfWeekJapanese}です。";

        return view('home')->with([
            'nav' => $this->nav,
            'greetingMessage' => $finalGreetingMessage
        ]);
    }

    public function rainradar()
    {
        return view('rainradar')->with(['nav' => $this->nav]);
    }

    public function fivedays()
    {
        return view('fivedays')->with(['nav' => $this->nav]);
    }

    public function search(Request $request)
    {
        $location = $request->input('location');
        $weather = $this->getWeather($location);

        if ($weather && isset($weather['current'])) {
            // 気温に合った服装指数
            $clothesRecommendation = $this->getClothesRecommendation($weather['current']['temp_c']);
            // 天気アイコンを取得
            $weatherIcon = $this->getWeatherIcon($weather['current']['condition']['text']);
            // 服装アイコンを取得
            $clothesIcon = $this->getClothesIcon($weather['current']['temp_c']);

            //view名を正式なファイル名（検索結果後のviewファイル名）にしないと映らない
            //view('searchフォルダの中の.searchファイル')
            return view('search.search')->with([
                'weather' => $weather,
                'clothesRecommendation' => $clothesRecommendation,
                'clothesIcon' => $clothesIcon,
                'weatherIcon' => $weatherIcon,
                'nav' => $this->nav
            ]);
        } else {
            $error = 'この場所の天気データは見つかりませんでした。';
            if ($weather) {
                $error = 'APIエラーが発生しました。';
            }

            return view('home.search')->with('error', $error)->with('nav', $this->nav);
        }
    }

    // 天気API取得
    private function getWeather($location)
    {
        $apiKey = env('WEATHERAPI_KEY');

        //api current=現在の天気
        $response = Http::get("http://api.weatherapi.com/v1/current.json", [
            'key' => $apiKey,
            'q' => $location,
            'lang' => 'ja'
        ]);

         // レスポンスデータをログに記録
        \Log::info('Weather API Response:', $response->json());
        // -> このコードを追加することで、APIから取得したデータがLaravelのログに記録される。ログファイルはstorage/logs/laravel.logへ。

        if ($response->successful()) {
            return $response->json();
        }

        \Log::error('Weather API Error:', ['response' => $response->body()]);
        return null;
    }


    // 服装指数を取得
    private function getClothesRecommendation($temperature)
    {
        if ($temperature >= 30) {
            return 'タンクトップ';
        } elseif ($temperature >= 25) {
            return '半袖シャツ';
        } elseif ($temperature >= 20) {
            return '長袖シャツ';
        } elseif ($temperature >= 15) {
            return 'ベスト';
        } elseif ($temperature >= 10) {
            return 'ジャケット';
        } elseif ($temperature >= 5) {
            return 'イヤーマフ';
        } else {
            return '防寒手袋';
        }
    }

    // APIの天気に合わせた天気アイコンを取得
    private function getWeatherIcon($description)
    {
        switch (strtolower($description)) {
            case '晴れ':
                return ['icon' => 'fa-sun', 'class' => 'sun'];
            case '所により曇り':
                return ['icon' => 'fa-cloud-sun', 'class' => 'cloud-sun'];
            case '曇り':
            case '本曇り':
                return ['icon' => 'fa-cloud', 'class' => 'cloud'];
            case '近くで所により雨':
                return ['icon' => 'fa-cloud-sun-rain', 'class' => 'cloud-sun-rain'];
            case '弱い雨':
            case '軽いにわか雨':
                return ['icon' => 'fa-cloud-rain', 'class' => 'cloud-rain'];
            case '雨':
            case '強い雨':
                return ['icon' => 'fa-cloud-showers-heavy', 'class' => 'cloud-showers-heavy'];
            case '雷':
                return ['icon' => 'fa-bolt', 'class' => 'bolt'];
            case '雪':
            case '大雪':
                return ['icon' => 'fa-snowflake', 'class' => 'snowflake'];
            default:
                return ['icon' => 'fa-cloud', 'class' => 'cloud'];
        }
    }

    // 服装指数アイコンを取得
    private function getClothesIcon($temperature)
    {
        if ($temperature >= 30) {
            return 'fa-solid fa-shirt-tank-top';
        } elseif ($temperature >= 25) {
            return 'fa-solid fa-shirt';
        } elseif ($temperature >= 20) {
            return 'fa-solid fa-shirt-long-sleeve';
        } elseif ($temperature >= 15) {
            return 'fa-solid fa-vest';
        } elseif ($temperature >= 10) {
            return 'fa-solid fa-jacket';
        } elseif ($temperature >= 5) {
            return 'fa-solid fa-ear-muffs';
        } else {
            return 'fa-solid fa-mitten';
        }
    }

    // 挨拶メッセージを取得
    private function getGreetingMessage()
    {
        $currentHour = Carbon::now()->hour;

        if ($currentHour >= 6 && $currentHour < 12) {
            return 'おはようございます！今日も素晴らしい一日をスタートしましょう。';
        } elseif ($currentHour >= 12 && $currentHour < 17) {
            return 'こんにちは！午後も元気に過ごしましょう！';
        } elseif ($currentHour >= 17 && $currentHour < 20) {
            return 'こんばんは！もうひと踏ん張り、頑張りましょう！';
        } elseif ($currentHour >= 20 && $currentHour < 24) {
            return 'お疲れ様でした！一日の頑張りを振り返りましょう。';
        } else {
            return '夜静かな夜にリラックスして過ごしましょう。';
        }
    }
}
?>
