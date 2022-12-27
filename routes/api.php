<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

//AUTH

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::group([
    'middleware' => 'jwt.auth'
], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});

//USERS

Route::put('/updateUser', [UserController::class,'updateUser']);


//ADMIN
Route::get('/users', [UserController::class, 'getAllUsers']);
Route::get('/appointments',[AppointmentController::class, 'getAllApointments']);



//APPOINTMENTS

Route::group([
    'middleware' => 'jwt.auth'
], function () {
    Route::post('/addAppointment', [AppointmentController::class, 'addAppointment']);
    Route::get('/myAppointments', [AppointmentController::class, 'myAppointments']);
    Route::put('/editAppointment', [AppointmentController::class, 'editAppointment']);
    Route::delete('/deleteAppointment', [AppointmentController::class, 'deleteAppointment']);
});
