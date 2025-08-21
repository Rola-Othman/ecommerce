<?php

/** Vendor Routes */

use App\Http\Controllers\Backend\VendorController;
use App\Http\Controllers\Backend\VendorProductController;
use App\Http\Controllers\Backend\VendorShopProfileController;
use App\Http\Controllers\Frontend\VendorProfileController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['guest:vendor', 'role:vendor'], 'prefix' => 'vendor', 'as' => 'vendor.'], function () {
  Route::get('/dashboard', [VendorController::class, 'dashboard'])->name('dashboard');
});

Route::group(['middleware' => ['auth', 'role:vendor'], 'prefix' => 'vendor', 'as' => 'vendor.'], function () {
  Route::get('/dashboard', [VendorController::class, 'dashboard'])->name('dashboard');


  Route::get('/profile', [VendorProfileController::class, 'index'])->name('profile');
  Route::post('/profile', [VendorProfileController::class, 'updateProfile'])->name('profile.update');
  Route::put('/profile', [VendorProfileController::class, 'updatePassword'])->name('password.update');
  /** Shop profile */
  Route::resource('shop-profile', VendorShopProfileController::class);
  /** Products routes */
  Route::get('product/get-subcategories', [VendorProductController::class, 'getSubCategories'])->name('product.get-subcategories');
  Route::get('product/get-child-categories', [VendorProductController::class, 'getChildCategories'])->name('product.get-child-categories');
  Route::put('product/change-status', [VendorProductController::class, 'changeStatus'])->name('product.change-status');
  Route::resource('products', VendorProductController::class);
});


// Route::get('/vendor/dashboard', [VendorController::class, 'dashboard'])->middleware(['auth', 'role:vendor','guest:admin'])->name('vendor.dashboard');