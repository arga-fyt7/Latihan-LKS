<?php

use App\Models\Shop;
use App\Models\Blog;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ShopController;
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

/* Route Website */

Route::get('/', function () {
    $shops = Shop::all();
    $blogs = Blog::all();
    return view('welcome', [
        "shops" => $shops,
        "blogs" => $blogs
    ], compact('shops', 'blogs'));
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/blog-details', function () {
    return view('blog-details');
});

Route::get('/blog', function () {
    return view('blog');
});

Route::get('/checkout', function () {
    return view('checkout');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/shop-details', function () {
    return view('shop-details');
});

Route::get('/shop', function () {
    return view('shop');
});

Route::get('/shopping-cart', function () {
    return view('shopping-cart');
});
/* Route Website End */

/* Route Auth */
Route::get('/sign-in', [AuthController::class, 'index1'])->name('sign-in');
Route::get('/logout', [AuthController::class, 'destroy'])->name('logout');
Route::get('/login', [AuthController::class, 'index2'])->name('login');
Route::post('/register', [AuthController::class, 'store'])->name('sign-in');
Route::post('/login', [AuthController::class, 'create'])->name('login');
Route::get('/forgot-password', [AuthController::class, 'index3'])->name('forgot-password');
Route::post('/send-reset-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
/* Route Auth End */

/* Route Dashboard */
Route::get('/dashboard', function () {
    return view('dashboard.home');
})->middleware('auth');

Route::get('/d-shopping', [ShopController::class, 'index'])->middleware('auth');
Route::get('/products/{id}/edit', [ShopController::class, 'edit'])->name('products.edit');
Route::get('/products/{id}', [ShopController::class, 'show'])->name('products.view');
Route::post('/create-shop', [ShopController::class, 'store'])->name('create-blog');
Route::delete('/products/{id}', [ShopController::class, 'destroy'])->name('products.destroy');

Route::get('/d-checkout', function () {
    return view('dashboard.checkout');
})->middleware('auth');

Route::get('/d-market', function () {
    return view('dashboard.market');
})->middleware('auth');

Route::get('/d-blog', [BlogController::class, 'index'])->middleware('auth');
Route::get('/projects/{id}/edit', [BlogController::class, 'edit'])->name('projects.edit');
Route::get('/projects/{id}', [BlogController::class, 'show'])->name('projects.view');
Route::post('/create-blog', [BlogController::class, 'store'])->name('create-blog');
Route::delete('/projects/{id}', [BlogController::class, 'destroy'])->name('projects.destroy');

Route::get('/d-settings', function () {
    return view('dashboard.setting');
})->middleware('auth');

Route::get('/d-profile', function () {
    return view('dashboard.profile');
})->middleware('auth');

/* Route Dashboard End */