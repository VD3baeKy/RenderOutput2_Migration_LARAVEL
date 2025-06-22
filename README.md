# Spring BootをLaravelへマイグレーション
* Demonstration WEB SITE

https://vd3baeky.infinityfreeapp.com/2/public/

* Spring Boot Code (BASE CODE)

https://github.com/VD3baeKy/RenderOutput2/tree/main
 


---
## 必要なコンポーネント
```
composer require stripe/stripe-php
```

## Eventリスナー作成
```
php artisan make:listener SignupEventListener --event=SignupEvent
```
## Form Riquest 作成
```
php artisan make:request HouseEditFormRequest
php artisan make:request HouseRegisterFormRequest
php artisan make:request ReservationInputFormRequest
php artisan make:request ReviewEditFormRequest
php artisan make:request ReviewEditFormRequest2
php artisan make:request ReviewRegisterFormRequest
php artisan make:request SignupFormRequest
php artisan make:request UserEditRequest
```

## Spring Boot と Laravel における ```WebSecurityConfig``` の主な対比表
|Spring Security|Laravel|
|:---:|---|
|```.authorizeHttpRequests()```|ルーティング＋ミドルウェア（web.php, Auth, middleware）
|ロールによるアクセス制御|Middleware(```auth```, カスタム```role```), ```Gate```, ```Policy```|
|```.formLogin()```|ルートや```LoginController```、設定（```config/auth.php```等）|
|```.logout()```|ルートや```LogoutController```|
|```.csrf().ignoringRequestMatchers```|```except```例外（```VerifyCsrfToken```ミドルウェア）|
|パスワードエンコーダ|Laravelは標準で```bcrypt``` (```Hash```ファサード)| 

## Middleware
* Laravel 11では、```app/Http/Kernel.php```ファイルが完全に廃止。
* Middlewareの設定は、```bootstrap/app.php```ファイルで行うようになった。
* ```bootstrap/app.php```ファイルを使用して、グローバルMiddlewareの登録やMiddlewareグループの定義を行う。
---

```
npm init -y
npm install

npm install laravel-mix --save-dev

composer create-project laravel/laravel project_name

php artisan serve --host=0.0.0.0 --port=8000

```
