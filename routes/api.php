<?php

use App\Http\Controllers\api\ApiChatController;
use App\Http\Controllers\api\ApiGuruController;
use App\Http\Controllers\api\ApiTicketController;
use App\Http\Controllers\api\Auth\ApiLoginController;
use App\Http\Controllers\api\Auth\ApiRegisterController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/register', [ApiRegisterController::class, 'register']);
Route::post('/login', [ApiLoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [ApiLoginController::class, 'logout']);

});

// admin role
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/createguru', [ApiGuruController::class, 'store']);
    Route::post('/editguru/{id}', [ApiGuruController::class, 'update']);
});

// guru role
Route::middleware(['auth:sanctum', 'guru'])->group(function () {
    Route::get('/tickets/pending', [ApiTicketController::class, 'viewTickets']);
    Route::get('/my-tickets-guru', [ApiTicketController::class, 'myTicketsForGuru']);
    Route::post('/tickets/{id}/accept', [ApiTicketController::class, 'acceptTicket']);
    Route::post('/tickets/{id}/close', [ApiTicketController::class, 'closeTicket']);
});

// siswa role
Route::middleware(['auth:sanctum', 'siswa'])->group(function () {
    Route::post('/tickets', [ApiTicketController::class, 'createTicket']);
    Route::get('/my-tickets', [ApiTicketController::class, 'myTickets']);
});

// all role
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/tickets/{ticket_id}/messages', [ApiChatController::class, 'sendMessage']);
    Route::get('/tickets/{ticket_id}/messages', [ApiChatController::class, 'getMessages']);
});