<?php

//天気をデータベースで管理
// laravelデータベース編#2
//そのためには、データベースの設定が必要なのですが、実は既に設定されていて、 .env ファイルのこのあたりを見ると、 mysql で mybbs というデータベースが既に設定されている
//ちゃんと設定されているか、ターミナルから確認：./vendor/bin/sail mysql weather
//ログインok->今選択されているデータベースを表示するには、 SELECT DATABASE();
//ok-> SHOW TABLES; とすると...、テーブルがない状態
//Laravel ではマイグレーションという仕組みを使ってテーブルを作るのが一般的です
//./vendor/bin/sail artisan make:migration create_weather_table
//migrationファイル完了


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //upメソッド
    public function up()
    {
        //'weather'テーブルが作成されている
        Schema::create('weather', function (Blueprint $table) {

            //idカラム(column)とtimestampsカラム
            //id は主キー(primary key)で自動的に連番になるように設定されてる
            $table->id();

                  //文字列ー>string を使う
                  //日付ー>date
                  //長い文字列ー>text
            $table->string('location');
            $table->date('date');
            $table->string('weather');
            $table->string('temperature');
            $table->string('humidity');
            $table->string('wind');
            $table->text('clothes'); //服装指数

            //timestamps() は created_at, updated_at という名前でレコードの作成日時、更新日時を管理しておくためのカラム
            $table->timestamps();
        });
    }

    //downメソッド ここは触らなくておk
    public function down()
    {
        Schema::dropIfExists('weather');
    }

//Lalavelデータベース編　＃４投稿に関するテーブルを作成しよう
    //migration tableファイルが書けたら
    //ターミナル起動
    //./vendor/bin/sail artisan migrate 打ち込む
    // INFO  Running migrations 2024_06_27_103826_create_weather_table ............................................................................ 12.77ms DONE   がでたらおk
    //./vendor/bin/sail mysql weather  打ち込む　※ weatherはテーブル名
    //...mysql> が出てきたら、”SHOW TABLES;”　　打ち込む
    //Tables_in_laravel が出てきたら、”DESC weather;” 打ち込む　※ weatherはテーブル名


};
