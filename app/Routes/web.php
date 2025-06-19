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
  
  // 一般/管理者＝ログイン必須
  Route::middleware(['auth'])->group(function() {
      Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
      Route::get('/houses/{id}/reservations/input', [ReservationController::class, 'input'])->name('reservations.input');
      Route::get('/houses/{id}/reservations/confirm', [ReservationController::class, 'confirm'])->name('reservations.confirm');
      // Route::post('/houses/{id}/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
      Route::get('/user',        [UserController::class, 'index'])->name('user.index');
      Route::get('/user/edit',   [UserController::class, 'edit'])->name('user.edit');
      Route::post('/user/update',[UserController::class, 'update'])->name('user.update');
  });
  
  // 管理者だけ許可 (クロージャミドルウェア)
  Route::prefix('admin/houses')->middleware([
      'auth',
      function ($request, $next) {
          if (!Auth::user() || Auth::user()->role->name !== 'ADMIN') {
              abort(403);
          }
          return $next($request);
      }
  ])->group(function () {
      Route::get('/', [AdminHouseController::class, 'index'])->name('admin.houses.index');
      Route::get('/{id}', [AdminHouseController::class, 'show'])->name('admin.houses.show');
      Route::get('/register', [AdminHouseController::class, 'create'])->name('admin.houses.create');
      Route::post('/create', [AdminHouseController::class, 'store'])->name('admin.houses.store');
      Route::get('/{id}/edit', [AdminHouseController::class, 'edit'])->name('admin.houses.edit');
      Route::post('/{id}/update', [AdminHouseController::class, 'update'])->name('admin.houses.update');
      Route::post('/{id}/delete', [AdminHouseController::class, 'destroy'])->name('admin.houses.destroy');
      Route::get('/login', [AuthController::class, 'login']);
      Route::get('/signup', [AuthController::class, 'signup']);
      Route::post('/signup', [AuthController::class, 'postSignup']);
      Route::get('/signup/verify', [AuthController::class, 'verify']);
      Route::get('/houses', [HouseController::class, 'index'])->name('houses.index');
      Route::get('/houses/{id}', [HouseController::class, 'show'])->name('houses.show');
      Route::post('/houses/{houseId}/review', [ReviewController::class, 'store'])->middleware('auth');
      Route::post('/houses/{houseId}/review/{reviewId}/edit', [ReviewController::class, 'update'])->middleware('auth');
      Route::post('/houses/{houseId}/review/{reviewId}/delete', [ReviewController::class, 'destroy'])->middleware('auth');
      Route::post('/houses/{houseId}/favorite', [FavoriteController::class, 'toggle'])->middleware('auth');
  });

