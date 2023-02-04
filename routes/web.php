<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

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
Auth::routes();

Route::get('/products', [ProductController::class, 'index']);

Route::group(['middleware' => ['auth:web']], function() {
    Route::redirect('/home', '/');
    Route::get('/', [HomeController::class, 'index'])->name('home');
});

Route::post('stripe/paymentIntent', [OrderController::class, 'createWithStripe']);

Route::get('/stripe/checkout', function (){
    return view('stripe.checkout.checkout');
})->name('stripe.checkout');
