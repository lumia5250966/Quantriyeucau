<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
use DB;

class AuthController extends Controller
{
    public function loginPage(){
        return view("backend.layout.login");
    }

    public function AuthenticateLogin(Request $request){
        $postData = $request->all();
        $username = $postData["username"];
        $password = $postData["password"];
        //Bổ sung thêm 1 phần kiểm tra tài khoản và mật khẩu, kết quả đưa vào biến $result 
        $user = DB::table("user")->where("user_hidden", 0)->where("user_username", $username)->first();
        // $user = DB::table("user")->update(["user_password" => Hash::make($password)]);
        if(Hash::check($password, $user->{'user_password'} )){
            session(['infoLogin'=> $username ]);
            return redirect('/admin');
        }
        return redirect('/login'); //Nếu đăng nhập thất bại
    }
        

        
    

    public function logout(Request $request){
        $request->session()->forget('infoLogin');
        return redirect('/login');
    }
}
