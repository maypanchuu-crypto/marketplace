<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VendorRegistrationController;
use App\Http\Controllers\AdminVendorController;
use App\Http\Controllers\VendorDashboardController;
use App\Http\Controllers\CartController;

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
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        // Admin Vendor Requests Routes
        Route::get('/vendor-requests', [AdminVendorController::class, 'index'])->name('admin.vendor.requests');
        Route::post('/vendor-requests/{id}/approve', [AdminVendorController::class, 'approve'])->name('admin.vendor.approve');
        Route::post('/vendor-requests/{id}/reject', [AdminVendorController::class, 'reject'])->name('admin.vendor.reject');
    });

    // for vendor only
    Route::middleware(['role:vendor'])->prefix('vendor')->group(function () {
        Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('vendor.dashboard');

        // for product creation by vendor
        Route::get('/product/create', [VendorDashboardController::class, 'createProduct'])->name('vendor.product.create');
        Route::post('/product/store', [VendorDashboardController::class, 'storeProduct'])->name('vendor.product.store');

        // for product editing by vendor
        Route::get('/products/{id}/edit', [VendorDashboardController::class, 'edit'])->name('products.edit');
        Route::put('/products/{id}', [VendorDashboardController::class, 'update'])->name('products.update');

        // for product deleting by vendor
        Route::delete('/products/{id}', [VendorDashboardController::class, 'destroy'])->name('products.destroy');
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


require __DIR__ . '/auth.php';
