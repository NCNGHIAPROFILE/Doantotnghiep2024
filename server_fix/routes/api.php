<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\HistoryController;
use App\Http\Controllers\Api\ProducerController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\UserController;
use App\Http\Middleware\isBossRole;
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

Route::group(['middleware' => 'api'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    //book
    Route::get('/Books/ListBook', [BookController::class, 'index']);
    Route::get('/Books/ShowBook/{id}', [BookController::class, 'show']);
    Route::get('/Books/SearchName', [BookController::class, 'searchNameBook']);
    Route::get('/Books/SearchAuthor', [BookController::class, 'searchAuthorBook']);
    Route::get('/Books/SearchCategory', [BookController::class, 'searchCategoryBook']);
    Route::get('/Books/ListBookBasic', [BookController::class, 'ListBookBasic']);
    Route::get('/Books/ListBookNumber', [BookController::class, 'ListBookNumber']);
    

    //ticket
    Route::get('/Tickets/ShowUserTicket', [TicketController::class, 'showUserTicket']);
    Route::post('/Tickets/AddTicket/{id}', [TicketController::class, 'store']);
    Route::get('/Tickets/ShowUserTicketDetail', [TicketController::class, 'ShowUserTicketDetail']);
    Route::get('/Tickets/ListTicketUserCreate', [TicketController::class, 'ListTicketUserCreate']);
    Route::get('/Tickets/ListTicketUserApcept', [TicketController::class, 'ListTicketUserApcept']);
    Route::get('/Tickets/ListTicketUserGiveback', [TicketController::class, 'ListTicketUserGiveback']);
    Route::get('/Tickets/ShowTicket/{id}', [TicketController::class, 'show']);

    //history
    Route::post('/Historys/AddHistory/{id}', [HistoryController::class, 'store']);
    Route::get('/Historys/ShowHistory/{id}', [HistoryController::class, 'show']);
    Route::delete('/Historys/DeleteHistory/{id}', [HistoryController::class, 'destroy']);
    Route::get('/Historys/ShowHistoryUser', [HistoryController::class, 'showHistoryUser']);
    Route::get('/Historys/ShowHistoryBook', [HistoryController::class, 'showHistoryBook']);
    Route::get('/Historys/ShowUserHistoryBook', [HistoryController::class, 'listUserHistory']);


    // Admin router
    Route::middleware(isBossRole::class)->group(function () {
        // user
        Route::get('/Users/ListUser', [UserController::class, 'index']);
        Route::get('/Users/ShowUser/{id}', [UserController::class, 'show']);
        Route::post('/Users/AddUser', [UserController::class, 'store']);
        Route::delete('/Users/DeleteUser/{id}', [UserController::class, 'destroy']);
        Route::get('/Users/SearchUser', [UserController::class, 'searchUser']);
        Route::post('/Users/UpdateUser/{id}', [UserController::class, 'update']);
        Route::post('/ImportUser', [UserController::class, 'import']);
            
        // book
        Route::post('/Books/AddBook', [BookController::class, 'store']);
        Route::put('/Books/UpdateBook/{id}', [BookController::class, 'update']);
        Route::delete('/Books/DeleteBook/{id}', [BookController::class, 'destroy']);        
       
        // ticket
        Route::get('/Tickets/ListTicket', [TicketController::class, 'index']);
        Route::get('/Tickets/ListTicketCreate', [TicketController::class, 'show1']);
        Route::get('/Tickets/ListTicketAccept', [TicketController::class, 'show2']);
        Route::get('/Tickets/ListTicketGiveback', [TicketController::class, 'show3']);
        Route::post('/Tickets/UpdateBookAccept', [TicketController::class, 'UpdateBookupdateAccept']);
        Route::delete('/Tickets/DeleteTicket/{id}', [TicketController::class, 'destroy']);
        Route::get('/Tickets/SearchBookTicket', [TicketController::class, 'searchBookTicket']);
        Route::get('/Tickets/SearchUserTicket', [TicketController::class, 'searchUserTicket']);
        Route::get('/Tickets/CancelTicket', [TicketController::class, 'CancelTicket']);

        //history
        Route::get('/Historys/ListHistory', [HistoryController::class, 'index']);

        //producer
        Route::get('/Producers/ListProducer', [ProducerController::class, 'index']);
        Route::post('/Producers/AddProducer', [ProducerController::class, 'store']);
        Route::put('/Producers/UpdateProducer/{id}', [ProducerController::class, 'update']);
        Route::delete('/Producers/DeleteProducer/{id}', [ProducerController::class, 'destroy']);

        // Upload, download PDF
        Route::post('/upload_pdf', [BookController::class, 'uploadPDF']);
        
    });
});

//Auth
Route::post('/login', [AuthController::class, 'login']);
Route::post('/Users/AddUser', [UserController::class, 'store']);

//mail
Route::post('/vertifymail', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'beforeRegister']);