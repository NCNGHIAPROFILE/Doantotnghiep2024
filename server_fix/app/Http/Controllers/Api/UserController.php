<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UserImport;
use Tymon\JWTAuth\Facades\JWTAuth;

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
        $user = JWTAuth::parseToken()->authenticate();
        if($user){
            $users = User::all();
            $usersCount = $users->count();
            return response()->json([
                'status' => 200,
                'usersCount' => $usersCount,
                'users' => $users
            ]);
        } else{
            return response()->json([
                'status' => 400,
                'message' => "You are not logged in! Login Now."
            ], 400);
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $file = $request->file('file');
        Excel::import(new UserImport, $file);

        return response()->json([
            'status' => 201,
            'message' => "User Import successfully!"
        ], 201);
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
                    'message' => "User Created Failed!",
                    'users' => $tmpName
                ], 500);
            }
            $dataCreate['Class'] = $request->Class;
            $dataCreate['AddressUser'] = $request->AddressUser;
            $dataCreate['Phone'] = $request->Phone;
            $name = Str::slug($tmpName, '_');
            $dataCreate['email'] = $name . "_" . $tmpMSSV . "@dau.edu.vn";
            $dataCreate['password'] = Hash::make($request->password);
            if ($request->hasFile('ImageUser')) {
                $avatar = $request->file('ImageUser');
                $imageName = time() . '.' . $avatar->getClientOriginalExtension();
                $avatar->move(public_path('images'), $imageName);
                $avatarPath = $imageName;
            } else {
                $avatarPath = null;
            }
            $dataCreate['ImageUser'] = $avatarPath;
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
        $user = JWTAuth::parseToken()->authenticate();
        if($user){
            $users = User::where('id', $id)->first();
            if($users){
                return response()->json([
                    'status' => 200,
                    'message' => "Users View Detail Successfully!",
                    'users' => $users
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
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'User not found',
            ], 404);
        }

        $request->validate([
            'FistNameUser' => 'required|string',
            'LastNameUser' => 'required|string|not_regex:/\s+/',
            'Class' => 'required|string',
            'AddressUser' => 'required|string',
            'Phone' => 'required|string',
        ]);

        $dataUpdate = [
            'MaSV' => $request->MaSV,
            'FistNameUser' => $request->FistNameUser,
            'LastNameUser' => $request->LastNameUser,
            'Class' => $request->Class,
            'AddressUser' => $request->AddressUser,
            'Phone' => $request->Phone,
        ];

        if ($request->has('password')) {
            $dataUpdate['password'] = Hash::make($request->password);
        }

        $dataUpdate['email'] = Str::slug($dataUpdate['LastNameUser'], '_') . "_" . $dataUpdate['MaSV'] . "@dau.edu.vn";

        if ($request->hasFile('ImageUser')) {
            $avatar = $request->file('ImageUser');
            $imageName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('images'), $imageName);
            $dataUpdate['ImageUser'] = $imageName;
        }

        $user->MaSV = $dataUpdate['MaSV'];
        $user->FistNameUser = $dataUpdate['FistNameUser'];
        $user->LastNameUser = $dataUpdate['LastNameUser'];
        $user->Class = $dataUpdate['Class'];
        $user->AddressUser = $dataUpdate['AddressUser'];
        $user->Phone = $dataUpdate['Phone'];
        if (isset($dataUpdate['password'])) {
            $user->password = $dataUpdate['password'];
        }
        $user->email = $dataUpdate['email'];
        if (isset($dataUpdate['ImageUser'])) {
            $user->ImageUser = $dataUpdate['ImageUser'];
        }
        $user->save();
        return response()->json([
            'status' => 200,
            'message' => 'User Updated Successfully!',
            'user' => $user,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {    
        $user = JWTAuth::parseToken()->authenticate();
        if($user){
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
        $user = JWTAuth::parseToken()->authenticate();
        if($user){
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
