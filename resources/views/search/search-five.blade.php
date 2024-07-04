<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>5日間天気予報</title>

    <!-- cssファイル作ったらhref="{{ asset('css/cssファイル名') }}入れないとcssファイルと同期しない-->
    <link rel="stylesheet" href="{{ asset('css/fivedays.styles.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="logo">WeatherSite</div>
        <nav>
            <ul>
                <li><a href="/home">ホーム</a></li>
                {{-- a herf="/リンク名" = web.phpとルーティングする：ドットインストール＃15 詳細ページへのリンクをつくろう --}}
                <li><a href="/rainradar">雨雲レーダー</a></li>
                <li><a href="/fivedays">5日間予報</a></li>
            </ul>
        </nav>
        <div class="user-menu">
            <a href="#">ログイン</a>
        </div>
    </header>

    <!-- Main Section -->
    <main>
        <section class="block">
            <h1>{{ $location }}の5日間天気予報</h1>
            @if(isset($forecastData))
                @foreach ($forecastData['forecast']['forecastday'] as $forecast)
                    @php
                    //Controller.phpのuse Carbon\Carbon;　＝　曜日
                        $date = \Carbon\Carbon::parse($forecast['date']);
                        $dayOfWeek = ['日', '月', '火', '水', '木', '金', '土'][$date->dayOfWeek];
                    @endphp
                    <div class="forecast">
                        {{-- ↓ classを設定することによってcssの .forecast .date{} と繋がる --}}
                        <p class="date">
                            {{ \Carbon\Carbon::parse($forecast['date'])->format('Y年m月d日') }}
                            ({{ \Carbon\Carbon::parse($forecast['date'])->isoFormat('ddd') }})
                        </p>
                        {{-- Font Awesomeではなく、Weather APIが提供するアイコン画像 --}}
                        <img src="{{ $forecast['day']['condition']['icon'] }}" alt="Weather Icon">

                        <p>温度: {{ $forecast['day']['avgtemp_c'] }}°C</p>
                        <p>天気: {{ $forecast['day']['condition']['text'] }}</p>
                        <p>湿度: {{ $forecast['day']['avghumidity'] }}%</p>
                        <p>風速: {{ $forecast['day']['maxwind_kph'] }} km/h</p>
                    </div>
                @endforeach
            @elseif(isset($error))
                <p>{{ $error }}</p>
            @endif
        </section>
    </main>

    <!-- Fotter Section -->
    <footer>
        <ul>
            <li><a href="#">サイトマップ</a></li>
            <li><a href="#">プライバシーポリシー</a></li>
            <li><a href="#">お問い合わせ</a></li>
        </ul>
    </footer>
</body>
</html>
