<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RainRadarController;
use App\Http\Controllers\FiveDaysController;

//ドットインストール　基本機能＃13、＃14
// Route::get('/', ['App\Http\Controllers\HomeController', 'index']);  */1: ::classで’’がついてるのと同じ意味になる　2：::classをつけたらApp〜HomeControllerを上のuseに置ける→スッキリ！
Route::get('/', [HomeController::class, 'home']);

//Route::get('/home' =http://localhost:8573/home <-ここのhome, [HomeController::class, 'home' ="home.blade.php"のhome]);
Route::get('/home', [HomeController::class, 'home']); // {{-- a herf="/リンク名" = home.blade.phpとルーティングする：ドットインストール＃15 詳細ページへのリンクをつくろう --}} -> 詳細ページを作ろう＃16：’views’の中にファイルをそれぞれ作る

//お天気Search ボタン  GETメソッド
// Route::post('/search', [HomeController::class, 'search']);
Route::get('/search', [HomeController::class, 'search'])->name('search');



//以下「雨雲レーダー」「5日間予報」付け足したら、web.php TOPの"use App\Http\Controllers\〜Controller;"も忘れずに付け足す
//"Target class [〜Controller] does not exist.”エラーの原因になる

//雨雲レーダー
Route::get('/rainradar', [RainRadarController::class, 'showForm'])->name('rainradar');
//雨雲Search ボタン  GETメソッド
Route::get('/search-radar', [RainRadarController::class, 'searchRadar'])->name('search-radar');

//5日間予報
Route::get('/fivedays', [FiveDaysController::class, 'showForm'])->name('fivedays');
//5日間予報searchボタン　GETメソッド
Route::get('/search-five', [FiveDaysController::class, 'searchFive'])->name('search-five');



