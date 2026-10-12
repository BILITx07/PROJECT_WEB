<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\LaporanController;

use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserBookingController;

$port = request()->getPort();

if ($port == 8001) {
    // ── USER-FACING WEB APP (Port 8001) ─────────────────────────────
    Route::middleware(['user.port'])->group(function () {
        
        // Authentication
        Route::get('/login', [UserAuthController::class, 'showLogin'])->name('user.login');
        Route::post('/login', [UserAuthController::class, 'login'])->name('user.perform_login');
        Route::post('/register', [UserAuthController::class, 'register'])->name('user.register');
        Route::post('/logout', [UserAuthController::class, 'logout'])->name('user.logout');
        
        // Public Customer Routes
        Route::get('/', [CatalogController::class, 'index'])->name('user.dashboard');
        Route::get('/products', [CatalogController::class, 'products'])->name('user.products');
        Route::view('/tentang-kami', 'user.pages.tentang-kami')->name('user.tentang_kami');
        Route::view('/cara-sewa', 'user.pages.cara-sewa')->name('user.cara_sewa');
        Route::view('/syarat-ketentuan', 'user.pages.syarat-ketentuan')->name('user.syarat_ketentuan');
        Route::view('/kebijakan-privasi', 'user.pages.kebijakan-privasi')->name('user.kebijakan_privasi');

        // Protected Customer Routes
        Route::middleware(['auth'])->group(function () {
            Route::post('/accept-terms', [UserAuthController::class, 'acceptTerms'])->name('user.accept_terms');
            
            // Cart
            Route::get('/cart', [CartController::class, 'index'])->name('user.cart');
            Route::post('/cart/add', [CartController::class, 'add'])->name('user.cart.add');
            Route::post('/cart/{cart}/update', [CartController::class, 'update'])->name('user.cart.update');
            Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('user.cart.remove');
            Route::post('/cart/dates', [CartController::class, 'updateDates'])->name('user.cart.dates');
            
            // Wishlist
            Route::get('/wishlist', [App\Http\Controllers\WishlistController::class, 'index'])->name('user.wishlist');
            Route::post('/wishlist/toggle', [App\Http\Controllers\WishlistController::class, 'toggle'])->name('user.wishlist.toggle');
            
            // Checkout & Bookings
            Route::get('/checkout', [CartController::class, 'checkout'])->name('user.checkout');
            Route::post('/checkout/booking', [CartController::class, 'processBooking'])->name('user.checkout.booking');
            Route::get('/receipt/{booking_code}', [UserBookingController::class, 'receipt'])->name('user.receipt');
            Route::get('/bookings', [UserBookingController::class, 'history'])->name('user.bookings');
            Route::post('/bookings/{booking_code}/cancel', [UserBookingController::class, 'cancel'])->name('user.bookings.cancel');
            
            // User Profile
            Route::get('/profile', [UserAuthController::class, 'profile'])->name('user.profile');
            Route::put('/profile', [UserAuthController::class, 'updateProfile'])->name('user.profile.update');
        });
    });
} else {
    // ── ADMIN PANEL (Port 8000 / Default) ───────────────────────────
    Route::middleware(['admin.port'])->group(function () {
        
        Route::get('/', function () {
            return redirect()->route('login');
        });

        // Authentication
        Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
        Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

        // Admin Panel Protected
        Route::middleware(['auth'])->prefix('admin')->group(function () {
            // Dashboard
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

            // Data Barang (Inventory)
            Route::get('/items',              [ItemController::class, 'index'])->name('admin.items.index');
            Route::post('/items',             [ItemController::class, 'store'])->name('admin.items.store');
            Route::put('/items/{item}',       [ItemController::class, 'update'])->name('admin.items.update');
            Route::delete('/items/{item}',    [ItemController::class, 'destroy'])->name('admin.items.destroy');
            Route::patch('/items/{item}/stock',[ItemController::class, 'updateStock'])->name('admin.items.updateStock');

            // Data Booking
            Route::get('/bookings',                      [BookingController::class, 'index'])->name('admin.bookings.index');
            Route::post('/bookings',                     [BookingController::class, 'store'])->name('admin.bookings.store');
            Route::get('/bookings/{booking}',            [BookingController::class, 'show'])->name('admin.bookings.show');
            Route::patch('/bookings/{booking}/confirm',  [BookingController::class, 'confirm'])->name('admin.bookings.confirm');
            Route::patch('/bookings/{booking}/pickup', [BookingController::class, 'pickup'])->name('admin.bookings.pickup');
            Route::patch('/bookings/{booking}/complete', [BookingController::class, 'complete'])->name('admin.bookings.complete');
            Route::patch('/bookings/{booking}/cancel',   [BookingController::class, 'cancel'])->name('admin.bookings.cancel');

            // Laporan
            Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan');
            Route::get('/laporan/export', [LaporanController::class, 'exportPdf'])->name('admin.laporan.export');

            // Pengguna
            Route::get('/users', [App\Http\Controllers\AdminUserController::class, 'index'])->name('admin.users.index');

        });
    });
}
