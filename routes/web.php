<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VendorProductController;

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

    // for Product Detail 
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

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
    });

    // for vendor only
    Route::middleware(['role:vendor'])->prefix('vendor')->group(function () {
        Route::get('/dashboard', [VendorProductController::class, 'index'])->name('vendor.dashboard');

        Route::get('/product/create', [VendorProductController::class, 'create'])->name('vendor.product.create');
        Route::post('/product/store', [VendorProductController::class, 'store'])->name('vendor.product.store');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
