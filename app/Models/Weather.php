<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//migration table完了ー> #05 データ操作
// ./vendor/bin/sail artisan make:model Weather(<-頭大文字・単数系)
//モデルの名前を Weather としたことで、weather テーブルに紐付けてくれるという仕組みになっている
class Weather extends Model
{
    use HasFactory;
}
//このモデルを使ってデータの操作をしたい ターミナルからインタラクティブにデータを操作するためのコマンドが用意されています。
//./vendor/bin/sail tinker
