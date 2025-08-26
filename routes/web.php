<?php

use App\Http\Controllers\Frontend\FlashSaleController;
use App\Http\Controllers\Frontend\FrontentProductController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\UserDashboardController;
use App\Http\Controllers\Frontend\UserProfileControllrt;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/flash-sale', [FlashSaleController::class, 'index'])->name('flash-sale.index');
/** Product detail route */
Route::get('/product-detail/{slug}', [FrontentProductController::class, 'showProduct'])->name('product-detail.index');



Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/vendor.php';

Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'user', 'as' => 'user.'], function () {
  Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
  Route::get('/profile', [UserProfileControllrt::class, 'index'])->name('profile');
  Route::post('/profile', [UserProfileControllrt::class, 'updateProfile'])->name('profile.update');
  Route::post('/profile/update/password', [UserProfileControllrt::class, 'updatePassword'])->name('password.update');
});
