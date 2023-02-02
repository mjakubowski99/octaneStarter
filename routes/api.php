<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use Component\Payment\Infrastracture\Http\Controller\OrderController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => ['auth:api']], function() {
    Route::post('/stripe/paymentIntent', [OrderController::class, 'createWithStripe'])->name(
        'stripe.paymentIntent.create'
    );

    Route::put('/stripe/webhook', [OrderController::class, 'receiveStripeWebhookNotification'])->name(
        'stripe.webhook.update'
    );
});
