<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminHouseController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FaboritesController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

// 公開（認証不要）
Route::get('/reviews', [ReviewsController::class, 'index'])->name('reviews.index');
Route::post('/stripe/webhook', [StripeWebhookController::class, 'webhook']); // CSRF除外はVerifyCsrfToken.phpへ
Route::get('/', function () {
    return view('index'); // resources/views/index.blade.php を表示
});
Route::get('/', [HomeController::class, 'index']);
Auth::routes();

// 認証必須（一般ユーザー/管理者）
Route::middleware(['auth'])->group(function() {
    // 予約一覧
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    // 予約内容確認画面への遷移（POST）
    Route::post('/houses/{house}/reservations/input', [ReservationController::class, 'input'])->name('houses.reservations.input');
    // 予約内容確認画面（GET）
    Route::get('/houses/{house}/reservations/confirm', [ReservationController::class, 'confirm'])->name('reservations.confirm');
    // 決済
    Route::post('/houses/{house}/reservations/pay', [ReservationController::class, 'pay'])->name('reservations.pay');
    // ユーザー
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/update', [UserController::class, 'update'])->name('user.update');
    Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');
// レビュー（レビュー登録・編集・削除）
    Route::post('/houses/{house}/review', [ReviewController::class, 'store'])->name('review.store');
    Route::post('/houses/{house}/review/{review}/edit', [ReviewController::class, 'update'])->name('review.update');
    Route::post('/houses/{house}/review/{review}/delete', [ReviewController::class, 'destroy'])->name('review.destroy');
    // お気に入り
    Route::post('/houses/{house}/favorite', [FaboritesController::class, 'toggle'])->name('faborite.toggle');
    Route::get('/favorites', [FaboritesController::class, 'index'])->name('faborites.index');
});
    // お気に入り追加
    Route::get('/houses/{house}/favorite/{user}/add', [App\Http\Controllers\HouseController::class, 'favoriteAdd'])->name('houses.favorite.add');
    // お気に入り解除
    Route::get('/houses/{house}/favorite/{user}/remove', [App\Http\Controllers\HouseController::class, 'favoriteRemove'])->name('houses.favorite.remove');

// 管理者専用
Route::prefix('admin')->middleware(['auth', 'is_admin'])->name('admin.')->group(function () {
    // ユーザー管理
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [AdminUserController::class, 'show'])->name('users.show');
    Route::get('/users/{id}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // 民宿管理
    Route::get('/houses', [AdminHouseController::class, 'index'])->name('houses.index');
    Route::get('/houses/create', [AdminHouseController::class, 'create'])->name('houses.create');
    Route::post('/houses', [AdminHouseController::class, 'store'])->name('houses.store');
    Route::get('/houses/{id}', [AdminHouseController::class, 'show'])->name('houses.show');
    Route::get('/houses/{id}/edit', [AdminHouseController::class, 'edit'])->name('houses.edit');
    Route::put('/houses/{id}', [AdminHouseController::class, 'update'])->name('houses.update');
    Route::delete('/houses/{id}', [AdminHouseController::class, 'destroy'])->name('houses.destroy');
});

// 認証・会員登録（管理画面入口含む）
Route::get('/login', [AuthController::class, 'login'])->name('login'); // 独自ログイン画面
Route::post('/login', [LoginController::class, 'login']); // POSTはLaravel標準のLoginControllerを使う
Route::get('/signup', [AuthController::class, 'signup'])->name('signup');
Route::post('/signup', [AuthController::class, 'postSignup'])->name('signup.post');
Route::get('/signup/verify', [AuthController::class, 'verify'])->name('signup.verify');
Route::get('/register', [AuthController::class, 'signup'])->name('register');

// 一般ハウス検索・詳細（公開）
Route::get('/houses', [HouseController::class, 'index'])->name('houses.index');
Route::get('/houses/{id}', [HouseController::class, 'show'])->name('houses.show');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
