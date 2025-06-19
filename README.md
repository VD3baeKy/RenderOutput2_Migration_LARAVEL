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
```
