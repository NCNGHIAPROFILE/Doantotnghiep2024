<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Mail\OtpMail;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    // auth()->user(): Trả về đối tượng người dùng hiện tại sau khi họ đã đăng nhập.
    // auth()->check(): Kiểm tra xem có người dùng nào đã đăng nhập hay chưa.
    // auth()->login($user): Đăng nhập một người dùng cụ thể.
    // auth()->logout(): Đăng xuất người dùng hiện tại.
    // auth()->attempt($credentials): Thử đăng nhập người dùng bằng thông tin đăng nhập được cung cấp.

    public function register(){
        $MaSV =  $_SESSION['MaSV'];
        $user = User::where('MaSV', $MaSV)->first();
        if(!$user) {
            $newUser = new User();
            $newUser->MaSV = $_SESSION['MaSV'];
            $newUser->FistNameUser = $_SESSION['FistNameUser'];
            $newUser->LastNameUser = $_SESSION['LastNameUser'];
            $newUser->Class = $_SESSION['Class'];
            $newUser->AddressUser = $_SESSION['AddressUser'];
            $newUser->email = $_SESSION['email'];
            $newUser->Phone = $_SESSION['Phone'];
            $newUser->Password = Hash::make($_SESSION['Password']);
            $newUser->ImageUser = $_SESSION['ImageUser'];
            $newUser->save();
            return redirect()->Route('login')->with('Đăng ký thành công');
        }
        else{
            return redirect()->Route('login')->with('Tài khoản đã tồn tại');
        }
    }
    public function sendmail(Request $request){
        $recipient = 'nghia_1951220039@dau.edu.vn';
        $mailData = rand(100000, 999999);
        Mail::to($recipient)->send(new TemplateMail($mailData));
        return view('mailData')->with('mailData', '$mailData');
    }

    public function login(Request $request){
        if(Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])){
            $user = User::whereEmail($request->email)->first();
            $admin = Admin::whereEmail($request->email)->first();
            if($user){
                $user->Token = $user->createToken($request->email)->plainTextToken;
                User::where('id', $user->id)->update(['Token' => $user->Token]);
                return response()->json([
                    'status' => 200,
                    'message' => "User Login Success!",
                    'Token' => $user->Token
                ], 200);
            } else if($admin){
                $admin->Token = $admin->createToken($request->email)->plainTextToken;
                Admin::where('id', $admin->id)->update(['Token' => $admin->Token]);
                return response()->json([
                    'status' => 200,
                    'message' => "Admin Login Success!",
                    'Token' => $admin->Token
                ], 200);
            }
        }
        return response()->json([
            'email' => 'Email or password incorect!'
        ], 401);
    }

    public function logout(){
        auth()->guard('web')->logout();
        return response()->json([
            'status' => 200,
            'message' => "Logout Success!"
        ], 200);
    }
}