<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TicketController;
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
    return view('auth.login');
});

Route::controller(AuthController::class)->group(function (){
        //register
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');

    //login
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');

    //logout
    Route::get('logout', 'logout')->middleware('auth')->name('logout');
    }
);

Route::middleware(['auth', 'siswa'])->group(function(){
    Route::get('/siswa', [HomeController::class, 'SiswaIndex'])->name('siswa.home');

    Route::get('/tickets', [TicketController::class, 'indexTicket'])->name('ticket.index');
    Route::get('/tickets/create', [TicketController::class, 'createTicket'])->name('ticket.create');
    Route::post('/tickets', [TicketController::class, 'storeTicket'])->name('ticket.store');
    Route::get('/tickets/edit/{ticket}', [TicketController::class, 'editTicket'])->name('ticket.edit');
    Route::put('/tickets/update/{ticket}', [TicketController::class, 'updateTicket'])->name('ticket.update');
    Route::delete('tickets/delete/{id}', [TicketController::class, 'destroyTicket'])->name('ticket.destroy');


});

Route::middleware(['auth', 'guru'])->group(function(){
    Route::get('/guru', [HomeController::class, 'GuruIndex'])->name('guru.home');

    Route::get('/guru/tickets', [TicketController::class, 'myTicketsForGuru'])->name('guru.ticket');
    Route::get('guru/tickets/{id}/accept', [TicketController::class, 'showAcceptForm'])->name('guru.showAcceptForm');
    Route::post('guru/acceptTicket/{id}', [TicketController::class, 'acceptTicket'])->name('guru.accept');
});
Route::middleware(['auth', 'admin'])->group(function(){
    Route::get('/admin', [HomeController::class, 'AdminIndex'])->name('admin.home');

    
});
