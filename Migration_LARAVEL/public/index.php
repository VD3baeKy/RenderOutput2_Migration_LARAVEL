<?php

  // アプリケーションの開始時間を記録します（後で処理時間をはかる用）
  define('LARAVEL_START', microtime(true));
  
  // Composerの自動ローダーを読み込みます
  // （使うライブラリやクラスを自動で見つけてくれる仕組み）
  require __DIR__.'/../vendor/autoload.php';
  
  // Laravelアプリケーション本体を生成します（設定やルート情報を読み込む）
  $app = require_once __DIR__.'/../bootstrap/app.php';
  
  // HTTPリクエストを処理するカーネル（エンジン）を作ります
  $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
  
  // 現在のリクエスト（アクセス）情報を取得して、アプリで処理して、レスポンスを返す
  $response = $kernel->handle(
      $request = Illuminate\Http\Request::capture()
  )->send();
  
  // 処理終了後に、後片付けを行います（セッション保存やログの書き込みなど）
  $kernel->terminate($request, $response);
