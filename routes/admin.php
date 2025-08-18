<?php

/** Admin Routes */

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\AdminVendorProfileController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ChildCategoryController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\ProudctController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\SubCategoryController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['guest:admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
  //Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
  Route::get('login', [AdminController::class, 'login'])
    ->name('login'); // عرض صفحة تسجيل الدخول

});

Route::group(['middleware' => ['auth', 'role:admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
  Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
  Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
  Route::post('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
  Route::post('/profile/update/password', [ProfileController::class, 'updatePassword'])->name('password.update');
  /** Sliders Routes */
  Route::resource('slider', SliderController::class);
  /** Categories Routes */
  Route::put('change-status', [CategoryController::class, 'changeStatus'])->name('category.change-status');
  Route::resource('category', CategoryController::class);
  /** Sub Categories Routes */
  Route::put('sub-category-change-status', [SubCategoryController::class, 'changeStatus'])->name('sub-category-change-status');
  Route::resource('sub-category', SubCategoryController::class);
  /** Child Categories Routes */
  Route::put('child-category-change-status', [ChildCategoryController::class, 'changeStatus'])->name('child-category-change-status');
  Route::get('get-subcategories', [ChildCategoryController::class, 'getSubCategories'])->name('get-subcategories'); // فلترة الفئات الفرعيةبناءا على الفئة الرئيسية
  Route::resource('child-category', ChildCategoryController::class);
  /** Brands Routes */
  Route::put('/brand/change-status', [BrandController::class, 'changeStatus'])->name('brand.change-status');
  Route::resource('brand', BrandController::class);
  /** Vendor Profile routes */
  Route::resource('vendor-profile', AdminVendorProfileController::class);
  /** Products routes routes */
  Route::get('product/get-subcategories', [ProudctController::class, 'getSubCategories'])->name('product.get-subcategories');
  Route::get('product/get-child-categories', [ProudctController::class, 'getChildCategories'])->name('product.get-child-categories');
  Route::put('product/change-status', [ProudctController::class, 'changeStatus'])->name('product.change-status');
  Route::resource('products', ProudctController::class);
});
