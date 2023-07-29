<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
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
});



//Page Route
Route::get('/login', [UserController::class, 'LoginPage']);
Route::get('/userRegistration', [UserController::class, 'RegistrationPage']);
Route::get('/sendOTP', [UserController::class, 'SendOTP']);
Route::get('/reset-password', [UserController::class, 'ResetPass']); 
Route::get('/verifyOtp', [UserController::class, 'VerifyOTPPage']); 
Route::get('/dashboard', [DashboardController::class, 'DashboardPage']); 






//API Web Route for Authentication

Route::post('/registration',[UserController::class, 'UserRegistration']);

Route::post('/user-login',[UserController::class, 'UserLogin']);

Route::post('/send-otp',[UserController::class, 'SendOTPCode']);

Route::post('/verify-otp',[UserController::class, 'VerifyOTP']);

//Route for password reset
Route::post('/reset-password',[UserController::class, 'ResetPassword'])
    ->middleware([TokenVerificationMiddleware::class]);
