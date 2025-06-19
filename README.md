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


