<?php

use App\Http\Controllers\Frontend\NewsletterController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\FlashSaleController;
use App\Http\Controllers\Frontend\FrontentProductController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Frontend\UserAddressController;
use App\Http\Controllers\Frontend\UserDashboardController;
use App\Http\Controllers\Frontend\UserOrderController;
use App\Http\Controllers\Frontend\UserProfileControllrt;
use App\Http\Controllers\Frontend\UserVendorReqeustController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Frontend\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/flash-sale', [FlashSaleController::class, 'index'])->name('flash-sale.index');
/** Product route */
Route::get('products', [FrontentProductController::class, 'productsIndex'])->name('products.index');
Route::get('/product-detail/{slug}', [FrontentProductController::class, 'showProduct'])->name('product-detail');
Route::get('change-product-list-view', [FrontentProductController::class, 'chageListView'])->name('change-product-list-view');

/** Cart routes */
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add-to-cart');
Route::get('/cart-details', [CartController::class, 'cartDetails'])->name('cart-details');
Route::post('cart/update-quantity', [CartController::class, 'updateProductQty'])->name('cart.update-quantity');
Route::get('clear-cart', [CartController::class, 'clearCart'])->name('clear.cart');
Route::get('cart/remove-product/{rowId}', [CartController::class, 'removeProduct'])->name('cart.remove-product');
Route::get('cart-count', [CartController::class, 'getCartCount'])->name('cart-count');
Route::get('cart-products', [CartController::class, 'getCartProducts'])->name('cart-products');
Route::post('cart/remove-sidebar-product', [CartController::class, 'removeSidebarProduct'])->name('cart.remove-sidebar-product');
Route::get('cart/sidebar-product-total', [CartController::class, 'cartTotal'])->name('cart.sidebar-product-total');
Route::get('apply-coupon', [CartController::class, 'applyCoupon'])->name('apply-coupon');
Route::get('coupon-calculation', [CartController::class, 'couponCalculation'])->name('coupon-calculation');
/** add product in wishlist */
Route::get('wishlist/add-product', [WishlistController::class, 'addToWishlist'])->name('wishlist.store');
/** NewsLetter */
Route::post('newsletter-request', [NewsletterController::class, 'newsLetterRequset'])->name('newsletter-request');
Route::get('newsletter-verify/{token}', [NewsletterController::class, 'newsLetterEmailVarify'])->name('newsletter-verify');
/** vendor page routes */
Route::get('vendorIndex', [HomeController::class, 'vendorPage'])->name('vendor.index');
Route::get('vendor-product/{id}', [HomeController::class, 'vendorProductsPage'])->name('vendor.products');


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
  /** User Address Route */
  Route::resource('address', UserAddressController::class);
  /** Checkout routes */
  Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout');
  Route::post('checkout/address-create', [CheckOutController::class, 'createAddress'])->name('checkout.address.create');
  Route::post('checkout/form-submit', [CheckOutController::class, 'checkOutFormSubmit'])->name('checkout.form-submit');
  /** Payment Routes */
  Route::get('payment', [PaymentController::class, 'index'])->name('payment');
  Route::get('payment-success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');

  Route::get('paypal/payment', [PaymentController::class, 'payWithPaypal'])->name('paypal.payment');
  Route::get('paypal/success', [PaymentController::class, 'paypalSuccess'])->name('paypal.success');
  Route::get('paypal/cancel', [PaymentController::class, 'paypalCancel'])->name('paypal.cancel');
  /** Stripe routes */
  Route::post('stripe/payment', [PaymentController::class, 'payWithStripe'])->name('stripe.payment');
  /** Order Routes */
  Route::get('orders', [UserOrderController::class, 'index'])->name('orders.index');
  Route::get('orders/show/{id}', [UserOrderController::class, 'show'])->name('orders.show');
  /** Wishlist routes */
  Route::get('wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
  Route::get('wishlist/remove-product/{id}', [WishlistController::class, 'destory'])->name('wishlist.destory');
  /** product review routes */
  Route::get('reviews', [ReviewController::class, 'index'])->name('review.index');
  Route::post('review', [ReviewController::class, 'create'])->name('review.create');

  /** Vendor request route */
  Route::get('vendor-request', [UserVendorReqeustController::class, 'index'])->name('vendor-request.index');
  Route::post('vendor-request', [UserVendorReqeustController::class, 'create'])->name('vendor-request.create');
});
