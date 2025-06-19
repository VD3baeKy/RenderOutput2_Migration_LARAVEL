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
