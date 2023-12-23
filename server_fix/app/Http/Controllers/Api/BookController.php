<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        $user = JWTAuth::parseToken()->authenticate();
        if($user){
            $dataCreate = $request->all();
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

    public function CreateBookNumber(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        if($user){
            $dataCreate = $request->all();
            $get_date = Carbon::now();
            $dataBook = Book::where('NameBook', $dataCreate['NameBook'])->where('Author', $dataCreate['Author']);
            if ($dataBook->exists()) {
                return response()->json([
                    'status' => 400,
                    'message' => "Books already exists!"
                ], 400);
            }
            $dataCreate['MaAdmin'] = $user->MaSV; 
            $dataCreate['Type'] = 1;
            $dataCreate['Status'] = 0;
            $dataCreate['YearPublish'] = $get_date;
            if ($request->hasFile('Picture')) {
                $avatar = $request->file('Picture');
                $imageName = time() . '.' . $avatar->getClientOriginalExtension();
                $avatar->move(public_path('images'), $imageName);
                $avatarPath = $imageName;
            } else {
                $avatarPath = null;
            }
            $dataCreate['Picture'] = $avatarPath;
            if ($request->hasFile('FileName')) {
                $file = $request->file('FileName');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('files_Upload'), $fileName);
                $filePath = $fileName;
            } else {
                $filePath = null;
            }
            $dataCreate['FileName'] = $filePath;
            $books = $this->books->create($dataCreate);
            return response()->json([
                'status' => 201,
                'message' => "Books Upload successfully!",
                'books' => $books
            ], 201);
        } else {
            return response()->json([
                'status' => 400,
                'message' => "You are not logged in! Login Now."
            ], 400);
        }
    }

    public function downloadPDF(String $id)
    {
        $fileRecord = Book::where('id', $id)->where('Type', 1)->first();

        if (!$fileRecord) {
            abort(404, 'File not found');
        }
        $filename = $fileRecord->FileName;
        return ([
            'file' => "http://localhost:8000/files_Upload/" . $filename,
        ]);
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

    public function ListBookBasic(Request $request)
    {
        $books = Book::where('Type', 0)->get();
        $booksCount = $books->count();
        return response()->json([
            'status' => 200,
            'message' => "List book Basic Successfully!",
            'quantity' => $booksCount,
            'books' => $books
        ], 200);
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
        $user = JWTAuth::parseToken()->authenticate();
        if($user){
            $params = $request->all();
            $params['id'] = $id;
            $books = Book::where('NameBook', $params['NameBook'])->where('Author', $params['Author']);
            if($books->exists()){
                if ($request->hasFile('Picture')) {
                    $avatar = $request->file('Picture');
                    $imageName = time() . '.' . $avatar->getClientOriginalExtension();
                    $avatar->move(public_path('images'), $imageName);
                    $avatarPath = $imageName;
                } else {
                    $avatarPath = null;
                }
                $params['Picture'] = $avatarPath;
                DB::table('books')->where('id', $id)->update(
                    [
                        'NameBook' => $params['NameBook'],
                        'Author' => $params['Author'],
                        'Category' => $params['Category'],
                        'MaProducer' => $params['MaProducer'],
                        'Content' => $params['Content'],
                        'Picture' => $params['Picture'],
                        'Sum_Quantity' => $params['Sum_Quantity'],
                    ]
                );
                return response()->json([
                    'status' => 200,
                    'message' => "books Update Successfully!",
                    'books' => $books
                ], 200);
            }
            else{
                if ($request->hasFile('Picture')) {
                    $avatar = $request->file('Picture');
                    $imageName = time() . '.' . $avatar->getClientOriginalExtension();
                    $avatar->move(public_path('images'), $imageName);
                    $avatarPath = $imageName;
                } else {
                    $avatarPath = null;
                }
                $params['Picture'] = $avatarPath;
                $params['NameBook'] = Str::slug($params['NameBook'], '_') . "_" . $params['Author'];
                DB::table('books')->where('id', $id)->update(
                    [
                        'NameBook' => $params['NameBook'],
                        'Author' => $params['Author'],
                        'Category' => $params['Category'],
                        'MaProducer' => $params['MaProducer'],
                        'Content' => $params['Content'],
                        'Picture' => $params['Picture'],
                        'Sum_Quantity' => $params['Sum_Quantity'],
                    ]
                );
                return response()->json([
                    'status' => 200,
                    'message' => "books Update Successfully!",
                    'books' => $books
                ], 200);
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

    public function destroyBookNumber(string $id)
    {
        $user = JWTAuth::parseToken()->authenticate();        
        if($user){
            $affectedRows = Book::where('id', $id)->delete();
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

    public function searchNameBookBasic(Request $request){
        $searchData = $request->input('searchNameBookBasic');
        $books = Book::Where('NameBook', 'like', '%'.$searchData.'%')->where('type', 0);
        $booksCount = $books->count();
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

    public function searchAuthorBookBasic(Request $request){
        $searchData = $request->input('searchAuthorBookBasic');
        $books = Book::Where('Author', 'like', '%'.$searchData.'%')->where('type', 0);
        $booksCount = $books->count();
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

    public function searchCategoryBookBasic(Request $request){
        $searchData = $request->input('searchCategoryBookBasic');
        $books = Book::Where('Category', 'like', '%'.$searchData.'%')->where('type', 0);
        $booksCount = $books->count();
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

    public function searchNameBookNumber(Request $request){
        $searchData = $request->input('searchNameBookNumber');
        $books = Book::Where('NameBook', 'like', '%'.$searchData.'%')->where('type', 1);
        $booksCount = $books->count();
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

    public function searchAuthorBookNumber(Request $request){
        $searchData = $request->input('searchAuthorBookNumber');
        $books = Book::Where('Author', 'like', '%'.$searchData.'%')->where('type', 1);
        $booksCount = $books->count();
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

    public function searchCategoryBookNumber(Request $request){
        $searchData = $request->input('searchCategoryBookNumber');
        $books = Book::Where('Category', 'like', '%'.$searchData.'%')->where('type', 1);
        $booksCount = $books->count();
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

    // public function uploadPDF(Request $request){
    //     if ($request->hasFile('pdf_file') && $request->file('pdf_file')->getClientOriginalExtension() == 'pdf') {
    //         $pdf = $request->file('pdf_file');
    //         $pdf->storeAs('File/pdf_uploads', $pdf->getClientOriginalName(), 'local');
    //         return response()->json(['message' => 'File PDF đã được tải lên thành công'], 200);
    //     }
    //     return response()->json(['message' => 'Vui lòng chọn file PDF để tải lên'], 400);
    // }
}
