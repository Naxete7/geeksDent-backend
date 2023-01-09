<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\TreatmentController;
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
Route::group([
    'middleware'=> 'cors'
], function(){

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});
Route::group([
    'middleware' => ['jwt.auth', 'cors']
], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
});

//USERS

Route::put('/updateUser', [UserController::class,'updateUser']);


//ADMIN
Route::group([
    'middleware' => 'admin.auth'
], function () {
    Route::get('/admin', [AdminController::class, 'index']);
    Route::get('/users', [AdminController::class, 'users']);
    Route::get('/appointments', [AdminController::class, 'appointments']);
    Route::get('/doctors', [DoctorController::class, 'doctors']);
    Route::post('/addDoctor', [DoctorController::class, 'addDoctor']);
    Route::delete('/deleteDoctor/{id}', [DoctorController::class, 'deleteDoctor']);
    Route::get('/treatments', [TreatmentController::class, 'treatments']);
    Route::post('/addTreatment', [TreatmentController::class, 'addTreatment']);
    Route::delete('/deleteTreatment/{id}', [TreatmentController::class, 'deleteTreatment']);
});



//APPOINTMENTS

Route::group([
    'middleware' => 'jwt.auth'
], function () {
    Route::post('/addAppointment', [AppointmentController::class, 'addAppointment']);
    Route::get('/myAppointments', [AppointmentController::class, 'myAppointments']);
    Route::put('/updateAppointment', [AppointmentController::class, 'updateAppointment']);
    Route::delete('/deleteAppointment', [AppointmentController::class, 'deleteAppointment']);
});
