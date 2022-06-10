<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DatabaseController;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/newproduct', [DatabaseController::class, 'newProduct'])->name('newproduct');
Route::get('/home', [DatabaseController::class, 'index'])->name('home');
Route::get('/products', [DatabaseController::class, 'showProducts'])->name('products');
Route::get('/products/{category_id}', [DatabaseController::class, 'showCategory'])->where('category_id', '[0-9]+')->name('products_categorized');
Route::post('/addproduct', [DatabaseController::class, 'addProduct'])->name('addproduct');
Route::post('/editproduct', [DatabaseController::class, 'editProduct'])->name('editproduct');
Route::get('/removeproduct/{product_id}', [DatabaseController::class, 'removeProduct'])->where('product_id', '[0-9]+')->name('removeproduct');

Route::get('/product/{id}', [DatabaseController::class, 'showProduct'])->where('id', '[0-9]+')->name('product');
Route::get('/cart', [DatabaseController::class, 'showCart'])->name('cart');
Route::get('/addtocart/{product_id}', [DatabaseController::class, 'addToCart'])->where('product_id', '[0-9]+')->name('addtocart');
Route::get('/removefromcart/{product_id}', [DatabaseController::class, 'removeFromCart'])->where('product_id', '[0-9]+')->name('removefromcart');
Route::get('/checkout', [DatabaseController::class, 'checkout'])->name('checkout');
Route::get('/orders', [DatabaseController::class, 'showOrders'])->name('orders');



Route::get('/login/facebook', [LoginController::class, 'redirectToProvider']);
Route::get('/login/facebook/callback', [LoginController::class, 'handleProviderCallback']);
