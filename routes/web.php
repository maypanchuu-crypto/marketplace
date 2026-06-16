<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VendorRegistrationController;
use App\Http\Controllers\AdminVendorController;
use App\Http\Controllers\VendorDashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\AdminFinanceController;
use App\Http\Controllers\Vendor\VendorWalletController;
use App\Http\Controllers\CheckoutController;

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

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // for all authenticated users
    Route::get('/dashboard', [ProductController::class, 'index'])->name('dashboard');

    // //only for customer
    // Route::middleware(['role:customer'])->group(function () {
    //     Route::get('/dashboard', function () {
    //         return view('dashboard');
    //     })->name('dashboard');
    // });

    // for admin only
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Admin Vendor Requests Routes
        Route::get('/vendor-requests', [AdminVendorController::class, 'index'])->name('vendor.requests');
        Route::post('/vendor-requests/{id}/approve', [AdminVendorController::class, 'approve'])->name('vendor.approve');
        Route::post('/vendor-requests/{id}/reject', [AdminVendorController::class, 'reject'])->name('vendor.reject');

        // Vendor List နှင့် အကောင့် ပိတ်/ဖွင့်/ဖျက်ခြင်း
        Route::get('/vendors', [AdminFinanceController::class, 'vendorIndex'])->name('vendors.index');
        Route::post('/vendors/{id}/toggle', [AdminFinanceController::class, 'toggleVendor'])->name('vendors.toggle');
        Route::delete('/vendors/{id}', [AdminFinanceController::class, 'deleteVendor'])->name('vendors.destroy');

        // ငွေထုတ်ပေးရမည့် Request များအား စီမံခန့်ခွဲခြင်း
        Route::get('/withdraw-requests', [AdminFinanceController::class, 'withdrawIndex'])->name('withdraw.index');
        Route::post('/withdraw-requests/{id}/approve', [AdminFinanceController::class, 'approveWithdraw'])->name('withdraw.approve');
        Route::post('/withdraw-requests/{id}/reject', [AdminFinanceController::class, 'rejectWithdraw'])->name('withdraw.reject');
        
        // Admin က အော်ဒါအားလုံးကို စာရင်းချုပ် ကြည့်မည့်စာမျက်နှာ
        Route::get('/orders', [AdminFinanceController::class, 'orderIndex'])->name('orders.index');

        // အော်ဒါကို အောင်မြင်ကြောင်း သတ်မှတ်ပြီး Vendor ဆီ ပိုက်ဆံခွဲပေးမည့် Route
        Route::post('/orders/{id}/complete', [AdminFinanceController::class, 'completeOrder'])->name('orders.complete');
    });

    // for vendor only
    Route::middleware(['role:vendor'])->prefix('vendor')->name('vendor.')->group(function () {
        Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');

        // for product creation by vendor
        Route::get('/product/create', [VendorDashboardController::class, 'createProduct'])->name('product.create');
        Route::post('/product/store', [VendorDashboardController::class, 'storeProduct'])->name('product.store');

        // for product editing by vendor
        Route::get('/products/{id}/edit', [VendorDashboardController::class, 'edit'])->name('products.edit');
        Route::put('/products/{id}', [VendorDashboardController::class, 'update'])->name('products.update');

        // for product deleting by vendor
        Route::delete('/products/{id}', [VendorDashboardController::class, 'destroy'])->name('products.destroy');

        // Wallet နှင့် ငွေထုတ်ရန် လျှောက်လွှာတင်ခြင်း
        Route::get('/wallet', [VendorWalletController::class, 'index'])->name('wallet');
        Route::post('/wallet/withdraw', [VendorWalletController::class, 'requestWithdraw'])->name('withdraw.submit');

        // Vendor က သူ့ဆိုင်က ရောင်းထွက်သွားတဲ့ ပစ္စည်းစာရင်း (Items) ကို ကြည့်မည့်စာမျက်နှာ
        Route::get('/orders', [VendorDashboardController::class, 'orderIndex'])->name('orders.index');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // for Product Detail 
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

    // Vendor Registration Routes
    Route::get('/vendor-register', [VendorRegistrationController::class, 'index'])->name('vendor.register');
    Route::post('/vendor-register', [VendorRegistrationController::class, 'register'])->name('vendor.register.submit');
});

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::patch('/update-cart', [CartController::class, 'updateCart'])->name('cart.update');
Route::delete('/remove-from-cart', [CartController::class, 'removeCart'])->name('cart.remove');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');


require __DIR__ . '/auth.php';
