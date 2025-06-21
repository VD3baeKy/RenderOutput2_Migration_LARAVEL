<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AdminHouseController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\AuthController;

// 公開（認証不要）
Route::get('/reviews', [ReviewsController::class, 'index'])->name('reviews.index');
Route::post('/stripe/webhook', [StripeWebhookController::class, 'webhook']); // CSRF除外はVerifyCsrfToken.phpへ

// 認証必須（一般ユーザー/管理者）
Route::middleware(['auth'])->group(function() {
    // 予約
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/houses/{house}/reservations/input', [ReservationController::class, 'input'])->name('reservations.input');
    Route::get('/houses/{house}/reservations/confirm', [ReservationController::class, 'confirm'])->name('reservations.confirm');
    // ユーザー
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/update', [UserController::class, 'update'])->name('user.update');
    // レビュー（レビュー登録・編集・削除）
    Route::post('/houses/{house}/review', [ReviewController::class, 'store'])->name('review.store');
    Route::post('/houses/{house}/review/{review}/edit', [ReviewController::class, 'update'])->name('review.update');
    Route::post('/houses/{house}/review/{review}/delete', [ReviewController::class, 'destroy'])->name('review.destroy');
    // お気に入り
    Route::post('/houses/{house}/favorite', [FavoriteController::class, 'toggle'])->name('favorite.toggle');
});

// 管理者専用
Route::prefix('admin/houses')->middleware([
    'auth',
    function ($request, $next) {
        if (!Auth::user() || (method_exists(Auth::user(), 'role') && Auth::user()->role->name !== 'ADMIN')) {
            abort(403);
        }
        return $next($request);
    }
])->group(function () {
    // 管理者用ハウス管理
    Route::get('/', [AdminHouseController::class, 'index'])->name('admin.houses.index');
    Route::get('/register', [AdminHouseController::class, 'create'])->name('admin.houses.create');
    Route::post('/create', [AdminHouseController::class, 'store'])->name('admin.houses.store');
    Route::get('/{id}', [AdminHouseController::class, 'show'])->name('admin.houses.show');
    Route::get('/{id}/edit', [AdminHouseController::class, 'edit'])->name('admin.houses.edit');
    Route::post('/{id}/update', [AdminHouseController::class, 'update'])->name('admin.houses.update');
    Route::post('/{id}/delete', [AdminHouseController::class, 'destroy'])->name('admin.houses.destroy');
});

// 認証・会員登録（管理画面入口含む）
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/signup', [AuthController::class, 'signup'])->name('signup');
Route::post('/signup', [AuthController::class, 'postSignup'])->name('signup.post');
Route::get('/signup/verify', [AuthController::class, 'verify'])->name('signup.verify');

// 一般ハウス検索・詳細（公開）
Route::get('/houses', [HouseController::class, 'index'])->name('houses.index');
Route::get('/houses/{id}', [HouseController::class, 'show'])->name('houses.show');

