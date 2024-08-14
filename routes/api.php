<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\TicketController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);

});

// Route::middleware(['auth:sanctum', 'admin'])->get('/admin-only', function () {
// });

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/createguru', [GuruController::class, 'store']);
    Route::post('/editguru/{id}', [GuruController::class, 'update']);
});

Route::middleware(['auth:sanctum', 'guru'])->group(function () {
    Route::get('/tickets/pending', [TicketController::class, 'viewTickets']);
    Route::post('/tickets/{id}/accept', [TicketController::class, 'acceptTicket']);
    Route::post('/tickets/{id}/close', [TicketController::class, 'closeTicket']);
});
Route::middleware(['auth:sanctum', 'siswa'])->group(function () {
    Route::post('/tickets', [TicketController::class, 'createTicket']);
});

