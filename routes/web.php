<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\DashboardController;

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

require __DIR__.'/auth.php';

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/test', [HomeController::class, 'test'])->name('test');

Route::get('/create-order', [DashboardController::class, 'createOrder'])->name('create.order');
Route::post('/place-order', [DashboardController::class, 'placeOrder'])->name('place.order');
Route::get('/user/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
Route::get('/history', [DashboardController::class, 'history'])->name('history');


// Webhooks
Route::get('/payment-success', [WebhookController::class, 'success'])->name('payment.success');
Route::get('/payment-cancel', [WebhookController::class, 'cancel'])->name('payment.cancel');
Route::post('/stripe-webhook', [WebhookController::class, 'stripe']);
