<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Request;
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
})->name('welcome');

//callback urls for payment
Route::post('/payment/webhook', [PaymentController::class, 'Paystackwebhook']);//paystack webhook
Route::get('/rave/callback', [PaymentController::class, 'callback'])->name('callback');//flutterwave callback

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // payment route for paystack
    Route::post('/pay', [App\Http\Controllers\PaymentController::class, 'initailizePayment'])->name('pay');

    //update paymentplatform
    Route::get('/updatePayment/{status?}',[Controller::class,'updatePayment'])->name('change_payment');

    //user dashboard rout
    Route::get('/DashboardUser',[Controller::class,'dashboard'])->name('userDashboard');

    //Auth
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
