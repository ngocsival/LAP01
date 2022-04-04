<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandProduct;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryProduct;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DeliveryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[HomeController::class,'index']);
//Trang chủ
Route::get('danh-muc-san-pham/{id}',[CategoryProduct::class,'show_category_home']);
Route::get('thuong-hieu-san-pham/{id}',[BrandProduct::class,'show_brand_home']);
Route::get('chi-tiet-san-pham/{id}',[ProductController::class,'details_product']);
Route::post('search-product',[HomeController::class,'search']);
//checkout
Route::get('login-checkout',[CheckoutController::class,'show_login']);
Route::post('save-checkout',[CheckoutController::class,'save_checkout']);
Route::get('checkout',[CheckoutController::class,'checkout']);
Route::post('add-customer',[CheckoutController::class,'add_customer']);
Route::get('logout-checkout',[CheckoutController::class,'logout_checkout']);
Route::post('login-customer',[CheckoutController::class,'login_customer']);
Route::get('payment',[CheckoutController::class,'payment']);
Route::post('order-place',[CheckoutController::class,'order_place']);
Route::post('/select-delivery-home',[CheckoutController::class,'select_delivery_home']);
Route::get('delivery-home',[CheckoutController::class,'delivery_home']);
Route::post('/calculate-delivery',[CheckoutController::class,'calculate_delivery']);
Route::post('confirm-order',[CheckoutController::class,'confirm_order']);
//Trang chủ-cart
Route::post('save-cart',[CartController::class,'save_cart']);
Route::get('show-cart',[CartController::class,'show_cart']);
Route::get('gio-hang',[CartController::class,'gio_hang']);
Route::get('delete-cart/{id}',[CartController::class,'delete_cart']);
Route::get('delete-all-cart',[CartController::class,'delete_all_cart']);
Route::post('add-cart-ajax',[CartController::class,'add_cart_ajax']);
Route::post('update-cart',[CartController::class,'update_cart']);
Route::get('delete-cart-product/{id}',[CartController::class,'delete_cart_product']);
//coupon
Route::post('check-coupon',[CartController::class,'check_coupon']);
Route::post('insert-coupon',[CouponController::class,'insert_coupon']);
Route::post('save-coupon-code',[CouponController::class,'save_coupon_code']);
Route::get('insert-coupon-code',[CouponController::class,'insert_coupon_code']);
Route::get('list-coupon',[CouponController::class,'list_coupon']);
//order
Route::get('print-order/{order_code}',[OrderController::class,'print_order']);
Route::get('manage-order',[OrderController::class,'manage_order']);
Route::get('view-order/{order_code}',[OrderController::class,'view_order']);
Route::post('/update-order-qty',[OrderController::class,'update_order_qty']);
Route::post('/update-qty',[OrderController::class,'update_qty']);
//Delivery
Route::get('delivery',[DeliveryController::class,'delivery']);
Route::post('/select-delivery',[DeliveryController::class,'select_delivery']);
Route::post('/add-delivery',[DeliveryController::class,'add_delivery']);
Route::post('/select-feeship',[DeliveryController::class,'select_feeship']);
Route::post('/update-delivery',[DeliveryController::class,'update_delivery']);
//admin
Route::get('admin',[AdminController::class,'index']);
Route::get('dashboard',[AdminController::class,'show_dashboard']);
Route::post('admin-dashboard',[AdminController::class,'dashboard'])->name('getLogin');
Route::get('log_out',[AdminController::class,'log_out'])->name('log_out');



//category
Route::get('add-category-product',[CategoryProduct::class,'add_category_product']);
Route::get('all-category-product',[CategoryProduct::class,'all_category_product']);
Route::post('save-category-product',[CategoryProduct::class,'save_category_product'])->name('save-category-product');
Route::get('delete-category-product/{id}',[CategoryProduct::class,'delete_category_product'])->name('delete-category-product');
Route::get('showedit-category-product/{id}',[CategoryProduct::class,'showedit_category_product'])->name('showedit-category-product');
Route::post('edit-category-product',[CategoryProduct::class,'edit_category_product'])->name('edit-category-product');
Route::post('import-csv',[CategoryProduct::class,'import_csv']);
Route::post('export-csv',[CategoryProduct::class,'export_csv']);
//brand
Route::get('add-brand-product',[BrandProduct::class,'add_brand_product']);
Route::get('all-brand-product',[BrandProduct::class,'all_brand_product']);
Route::post('save-brand-product',[BrandProduct::class,'save_brand_product'])->name('save-brand-product');
Route::get('delete-brand-product/{id}',[BrandProduct::class,'delete_brand_product'])->name('delete-brand-product');
Route::get('showedit-brand-product/{id}',[BrandProduct::class,'showedit_brand_product'])->name('showedit-brand-product');
Route::post('edit-brand-product',[BrandProduct::class,'edit_brand_product'])->name('edit-brand-product');
//product
Route::get('add-product',[ProductController::class,'add_product']);
Route::get('all-product',[ProductController::class,'all_product']);
Route::post('save-product',[ProductController::class,'save_product'])->name('save-product');
Route::get('delete-product/{id}',[ProductController::class,'delete_product'])->name('delete-product');
Route::get('showedit-product/{id}',[ProductController::class,'showedit_product'])->name('showedit-product');
Route::post('edit-product',[ProductController::class,'edit_product'])->name('edit-product');
