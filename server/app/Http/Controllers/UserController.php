<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $users;
    public function __construct(User $users){
        $this->users = $users;
    }
    public function index()
    {
        $check = auth()->check();
        if($check){
            $users = User::all();
            $usersCount = $users->count();
            return response()->json([
                'status' => 200,
                'Recoure' => $usersCount,
                'Users' => $users
            ]);
        } else{
            return response()->json([
                'status' => 400,
                'message' => "You are not logged in! Login Now."
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $recordUser = User::where('MaSV', $request->MaSV)->first();
        if($recordUser){
            return response()->json([
                'status' => 400,
                'message' => "User already exist!"
            ], 400);
        } else{
            $dataCreate = $request->all();
            $tmpMSSV = $request->MaSV;
            $dataCreate['MaSV'] = $tmpMSSV;
            $dataCreate['FistNameUser'] = $request->FistNameUser;
            $tmpName = $request->LastNameUser;
            $dataCreate['LastNameUser'] = $tmpName;
            if (strstr($tmpName, ' ')) {
                return response()->json([
                    'status' => 500,
                    'message' => "User Created Failed! Because Last Name is Name. Example: Nghĩa, Nhung, Việt,...",
                    'users' => $tmpName
                ], 500);
            }
            $dataCreate['Class'] = $request->Class;
            $dataCreate['AddressUser'] = $request->AddressUser;
            $dataCreate['Phone'] = $request->Phone;
            $name = Str::slug($tmpName, '_');
            $dataCreate['email'] = $name . "_" . $tmpMSSV . "@dau.edu.vn";;
            $dataCreate['password'] = Hash::make($request->password);
            $dataCreate['ImageUser'] = $request->ImageUser;
            $users = User::create($dataCreate);
            return response()->json([
                'status' => 201,
                'message' => "User Created successfully!",
                'users' => $users
            ], 201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $check = auth()->check();
        if($check){
            $detail_Users = User::where('id', $id)->first();
            if($detail_Users){
                return response()->json([
                    'status' => 200,
                    'message' => "Users View Detail Successfully!",
                    'users' => $detail_Users
                ], 200);
            }
            else{
                return response()->json([
                    'status' => 400,
                    'message' => "Users View Detail Failed! Because Users do not exist!"
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
        $check = auth()->check();
        if($check){
            $users = User::where('id', $id)->get();
            if($users->count() > 0){
                $users = array();
                $users['AddressUser'] = $request->AddressUser;
                $users['Phone'] = $request->Phone;
                $users['password'] = $request->password;
                $users['ImageUser'] = $request->ImageUser;
                $udapetUsers = User::where('id', $id)->update($users);
                return response()->json([
                    'status' => 200,
                    'message' => "Users Update Successfully!",
                    'users' => $udapetUsers
                ], 200);
            }
            else{
                return response()->json([
                    'status' => 500,
                    'message' => "Users Update Failed!"
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
            $affectedRows = User::Where('id', $id)->delete();
            if ($affectedRows > 0) {
                return response()->json([
                    'status' => 200,
                    'message' => "Users Deleted Successfully",
                ], 200);
            }  
            else {
                return response()->json([
                    'status' => 500,
                    'message' => "Users Deleted Failed!",
                ], 500);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => "You are not logged in! Login Now."
            ], 400);
        }
    }

    public function searchUser(Request $request)
    {
        $check = auth()->check();
        if($check){
            $searchData = $request->input('searchUser');
            $users = User::Where('MaSV', 'like', '%'.$searchData.'%')->get();
            $usersCount = User::Where('MaSV', 'like', '%'.$searchData.'%')->count();
            if($users){
                return response()->json([
                    'status' => 200,
                    'message' => "Users Search Successfully",
                    'Resource' => $usersCount,
                    'users' => $users
                ], 200);
            }
            else{
                return response()->json([
                    'status' => 400,
                    'message' => "Users Search Failed!"
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
