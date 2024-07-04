<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>雨雲レーダー</title>

    <!-- cssファイル作ったらhref="{{ asset('css/cssファイル名') }}入れないとcssファイルと同期しない-->
    <link rel="stylesheet" href="{{ asset('css/rainradar.styles.css') }}">
    
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
            <h1>{{ $location }}の雨雲レーダー</h1>
            @if (isset($mapUrl))
                <div class="radar-map">
                    <img src="{{ $mapUrl }}" alt="Rain Radar">
                </div>
            @elseif (isset($error))
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
