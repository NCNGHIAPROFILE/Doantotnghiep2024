<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $books;
    public function __construct(Book $books){
        $this->books = $books;
    }

    public function index()
    {
        // error_log("======++++");
        // $user = JWTAuth::parseToken()->authenticate();
        // error_log("======++++");
        // error_log($user->email);
        $books = Book::all();
        $booksCount = Book::all()->count();
        return response()->json([
            'status' => 200,
            'Recoure' => $booksCount,
            'Books' => $books
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $check = auth()->check();
        if($check){
            $dataCreate = $request->all();
            $user = JWTAuth::parseToken()->authenticate();
            $get_date = Carbon::now();
            $dataBook = Book::where('NameBook', $dataCreate['NameBook'])->where('Author', $dataCreate['Author']);
            if ($dataBook->exists()) {
                return response()->json([
                    'status' => 400,
                    'message' => "Books already exists!"
                ], 400);
            }
            $dataCreate['MaAdmin'] = $user->MaSV; 
            if ($request->hasFile('Picture')) {
                $avatar = $request->file('Picture');
                $imageName = time() . '.' . $avatar->getClientOriginalExtension();
                $avatar->move(public_path('images'), $imageName);
                $avatarPath = $imageName;
            } else {
                $avatarPath = null;
            }
            $dataCreate['Type'] = 0;
            $dataCreate['Status'] = 0;
            $dataCreate['Sum_Quantity'] = $request->Sum_Quantity;
            $dataCreate['Quantity'] = $request->Sum_Quantity;
            $dataCreate['Picture'] = $avatarPath;
            $dataCreate['YearPublish'] = $get_date;
            $books = $this->books->create($dataCreate);
            return response()->json([
                'status' => 201,
                'message' => "Books Created successfully!",
                'books' => $books
            ], 201);
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
        $detail_Book = Book::where('id', $id)->first();
        if($detail_Book){
            return response()->json([
                'status' => 200,
                'message' => "Books View Detail Successfully!",
                'books' => $detail_Book
            ], 200);
        }
        else{
            return response()->json([
                'status' => 400,
                'message' => "Books View Detail Failed! Because books do not exist!"
            ], 400);
        }
    }

    public function ListBookBasic()
    {
        $books = Book::where('Type', 0)->get();
        if(!$books->isEmpty()){
            return response()->json([
                'status' => 200,
                'message' => "List book Basic Successfully!",
                'books' => $books
            ], 200);
        }
        else{
            return response()->json([
                'status' => 400,
                'message' => "View list Books Failed! Because books do not exist!"
            ], 400);
        }
    }

    public function ListBookNumber()
    {
        $books = Book::where('Type', 1)->get();
        if(!$books->isEmpty()){
            return response()->json([
                'status' => 200,
                'message' => "List book Number Successfully!",
                'books' => $books
            ], 200);
        }
        else{
            return response()->json([
                'status' => 400,
                'message' => "View list Books Failed! Because books do not exist!"
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $check = auth()->check();
        if($check){
            $books = Book::select('Status')->where('id', $id)->where('Status', '=', '0')->get();
            if($books->count() > 0){
                $books = array();
                $books['NameBook'] = $request->NameBook;
                $books['Author'] = $request->Author;
                $books['Category'] = $request->Category;
                $books['MaProducer'] = $request->MaProducer;
                $books['Content'] = $request->Content;
                $books['Picture'] = $request->Picture;
                $books['Sum_Quantity'] = $request->Sum_Quantity;
                $udapetBook = Book::where('id', $id)->update($books);
                return response()->json([
                    'status' => 200,
                    'message' => "Books Update Successfully!",
                    'books' => $udapetBook
                ], 200);
            }
            else{
                return response()->json([
                    'status' => 500,
                    'message' => "Books Update Failed!"
                ], 500);
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
        $check = auth()->check();
        
        if($check){
            $affectedRows = Book::where('id', $id)->whereRaw('Sum_Quantity = Quantity')->delete();
            if ($affectedRows > 0) {
                return response()->json([
                    'status' => 200,
                    'message' => "Books Deleted Successfully",
                ], 200);
            }  
            else {
                return response()->json([
                    'status' => 500,
                    'message' => "Books Deleted Failed!",
                ], 500);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => "You are not logged in! Login Now."
            ], 400);
        }
    }

    public function searchNameBook(Request $request){
        $searchData = $request->input('searchNameBook');
        $books = Book::Where('NameBook', 'like', '%'.$searchData.'%');
        $booksCount = Book::Where('NameBook', 'like', '%'.$searchData.'%')->count();
        if($books->exists()){
            return response()->json([
                'status' => 200,
                'message' => "Books Search Successfully",
                'Resource' => $booksCount,
                'books' => $books->get()
            ], 200);
        }
        else{
            return response()->json([
                'status' => 400,
                'message' => "Books Search Failed!"
            ], 200);
        }
    }

    public function searchAuthorBook(Request $request){
        $searchData = $request->input('searchAuthorBook');
        $books = Book::Where('Author', 'like', '%'.$searchData.'%');
        $booksCount = Book::Where('Author', 'like', '%'.$searchData.'%')->count();
        if($books->exists()){
            return response()->json([
                'status' => 200,
                'message' => "Books Search Successfully",
                'Resource' => $booksCount,
                'books' => $books->get()
            ], 200);
        }
        else{
            return response()->json([
                'status' => 400,
                'message' => "Books Search Failed!"
            ], 200);
        }
    }

    public function searchCategoryBook(Request $request){
        $searchData = $request->input('searchCategoryBook');
        $books = Book::Where('Category', 'like', '%'.$searchData.'%');
        $booksCount = Book::Where('Category', 'like', '%'.$searchData.'%')->count();
        if($books->exists()){
            return response()->json([
                'status' => 200,
                'message' => "Books Search Successfully",
                'Resource' => $booksCount,
                'books' => $books->get()
            ], 200);
        }
        else{
            return response()->json([
                'status' => 400,
                'message' => "Books Search Failed!"
            ], 200);
        }
    }

    public function uploadPDF(Request $request){
        if ($request->hasFile('pdf_file') && $request->file('pdf_file')->getClientOriginalExtension() == 'pdf') {
            $pdf = $request->file('pdf_file');
            $pdf->storeAs('File/pdf_uploads', $pdf->getClientOriginalName(), 'local');
            return response()->json(['message' => 'File PDF đã được tải lên thành công'], 200);
        }
        return response()->json(['message' => 'Vui lòng chọn file PDF để tải lên'], 400);
    }
}
