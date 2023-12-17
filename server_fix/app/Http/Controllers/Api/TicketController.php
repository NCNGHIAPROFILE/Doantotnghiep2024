<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Book;
use App\Models\History;
use App\Models\User;
use Illuminate\Support\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $tickets;
    public function __construct(Ticket $tickets){
        $this->tickets = $tickets;
    }
    public function index()
    {   
        $user = JWTAuth::parseToken()->authenticate();
        if($user){
            $tickets = Ticket::all();
            $ticketsCount = Ticket::all()->count();
            return response()->json([
                'status' => 200,
                'Recoure' => $ticketsCount,
                'Tickets' => $tickets
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => "You are not logged in! Login Now."
            ], 400);
        }
    }

    public function totalBookTicketInMonth()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $count = Ticket::whereBetween('DateAcceptTiket', [$startOfMonth, $endOfMonth])->count();

        return response()->json([
            'status' => 200,
            'message' => 'Total book ticket in the month',
            'count' => $count,
        ], 200);
    }

    public function ListTicketUserCreate()
    {   
        $user = JWTAuth::parseToken()->authenticate();
        error_log($user);
        if($user){
            $tickets = Ticket::where('MaSV', $user->MaSV)->where('StatusTicket', 0)->get();
            $ticketsCount = $tickets->count();
            return response()->json([
                'status' => 200,
                'Recoure' => $ticketsCount,
                'tickets' => $tickets
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => "You are not logged in! Login Now."
            ], 400);
        }
    }

    public function ListTicketUserApcept()
    {   
        $user = JWTAuth::parseToken()->authenticate();
        if($user){
            $tickets = Ticket::where('MaSV', $user->MaSV)->where('StatusTicket', 1)->get();
            $ticketsCount = $tickets->count();
            return response()->json([
                'status' => 200,
                'Recoure' => $ticketsCount,
                'tickets' => $tickets
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => "You are not logged in! Login Now."
            ], 400);
        }
    }

    public function ListTicketUserGiveback()
    {   
        $user = JWTAuth::parseToken()->authenticate();
        if($user){
            $tickets = Ticket::where('MaSV', $user->MaSV)->where('StatusTicket', 2)->get();
            $ticketsCount = $tickets->count();
            return response()->json([
                'status' => 200,
                'Recoure' => $ticketsCount,
                'tickets' => $tickets
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => "You are not logged in! Login Now."
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, String $id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        if($user) {
            $recordUser = User::where('MaSV', $user->MaSV)->first();
            $books = Book::where('id', $id)->first();
            if($recordUser && $books){
                $fieldValue = $books->Quantity;
                if($fieldValue > 0){
                    $dataCreate['MaSV'] = $user->MaSV;
                    $dataCreate['MaSach'] = $books->MaSach;
                    $get_dateCreate = Carbon::now();
                    $dataCreate['DateCreateTicket'] = $get_dateCreate;
                    $dataCreate['StatusTicket'] = 0;
                    $tickets = Ticket::create($dataCreate);
                    return response()->json([
                        'status' => 201,
                        'message' => "Tickets Created successfully!",
                        'tickets' => $tickets
                    ], 201);
                }
                else{
                    return response()->json([
                        'status' => 400,
                        'message' => "Tickets Created Failed! Because there are no more books in the library!"
                    ], 400);
                }
            }
            else{
                return response()->json([
                    'status' => 400,
                    'message' => "User or Book do not exist!"
                ], 400);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => "You are not logged in! Login Now."
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        if($user){
            $detail_Tickets = Ticket::where('id', $id)->first();
            if($detail_Tickets){
                return response()->json([
                    'status' => 200,
                    'message' => "Tickets View Detail Successfully!",
                    'tickets' => $detail_Tickets
                ], 200);
            }
            else{
                return response()->json([
                    'status' => 400,
                    'message' => "Tickets View Detail Failed! Because Tickets do not exist!"
                ], 400);
            }
        } else{
            return response()->json([
                'status' => 400,
                'message' => "You are not logged in! Login Now."
            ], 400);
        }
    }

    public function show1()
    {
        $user = JWTAuth::parseToken()->authenticate();
        if($user){
            $tickets = Ticket::where('StatusTicket', 0)->get();
            if($tickets){
                return response()->json([
                    'status' => 200,
                    'message' => "Tickets View Detail Successfully!",
                    'tickets' => $tickets
                ], 200);
            }
            else{
                return response()->json([
                    'status' => 400,
                    'message' => "Tickets View Detail Failed! Because Tickets do not exist!"
                ], 400);
            }
        } else{
            return response()->json([
                'status' => 400,
                'message' => "You are not logged in! Login Now."
            ], 400);
        }
    }

    public function show2()
    {
        $user = JWTAuth::parseToken()->authenticate();
        if($user){
            $tickets = Ticket::where('StatusTicket', 1)->get();
            if($tickets){
                return response()->json([
                    'status' => 200,
                    'message' => "Tickets View Detail Successfully!",
                    'tickets' => $tickets
                ], 200);
            }
            else{
                return response()->json([
                    'status' => 400,
                    'message' => "Tickets View Detail Failed! Because Tickets do not exist!"
                ], 400);
            }
        } else{
            return response()->json([
                'status' => 400,
                'message' => "You are not logged in! Login Now."
            ], 400);
        }
    }

    public function show3()
    {
        $user = JWTAuth::parseToken()->authenticate();
        if($user){
            $tickets = Ticket::where('StatusTicket', 2)->get();
            if($tickets){
                return response()->json([
                    'status' => 200,
                    'message' => "Tickets View Detail Successfully!",
                    'tickets' => $tickets
                ], 200);
            }
            else{
                return response()->json([
                    'status' => 400,
                    'message' => "Tickets View Detail Failed! Because Tickets do not exist!"
                ], 400);
            }
        } else{
            return response()->json([
                'status' => 400,
                'message' => "You are not logged in! Login Now."
            ], 400);
        }
    }

    public function showUserTicket(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        if($user){
            $masv = $request->input('showUserTicket');
            $recordBook = Ticket::where('MaSV', $masv)->get();
            if($recordBook){
                return response()->json([
                    'status' => 200,
                    'message' => "View tickets user Successfully!",
                    'tickets' => $recordBook
                ], 200);
            }
            else{
                return response()->json([
                    'status' => 400,
                    'message' => "View tickets user Failed! Because User has no ticket!"
                ], 400);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => "You are not logged in! Login Now."
            ], 400);
        }
    }

    public function ShowUserTicketDetail()
    {
        $user = JWTAuth::parseToken()->authenticate();
        if($user){
            $recordBook = Ticket::where('MaSV', $user->MaSV)->get();
            if($recordBook){
                return response()->json([
                    'status' => 200,
                    'message' => "View tickets user Successfully!",
                    'tickets' => $recordBook
                ], 200);
            }
            else{
                return response()->json([
                    'status' => 400,
                    'message' => "View tickets user Failed! Because User has no ticket!"
                ], 400);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => "You are not logged in! Login Now."
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function UpdateBookupdateAccept(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        if($user){
            $ticketsDetail = Ticket::select('StatusTicket')->where('id', $request->id)->first();
            if ($ticketsDetail) {
                if ($ticketsDetail->StatusTicket == '0') {
                    $model = Ticket::where('id', $request->id)->where('DateAcceptTiket', null)->first();
                    $recordBook = Book::where('MaSach', $model->MaSach)->where('Quantity', '>', 0)->first();
                    if ($recordBook) {
                        $fieldValue = $recordBook->Quantity;
                        $recordBook->Quantity = $fieldValue - 1;
                        $recordBook->save();
                        error_log($user);
                        if($model){
                            $model->MaAdmin = $user->MaSV;
                            $model->DateAcceptTiket = Carbon::now();
                            $model->StatusTicket = 1;
                            $model->save();
                        } return response()->json([
                            'status' => 200,
                            'message' => "Tickets Update Successfully!",
                            'tickets' => $model,
                        ], 200);
                    } else {
                        return response()->json([
                            'status' => 400,
                            'message' => "Book do not exist!",
                        ], 400);
                    }
                } else if ($ticketsDetail->StatusTicket == '1') {
                    $model = Ticket::where('id', $request->id)->whereNotNull('DateAcceptTiket')->whereNull('DateGiveBack')->first();
                    $recordBook = Book::where('MaSach', $model->MaSach)->where('Quantity', '>=', 0)->first();
                    if ($recordBook) {
                        $fieldValue = $recordBook->Quantity;
                        $recordBook->Quantity = $fieldValue + 1;
                        $recordBook->save();
                        if ($model) {
                            $model->DateGiveBack = Carbon::now();
                            $model->StatusTicket = 2;
                            $model->save();

                            return response()->json([
                                'status' => 200,
                                'message' => "Tickets Update Successfully!",
                                'tickets' => $model,
                            ], 200);
                        } else {
                            return response()->json([
                                'status' => 400,
                                'message' => "Failed to update ticket!",
                            ], 400);
                        }
                    } else if($ticketsDetail->StatusTicket != '0' && $ticketsDetail->StatusTicket != '1') {
                        return response()->json([
                            'status' => 400,
                            'message' => "Ticket has been approved!",
                        ], 400);
                    } else {
                        return response()->json([
                            'status' => 400,
                            'message' => "Book do not exist or quantity is less than 0!",
                        ], 400);
                    }
                } else {
                    return response()->json([
                        'status' => 400,
                        'message' => "Ticket has not been accepted!",
                    ], 400);
                }
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => "Ticket do not exist!",
                ], 400);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => "You are not logged in! Login Now."
            ], 400);
        }
    }

    public function CancelTicket(string $id){
        $user = JWTAuth::parseToken()->authenticate();
        if($user){
            $model = Ticket::where('id', $id)->whereNotNull('DateAcceptTiket')->whereNull('DateGiveBack')->first();
            if ($model) {
                $model->StatusTicket = 2;
                $model->save();
                return response()->json([
                    'status' => 200,
                    'message' => "Tickets Cancel Successfully!",
                    'tickets' => $model,
                ], 200);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => "Failed to Cancel ticket!",
                ], 400);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => "You are not logged in! Login Now."
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        if($user){
            $affectedRows = Ticket::where('id', $id)->where('StatusTicket', '=', '2')->delete();
            if ($affectedRows > 0) {
                return response()->json([
                    'status' => 200,
                    'message' => "Tickets Deleted Successfully",
                ], 200);
            }  
            else {
                return response()->json([
                    'status' => 500,
                    'message' => "Tickets Deleted Failed!",
                ], 500);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => "You are not logged in! Login Now."
            ], 400);
        }
    }

    public function searchBookTicket(Request $request){
        $user = JWTAuth::parseToken()->authenticate();
        if($user){
            $searchData = $request->input('searchBookTicket');
            $books = Book::where('NameBook', 'like', '%' . $searchData . '%')->get();
            if ($books->isEmpty()) {
                return response()->json([
                    'status' => 400,
                    'message' => "Books not found!"
                ], 400);
            }
            $bookIds = $books->pluck('MaSach')->toArray();
            $tickets = Ticket::whereIn('MaSach', $bookIds)->get();
            $ticketsCount = $tickets->count();
            return response()->json([
                'status' => 200,
                'message' => "Tickets Search Successfully",
                'Resource' => $ticketsCount,
                'tickets' => $tickets
            ], 200);
        } else {
            return response()->json([
                'status' => 400,
                'message' => "You are not logged in! Login Now."
            ], 400);
        }
    }

    public function searchUserTicket(Request $request){
        $user = JWTAuth::parseToken()->authenticate();
        if($user){
            $searchData = $request->input('searchUserTicket');
            $tickets = Ticket::Where('MaSV', 'like', '%'.$searchData.'%')->get();
            $ticketsCount = Ticket::Where('MaSV', 'like', '%'.$searchData.'%')->count();
            if($tickets){
                return response()->json([
                    'status' => 200,
                    'message' => "Tickets Search Successfully",
                    'Resource' => $ticketsCount,
                    'tickets' => $tickets
                ], 200);
            }
            else{
                return response()->json([
                    'status' => 400,
                    'message' => "Tickets Search Failed!"
                ], 200);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => "You are not logged in! Login Now."
            ], 400);
        }
    }
}
