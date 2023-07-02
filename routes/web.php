<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserOtpController;

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
Route::get('/home',[UserOtpController::class,'home'])->name('home');
Route::get('/',[UserOtpController::class,'otpLogin'])->name('otpLogin');
Route::post('/otp',[UserOtpController::class,'generate'])->name('otpgenerate');
// Route::post('/',[UserOtpController::class,'generate'])->name('otp_generate');
// Route::post('/', [UserOtpController::class, 'generate'])->name('otpgenerate');
Route::get('/otp/varification/{user_id}',[UserOtpController::class,'otpVarify'])->name('otp.verify');

Route::post('/',[UserOtpController::class,'LoginWithOtp'])->name('otp.getlogin');
