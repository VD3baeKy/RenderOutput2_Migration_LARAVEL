<?

  use app\http\Controllers\Admin\AdminHouseController;

  Route::prefix('admin/houses')->group(function () {
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
  });
}



