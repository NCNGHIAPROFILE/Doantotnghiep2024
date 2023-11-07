<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProducerController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    // book
    Route::post('Books/AddBook', [BookController::class, 'store']);
    Route::put('/Books/UpdateBook/{id}', [BookController::class, 'update']);
    Route::delete('/Books/DeleteBook/{id}', [BookController::class, 'destroy']);

    // user
    Route::get('/Users/ListUser', [UserController::class, 'index']);
    Route::get('/Users/ShowUser/{id}', [UserController::class, 'show']);
    // Route::post('/Users/AddUser', [UserController::class, 'store']);
    Route::delete('/Users/DeleteUser/{id}', [UserController::class, 'destroy']);
    Route::get('/Users/SearchUser', [UserController::class, 'searchUser']);

    // ticket
    Route::get('Tickets/ListTicket', [TicketController::class, 'index']);
    Route::post('Tickets/AddTicket', [TicketController::class, 'store']);
    Route::get('/Tickets/ShowTicket/{id}', [TicketController::class, 'show']);
    Route::put('/Tickets/UpdateBookAccept/{id}', [TicketController::class, 'UpdateBooupdateAccept']);
    // Route::put('/Tickets/UpdateBookGiveBack/{id}', [TicketController::class, 'UpdateBookGiveBack']);
    Route::delete('/Tickets/DeleteTicket/{id}', [TicketController::class, 'destroy']);
    Route::get('/Tickets/SearchBookTicket', [TicketController::class, 'searchBookTicket']);
    Route::get('/Tickets/SearchUserTicket', [TicketController::class, 'searchUserTicket']);
    Route::get('/Tickets/ShowUserTicket', [TicketController::class, 'showUserTicket']);

    //producer
    Route::get('/Producers/ListProducer', [ProducerController::class, 'index']);
    Route::post('/Producers/AddProducer', [ProducerController::class, 'store']);
    Route::put('/Producers/UpdateProducer/{id}', [ProducerController::class, 'update']);
    Route::delete('/Producers/DeleteProducer/{id}', [ProducerController::class, 'destroy']);

    //history
    Route::get('/Historys/ListHistory', [HistoryController::class, 'index']);
    Route::post('/Historys/AddHistory', [HistoryController::class, 'store']);
    Route::get('/Historys/ShowHistory/{id}', [HistoryController::class, 'show']);
    Route::delete('/Historys/DeleteHistory/{id}', [HistoryController::class, 'destroy']);
    Route::get('/Historys/ShowHistoryUser', [HistoryController::class, 'showHistoryUser']);
    Route::get('/Historys/ShowHistoryBook', [HistoryController::class, 'showHistoryBook']);
});

//Auth
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/Users/AddUser', [UserController::class, 'store']);

//Book
Route::get('/Books/ListBook', [BookController::class, 'index']);
Route::get('/Books/ShowBook/{id}', [BookController::class, 'show']);
Route::get('/Books/SearchName', [BookController::class, 'searchNameBook']);
Route::get('/Books/SearchAuthor', [BookController::class, 'searchAuthorBook']);
Route::get('/Books/SearchCategory', [BookController::class, 'searchCategoryBook']);

//mail
Route::get('/vertifymail', [AuthController::class, 'sendmail']);