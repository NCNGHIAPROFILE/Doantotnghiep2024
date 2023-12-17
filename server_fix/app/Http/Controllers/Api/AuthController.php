<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\TemplateMail;
use App\Http\Controllers\Controller;
use App\Models\User;
use \Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    // auth()->user(): Trả về đối tượng người dùng hiện tại sau khi họ đã đăng nhập.
    // auth()->check(): Kiểm tra xem có người dùng nào đã đăng nhập hay chưa.
    // auth()->login($user): Đăng nhập một người dùng cụ thể.
    // auth()->logout(): Đăng xuất người dùng hiện tại.
    // auth()->attempt($credentials): Thử đăng nhập người dùng bằng thông tin đăng nhập được cung cấp.

    public function beforeRegister(Request $request){
        $_SESSION['MaSV'] = $request->MaSV;
        $_SESSION['FistNameUser'] = $request->fistNameUser;
        $_SESSION['LastNameUser'] = $request->lastNameUser;
        $_SESSION['Class'] = $request->class;
        $_SESSION['AddressUser'] = $request->addressUser;
        $_SESSION['Email'] = $request->email;
        $_SESSION['Phone'] = $request->phone;
        $_SESSION['Password'] = $request->password;
        $this->sendmail($request);
        return ([
            "status" => 200,
            "action" => "send verify...",
        ]);
    }

    public function register(Request $request){
        error_log("slslsls");
        error_log($_SESSION['MaSV']);
        if($request->OTP == $_SESSION['OTP']){
            $MaSV =  $_SESSION['MaSV'];
            $user = User::where('MaSV', $MaSV)->first();
            if(!$user) {
                $newUser = new User();
                $newUser->MaSV = $_SESSION['MaSV'];
                $newUser->FistNameUser = $_SESSION['FistNameUser'];
                $newUser->LastNameUser = $_SESSION['LastNameUser'];
                $newUser->Class = $_SESSION['Class'];
                $newUser->AddressUser = $_SESSION['AddressUser'];
                $newUser->email = $_SESSION['Email'];
                $newUser->Phone = $_SESSION['Phone'];
                $newUser->Password = Hash::make($_SESSION['Password']);
                $newUser->ImageUser = $_SESSION['ImageUser'];
                $newUser->save();
                return ([
                    "status" => 200,
                    "message" => "login success",
                ]);
            }
            else{
                return ([
                    "status" => 400,
                    "message" => "login failed",
                ]);
            }
        };
        return ([
            "status" => 200,
            "message" => "OTP sai...!",
        ]);
    }
    public function sendmail(Request $request){
        $recipient = $request->email;
        $mailData = rand(100000, 999999);
        Mail::to($recipient)->send(new TemplateMail($mailData));
        $_SESSION['OTP'] = $mailData;
        error_log($_SESSION['OTP']);
        return "success";
    }

    public function login(Request $request){
        $user = User::where('email', $request->email)->first();
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'email' => 'Email or password incorect!'
            ], 401);
        }
        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);
        $message = $user->role == "user" ? "User Login Success!" : "Admin Login Success!";
        $user->Token = $token;
        $user->save();
        return response()->json([
            'status' => 200,
            'message' => $message ,
            'Token' => $token,
            'email' => $user->email,
            'isAdmin' => $user->role == "user" ? false : true
        ], 200);
    }

    public function logout(){
        // auth()->guard('web')->logout();
        // return response()->json([
        //     'status' => 200,
        //     'message' => "Logout Success!"
        // ], 200);
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json([
                'status' => 200,
                'message' => "Logout Success!"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => "Error during logout",
            ], 500);
        }
    }
}