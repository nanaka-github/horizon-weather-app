<!-- resources/views/search.blade.php -->

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>天気情報</title>
    <link rel="stylesheet" href="{{ asset('css/home.styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <<!-- Header Section -->
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
        @if (isset($weather))
            <section class="current-weather">
                <h1>天気予報 {{ $weather['location']['name'] }}</h1>
                <div class="weather-info">
                    <div class="temperature">{{ $weather['current']['temp_c'] }}°C</div>
                    <div class="weather-icon">
                        <i class="fas {{ $weatherIcon['icon'] }} {{ $weatherIcon['class'] }}"></i>
                    </div>
                    <div class="details">
                        <p>天気: {{ $weather['current']['condition']['text'] }}</p>
                        <p>湿度: {{ $weather['current']['humidity'] }}%</p>
                        <p>風力: {{ $weather['current']['wind_kph'] }} km/h</p>
                        <p>服装指数: <i class="{{ $clothesIcon }}"></i>  {{ $clothesRecommendation }}</p>
                    </div>
                </div>
            </section>
        @else
            <section class="error">
                <h1>{{ $error }}</h1>
            </section>
        @endif
    </main>

    <!-- Footer Section -->
    <footer>
        <ul>
            <li><a href="#">サイトマップ</a></li>
            <li><a href="#">プライバシーポリシー</a></li>
            <li><a href="#">お問い合わせ</a></li>
        </ul>
    </footer>
</body>
</html>
