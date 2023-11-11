<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Carbon;

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
        $check = auth()->check();
        if($check){
            $dataCreate = $request->all();
            // $get_image = $request->file('Picture');
            $get_image = "OKOK";
            $get_date = Carbon::now();
            $dataBook = Book::where('NameBook', $dataCreate['NameBook'])->where('Author', $dataCreate['Author']);
            if ($dataBook->exists()) {
                return response()->json([
                    'status' => 400,
                    'message' => "Books already exists!"
                ], 400);
            }
            // if($get_image){
                // $get_name_image = $get_image->getClientOriginalName();
                // $name_image = current(explode('.', $get_name_image));
                // $new_image = $name_image.rand(0,99).'.' .$get_image->getClientOriginalExtension();
                // $get_image->move('../public/images/book', $new_image);
                // $dataCreate['Picture'] = $new_image; 
                $dataCreate['Picture'] = $get_image; 
                $dataCreate['YearPublish'] = $get_date;
            // } else $dataCreate['Picture'] = '';
            // $dataCreate['Picture'] = $get_image; 
            // $dataCreate['YearPublish'] = $get_date;
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $check = auth()->check();
        if($check){
            // $data = Book::select('NameBook', 'Author', 'Category', 'Type', 'MaProducer', 'YearPublish',
            //         'Quantity', 'Content', 'Status', 'Picture', 'Sum_Quantity')->get();
            // $getData = $data->map(function ($item) {
            //     return [
            //         'NameBook' => $item->NameBook,
            //         'Author' => $item->Author,
            //         'Category' => $item->Category,
            //         'Type' => $item->Type,
            //         'MaProducer' => $item->MaProducer,
            //         'YearPublish' => $item->YearPublish,
            //         'Quantity' => $item->Quantity,
            //         'Content' => $item->Content,
            //         'Status' => $item->Status,
            //         'Picture' => $item->Picture,
            //         'Sum_Quantity' => $item->Sum_Quantity
            //     ];
            // });
            $books = Book::select('Status')->where('id', $id)->where('Status', '=', '0')->get();
            if($books->count() > 0){
                $books = array();
                $books['NameBook'] = $request->NameBook;
                $books['Author'] = $request->Author;
                $books['Category'] = $request->Category;
                $books['Type'] = $request->Type;
                $books['MaProducer'] = $request->MaProducer;
                $books['Quantity'] = $request->Quantity;
                $books['Content'] = $request->Content;
                $books['Status'] = $request->Status;
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

    public function uploadFile(Request $request){
        // waiting
    }

    public function downloadFile(Request $request){
        // waiting
    }
}
