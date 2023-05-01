<?php

use App\Http\Controllers\ParkingSpaceController;
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
Route::group([
    'middleware' => ['api', 'cors']
], function ($router) {
    Route::get('/slots', [ParkingSpaceController::class, 'index']);
    Route::post('/enter', [ParkingSpaceController::class, 'create']);
    Route::post('/exit', [ParkingSpaceController::class, 'destroy']);
    Route::post('/add-parking-level', [ParkingSpaceController::class, 'storeLevel']);
    Route::post('/edit-parking-level', [ParkingSpaceController::class, 'edit']);
});