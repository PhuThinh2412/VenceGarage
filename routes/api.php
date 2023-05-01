<?php

use App\Http\Controllers\ParkingSpaceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/parking-data', [ParkingSpaceController::class, 'show']);
Route::post('/enter', [ParkingSpaceController::class, 'create']);
Route::post('/exit', [ParkingSpaceController::class, 'delete']);