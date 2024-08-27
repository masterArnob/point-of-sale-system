<?php

use App\Http\Controllers\Backend\PaymentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\ProductVariantItemController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HandCashController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\SupplierController;
use App\Models\Order;
use App\Models\ProductVariantItem;
use App\View\Components\ProductCard;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
  $todayEarning = Order::where('order_status', 1)
  ->whereDate('created_at', Carbon::today())
  ->sum('amount');

  $monthEarning = Order::where('order_status', 1)
  ->whereMonth('created_at', Carbon::now()->month)
  ->sum('amount');

  $yearEarning = Order::where('order_status', 1)
  ->whereYear('created_at', Carbon::now()->year)
  ->sum('amount');

  $totalEarnings = Order::where('order_status', 1)
  ->sum('amount');

    return view('dashboard', compact('todayEarning', 'monthEarning', 'yearEarning', 'totalEarnings'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';




Route::get('product', [ProductController::class, 'index'])->name('product');
Route::post('add-to-cart', [CartController::class, 'addToCart'])->name('add-to-cart');
Route::get('cart-details', [CartController::class, 'cartDetails'])->name('cart-details');
Route::get('clear-cart', [CartController::class, 'clearCart'])->name('clear-cart');




Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::get('qty-update', [CartController::class, 'qtyUpdate'])->name('qty-update');
Route::post('sub-total', [CartController::class, 'subTotal'])->name('sub-total');
Route::get('remove-item/{rowId}', [CartController::class, 'removeItem'])->name('remove-item');
Route::get('apply-coupon', [CartController::class, 'applyCoupon'])->name('apply-coupon');
Route::get('coupon-calculation', [CartController::class, 'couponCalculation'])->name('coupon-calculation');


Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('place-order', [CheckoutController::class, 'placeOrder'])->name('place-order');
Route::get('payment-page', [CheckoutController::class, 'paymentPage'])->name('payment-page');



// SSLCOMMERZ Start
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::post('/pay', [SslCommerzPaymentController::class, 'index'])->name('ssl-pay');
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END


//ex
Route::post('suc', [SslCommerzPaymentController::class, 'suc'])->name('suc');
//ex


Route::get('orders', [OrderController::class, 'index'])->name('orders');
Route::get('show/{id}', [OrderController::class, 'invoice'])->name('show');


Route::get('hand-cash', [HandCashController::class, 'index'])->name('hand-cash');


Route::get('create-product', [ProductController::class, 'createProduct'])->name('create-product');
Route::post('product-save', [ProductController::class, 'productSave'])->name('product-save');
Route::resource('coupon', CouponController::class);

Route::get('show-products', [ProductController::class, 'showProducts'])->name('show-products');
Route::get('edit-product/{id}', [ProductController::class, 'editProduct'])->name('edit-product');
Route::put('product-update/{id}', [ProductController::class, 'productUpdate'])->name('product-update');
Route::delete('delete-product/{id}', [ProductController::class, 'deletePro'])->name('delete-product');
Route::resource('product-variant', ProductVariantController::class);

Route::get('variant-item/{product_id}/{variant_id}', [ProductVariantItemController::class, 'index'])->name('variant-item');
Route::get('variant-item-create/{product_id}/{variant_id}', [ProductVariantItemController::class, 'create'])->name('variant-item-create');
Route::post('variant-item-store', [ProductVariantItemController::class, 'store'])->name('variant-item-store');
Route::get('variant-item-edit/{product_id}/{variant_id}/{item_id}', [ProductVariantItemController::class, 'edit'])->name('variant-item-edit');
Route::put('variant-item-update/{id}', [ProductVariantItemController::class, 'update'])->name('variant-item-update');
Route::delete('delete-variant-item/{id}', [ProductVariantItemController::class, 'destroy'])->name('delete-variant-item');
Route::delete('product-delete/{id}', [ProductController::class, 'productDestroy'])->name('product-delete');


Route::resource('supplier', SupplierController::class);
Route::resource('category', CategoryController::class);

Route::get('search-order', [OrderController::class, 'searchOrder'])->name('search-order');
Route::get('search-product', [ProductController::class, 'searchProduct'])->name('search-product');
Route::get('search-order-product', [ProductController::class, 'search_order_product'])->name('search-order-product');