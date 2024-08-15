<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ChatController;


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

// admin role
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/createguru', [GuruController::class, 'store']);
    Route::post('/editguru/{id}', [GuruController::class, 'update']);
});

// guru role
Route::middleware(['auth:sanctum', 'guru'])->group(function () {
    Route::get('/tickets/pending', [TicketController::class, 'viewTickets']);
    Route::get('/my-tickets-guru', [TicketController::class, 'myTicketsForGuru']);
    Route::post('/tickets/{id}/accept', [TicketController::class, 'acceptTicket']);
    Route::post('/tickets/{id}/close', [TicketController::class, 'closeTicket']);
});

// siswa role
Route::middleware(['auth:sanctum', 'siswa'])->group(function () {
    Route::post('/tickets', [TicketController::class, 'createTicket']);
    Route::get('/my-tickets', [TicketController::class, 'myTickets']);
});

// all role
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/tickets/{ticket_id}/messages', [ChatController::class, 'sendMessage']);
    Route::get('/tickets/{ticket_id}/messages', [ChatController::class, 'getMessages']);
});
