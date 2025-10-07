<?php

/** Admin Routes */

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\AdminReviewController;
use App\Http\Controllers\Backend\AdminVendorProfileController;
use App\Http\Controllers\Backend\AdvertisementController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ChildCategoryController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\FlashSaleController;
use App\Http\Controllers\Backend\FooterGridThreeController;
use App\Http\Controllers\Backend\FooterGridTwoController;
use App\Http\Controllers\Backend\FooterInfoController;
use App\Http\Controllers\Backend\FooterSocialController;
use App\Http\Controllers\Backend\HomePageSettingController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\PaymentSettingController;
use App\Http\Controllers\Backend\PaypalSettingController;
use App\Http\Controllers\Backend\ProductImageGalleryController;
use App\Http\Controllers\Backend\ProductVariantController;
use App\Http\Controllers\Backend\ProductVariantItemController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\ProudctController;
use App\Http\Controllers\Backend\SellerProductController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\ShippingRuleController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\StripeSettingController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\SubscribersController;
use App\Http\Controllers\Backend\TransactionController;
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
  /** product image gallery routes */
  Route::resource('products-image-gallery', ProductImageGalleryController::class);
  /** product variant routes */
  Route::put('products-variant/change-status', [ProductVariantController::class, 'changeStatus'])->name('products-variant.change-status');
  Route::resource('products-variant', ProductVariantController::class);
  /** product variant items routes */
  // Route::put('products-variant-items/change-status', [ProductVariantItemController::class, 'changeStatus'])->name('products-variant-items.change-status');
  Route::get('products-variant-item/{productId}/{variantId}', [ProductVariantItemController::class, 'index'])->name('products-variant-item.index');
  Route::get('products-variant-item/create/{productId}/{variantId}', [ProductVariantItemController::class, 'create'])->name('products-variant-item.create');
  Route::post('products-variant-item', [ProductVariantItemController::class, 'store'])->name('products-variant-item.store');
  Route::get('products-variant-item-edit/{variantItemId}', [ProductVariantItemController::class, 'edit'])->name('products-variant-item.edit');
  Route::put('products-variant-item-update/{variantItemId}', [ProductVariantItemController::class, 'update'])->name('products-variant-item.update');
  Route::delete('products-variant-item/{variantItemId}', [ProductVariantItemController::class, 'destroy'])->name('products-variant-item.destroy');
  Route::put('products-variant-item-status', [ProductVariantItemController::class, 'chageStatus'])->name('products-variant-item.chages-status');
  /** Seller products routes */
  Route::get('seller-products', [SellerProductController::class, 'index'])->name('seller-products.index');
  Route::get('seller-pending-products', [SellerProductController::class, 'pendingProducts'])->name('seller-pending-products.index');
  Route::put('change-approve-status', [SellerProductController::class, 'changeApproveStatus'])->name('change-approve-status');
  /** Flash Sale routes */
  Route::get('flash-sale', [FlashSaleController::class, 'index'])->name('flash-sale.index');
  Route::put('flash-sale', [FlashSaleController::class, 'update'])->name('flash-sale.update');
  Route::post('flash-sale/add-product', [FlashSaleController::class, 'addProduct'])->name('flash-sale.add-product');

  Route::put('flash-sale/show-at-home/status-change', [FlashSaleController::class, 'chageShowAtHomeStatus'])->name('flash-sale.show-at-home.change-status');
  Route::put('flash-sale-status', [FlashSaleController::class, 'changeStatus'])->name('flash-sale-status');
  Route::delete('flash-sale/{id}', [FlashSaleController::class, 'destory'])->name('flash-sale.destory');
  /** setting routes */
  Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
  Route::put('general-setting-update', [SettingController::class, 'generalSettingUpdate'])->name('general-setting-update');
  Route::put('email-setting-update', [SettingController::class, 'emailConfigSettingUpdate'])->name('email-setting-update');

  /** Coupon routes */
  Route::resource('coupons', CouponController::class);
  Route::put('coupons/change-status', [CouponController::class, 'changeStatus'])->name('coupons.change-status');
  /** shipping-rule Routes */
  Route::put('shipping-rule/change-status', [ShippingRuleController::class, 'changeStatus'])->name('shipping-rule.change-status');
  Route::resource('shipping-rule', ShippingRuleController::class);
  /** Order routes */
  Route::get('pending-orders', [OrderController::class, 'pendingOrders'])->name('pending-orders');
  Route::get('processed-orders', [OrderController::class, 'processedOrders'])->name('processed-orders');
  Route::get('dropped-off-orders', [OrderController::class, 'droppedOfOrders'])->name('dropped-off-orders');
  Route::get('shipped-orders', [OrderController::class, 'shippedOrders'])->name('shipped-orders');
  Route::get('out-for-delivery-orders', [OrderController::class, 'outForDeliveryOrders'])->name('out-for-delivery-orders');
  Route::get('delivered-orders', [OrderController::class, 'deliveredOrders'])->name('delivered-orders');
  Route::get('canceled-orders', [OrderController::class, 'canceledOrders'])->name('canceled-orders');
  Route::get('payment-status', [OrderController::class, 'changePaymentStatus'])->name('payment.status');
  Route::get('order-status', [OrderController::class, 'changeOrderStatus'])->name('order.status');
  Route::resource('order', OrderController::class);

  /** Order Transaction route */
  Route::get('transaction', [TransactionController::class, 'index'])->name('transaction');
  /** Payment settings routes */
  Route::get('payment-settings', [PaymentSettingController::class, 'index'])->name('payment-settings.index');
  Route::resource('paypal-setting', PaypalSettingController::class);
  Route::put('stripe-setting/{id}', [StripeSettingController::class, 'update'])->name('stripe-setting.update');

  /** home page setting route */
  Route::get('home-page-setting', [HomePageSettingController::class, 'index'])->name('home-page-setting');
  Route::put('popular-category-section', [HomePageSettingController::class, 'updatePopularCategorySection'])->name('popular-category-section');
  Route::put('product-slider-section-one', [HomePageSettingController::class, 'updateProductSliderSectionOn'])->name('product-slider-section-one');
  Route::put('product-slider-section-two', [HomePageSettingController::class, 'updateProductSliderSectionTwo'])->name('product-slider-section-two');
  Route::put('product-slider-section-three', [HomePageSettingController::class, 'updateProductSliderSectionThree'])->name('product-slider-section-three');
  /** footer routes */
  Route::resource('footer-info', FooterInfoController::class);
  Route::resource('footer-socials', FooterSocialController::class);
  Route::put('footer-socials/change-status', [FooterSocialController::class, 'changeStatus'])->name('footer-socials.change-status');
  Route::put('footer-grid-two/change-status', [FooterGridTwoController::class, 'changeStatus'])->name('footer-grid-two.change-status');
  Route::put('footer-grid-two/change-title', [FooterGridTwoController::class, 'changeTitle'])->name('footer-grid-two.change-title');
  Route::resource('footer-grid-two', FooterGridTwoController::class);
  Route::put('footer-grid-three/change-status', [FooterGridThreeController::class, 'changeStatus'])->name('footer-grid-three.change-status');
  Route::put('footer-grid-three/change-title', [FooterGridThreeController::class, 'changeTitle'])->name('footer-grid-three.change-title');
  Route::resource('footer-grid-three', FooterGridThreeController::class);

  // /** Subscribers route */
  Route::get('subscribers', [SubscribersController::class, 'index'])->name('subscribers.index');
  Route::delete('subscribers/{id}', [SubscribersController::class, 'destory'])->name('subscribers.destory');
  Route::post('subscribers-send-mail', [SubscribersController::class, 'sendMail'])->name('subscribers-send-mail');
  /** Advertisement Routes */
  Route::get('advertisement', [AdvertisementController::class, 'index'])->name('advertisement.index');
  Route::put('advertisement/homepage-banner-secion-one', [AdvertisementController::class, 'homepageBannerSecionOne'])->name('homepage-banner-secion-one');
  Route::put('advertisement/homepage-banner-secion-two', [AdvertisementController::class, 'homepageBannerSecionTwo'])->name('homepage-banner-secion-two');
  Route::put('advertisement/homepage-banner-secion-three', [AdvertisementController::class, 'homepageBannerSecionThree'])->name('homepage-banner-secion-three');
  Route::put('advertisement/homepage-banner-secion-four', [AdvertisementController::class, 'homepageBannerSecionFour'])->name('homepage-banner-secion-four');
  Route::put('advertisement/productpage-banner', [AdvertisementController::class, 'productPageBanner'])->name('productpage-banner');
  Route::put('advertisement/cartpage-banner', [AdvertisementController::class, 'cartPageBanner'])->name('cartpage-banner');

  /** reviews routes */
  Route::get('reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
  Route::put('reviews/change-status', [AdminReviewController::class, 'changeStatus'])->name('reviews.change-status');
});
