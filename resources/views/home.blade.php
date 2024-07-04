
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Information</title>
    <link rel="stylesheet" href="{{ asset('css/home.styles.css') }}">
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
        <section class="current-weather">
            <h1>お天気検索</h1>

            <div class="search-bar">

                <!-- {{ route('search') }}を入れることでsearchボタン押下後検索結果ページに遷移する-->
                <form action="{{ route('search') }}" method="GET">
                    @csrf
                    <input type="text" name="location" placeholder="地域を入力してください...">
                    <button type="submit">検索</button>
                </form>
            </div>
            <br>
            <br>
            <div class="greeting">
                <p>{{ $greetingMessage }}</p>
            </div>
        </section>

        <!-- Sidebar Section -->
        {{-- <aside>
            <section class="news">
                <h2>最新ニュース</h2>
                <ul>
                    @if(isset($news) && isset($news['articles']))
                        @foreach($news['articles'] as $article)
                            <li>
                                <a href="{{ $article['url'] }}" target="_blank">{{ $article['title'] }}</a>
                                <p>{{ $article['description'] }}</p>
                            </li>
                        @endforeach
                    @else
                        <li>ニュースを取得できませんでした。</li>
                    @endif
                </ul>
            </section>

            <section class="favorite-locations">
                <h2>登録地点の天気</h2>
                <ul>
                    <li>Tokyo: 24°C, <i class="fas fa-sun"></i></li>
                    <li>New York: 18°C, <i class="fas fa-cloud"></i></li>
                    <!-- More locations here -->
                </ul>
            </section>
        </aside> --}}
    </main>

    <!-- Footer Section -->
    <footer>
        <ul>
            <ul>
                <li><a href="#">サイトマップ</a></li>
                <li><a href="#">プライバシーポリシー</a></li>
                <li><a href="#">お問い合わせ</a></li>
            </ul>
        </ul>
    </footer>
</body>
</html>
