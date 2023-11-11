<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\History;
use Illuminate\Support\Carbon;

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
        $check = auth()->check();
        if($check){
            $historys = History::all();
            $historysCount = History::all()->count();
            return response()->json([
                'status' => 200,
                'Recoure' => $historysCount,
                'Historys' => $historys
            ], 200);
        } else {
            return response()->json([
                'status' => 400,
                'message' => "You are not logged in! Login Now."
            ], 400);
        }
    }

    public function listUserHistory()
    {    
        $check = auth()->check();
        if($check){
            $user = auth()->user();
            $historys = History::where('MaSV', $user->MaSV)->get();
            $historysCount = History::where('MaSV', $user->MaSV)->count();
            return response()->json([
                'status' => 200,
                'Recoure' => $historysCount,
                'Historys' => $historys
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
    public function store(String $id)
    {
        $check = auth()->check();
        if($check){
            $user = auth()->user();
            $book = Book::where('id', $id)->first();
            if( $book ){
                $get_date = Carbon::now();
                $dataCreate['MaSV'] = $user->MaSV;
                $dataCreate['MaSach'] = $book->MaSach;
                $dataCreate['DateDownload'] = $get_date;
                $historys = History::create($dataCreate);
                return response()->json([
                    'status' => 201,
                    'message' => "Historys Created successfully!",
                    'historys' => $historys
                ], 201);
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
        $check = auth()->check();
        if($check){
            $user = User::where('id', $id)->first();
            $detail_History = History::where('MaSV', $user->MaSV)->get();
            if($detail_History){
                return response()->json([
                    'status' => 200,
                    'message' => "Historys View Detail Successfully!",
                    'historys' => $detail_History
                ], 200);
            }
            else{
                return response()->json([
                    'status' => 400,
                    'message' => "Historys View Detail Failed! Because historys do not exist!"
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
        $check = auth()->check();
        if($check){
            $affectedRows = History::where('id', $id)->delete();
            if ($affectedRows > 0) {
                return response()->json([
                    'status' => 200,
                    'message' => "Historys Deleted Successfully",
                ], 200);
            }  
            else {
                return response()->json([
                    'status' => 500,
                    'message' => "Historys Deleted Failed!",
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
        $check = auth()->check();
        if($check){
            $searchData = $request->input('showHistoryUser');
            $historys = History::Where('MaSV', 'like', '%'.$searchData.'%')->get();
            $historysCount = History::Where('MaSV', 'like', '%'.$searchData.'%')->count();
            if($historys){
                return response()->json([
                    'status' => 200,
                    'message' => "Historys Search Successfully",
                    'Resource' => $historysCount,
                    'historys' => $historys
                ], 200);
            }
            else{
                return response()->json([
                    'status' => 400,
                    'message' => "Historys Search Failed!"
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
        $check = auth()->check();
        if($check){
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
                    'message' => "Historys Search Successfully",
                    'Resource' => $historysCount,
                    'historys' => $historys
                ], 200);
            }
            return response()->json([
                'status' => 400,
                'message' => "Historys Search Failed!"
            ], 400);
        } else {
            return response()->json([
                'status' => 400,
                'message' => "You are not logged in! Login Now."
            ], 400);
        }
    }
}
