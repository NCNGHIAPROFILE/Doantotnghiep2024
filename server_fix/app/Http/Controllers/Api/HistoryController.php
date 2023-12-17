<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\History;
use Illuminate\Support\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $historys;
    public function __construct(History $historys){
        $this->historys = $historys;
    }
    public function index()
    {    
        $user = JWTAuth::parseToken()->authenticate();
        if($user){
            $historys = History::all();
            $historysCount = History::all()->count();
            return response()->json([
                'status' => 200,
                'Recoure' => $historysCount,
                'historys' => $historys
            ], 200);
        } else {
            return response()->json([
                'status' => 400,
                'message' => "You are not logged in! Login Now."
            ], 400);
        }
    }
    
    public function calculateTotalBookLoansInMonth()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $count = History::whereBetween('DateDownload', [$startOfMonth, $endOfMonth])->count();

        return response()->json([
            'status' => 200,
            'message' => 'Total book loans in the month',
            'count' => $count,
        ], 200);
    }
    public function listUserHistory()
    {    
        $user = JWTAuth::parseToken()->authenticate();
        if($user){
            $historys = History::where('MaSV', $user->MaSV)->get();
            $historysCount = History::where('MaSV', $user->MaSV)->count();
            return response()->json([
                'status' => 200,
                'Recoure' => $historysCount,
                'historys' => $historys
            ], 200);
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
            $books = Book::where('id', $id)->where('Type', 1)->first();
            if($recordUser && $books){
                $dataCreate['MaSV'] = $user->MaSV;
                $dataCreate['MaSach'] = $books->MaSach;
                $dataCreate['DateDownload'] = Carbon::now();
                $tickets = History::create($dataCreate);
                return response()->json([
                    'status' => 201,
                    'message' => "Tickets Download successfully!",
                    'tickets' => $tickets
                ], 201);
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
            $user = User::where('id', $id)->first();
            $detail_History = History::where('MaSV', $user->MaSV)->get();
            if($detail_History){
                return response()->json([
                    'status' => 200,
                    'message' => "historys View Detail Successfully!",
                    'historys' => $detail_History
                ], 200);
            }
            else{
                return response()->json([
                    'status' => 400,
                    'message' => "historys View Detail Failed! Because historys do not exist!"
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
    public function update(Request $request, string $id)
    {
        // Skip
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        if($user){
            $affectedRows = History::where('id', $id)->delete();
            if ($affectedRows > 0) {
                return response()->json([
                    'status' => 200,
                    'message' => "historys Deleted Successfully",
                ], 200);
            }  
            else {
                return response()->json([
                    'status' => 500,
                    'message' => "historys Deleted Failed!",
                ], 500);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => "You are not logged in! Login Now."
            ], 400);
        }
    }

    public function showHistoryUser(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        if($user){
            $searchData = $request->input('showHistoryUser');
            $historys = History::Where('MaSV', 'like', '%'.$searchData.'%')->get();
            $historysCount = History::Where('MaSV', 'like', '%'.$searchData.'%')->count();
            if($historys){
                return response()->json([
                    'status' => 200,
                    'message' => "historys Search Successfully",
                    'Resource' => $historysCount,
                    'historys' => $historys
                ], 200);
            }
            else{
                return response()->json([
                    'status' => 400,
                    'message' => "historys Search Failed!"
                ], 200);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => "You are not logged in! Login Now."
            ], 400);
        }
    }

    public function showHistoryBook(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        if($user){
            $searchData = $request->input('showHistoryBook');
            $historys = Book::where('NameBook', 'like', '%' . $searchData . '%')->get();
            if ($historys->isEmpty()) {
                return response()->json([
                    'status' => 400,
                    'message' => "Books not found!"
                ], 400);
            }
            $historyIds = $historys->pluck('MaSach')->toArray();
            $historys = History::whereIn('MaSach', $historyIds)->get();
            $historysCount = $historys->count();
            if($historysCount){
                return response()->json([
                    'status' => 200,
                    'message' => "historys Search Successfully",
                    'Resource' => $historysCount,
                    'historys' => $historys
                ], 200);
            }
            return response()->json([
                'status' => 400,
                'message' => "historys Search Failed!"
            ], 400);
        } else {
            return response()->json([
                'status' => 400,
                'message' => "You are not logged in! Login Now."
            ], 400);
        }
    }
}
