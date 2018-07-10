<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class UserController extends Controller
{
    //Hàm trả ra trang quản lý cấu hình
    public function indexusers(){
        return view("backend.user.listuser");
    }
    
    //Hàm lấy danh sách cấu hình
    public function listusers(Request $request){
        $dataGet = $request->all();
        $listData = DB::table('user')
                        ->where("user_hidden", 0)
                        ->limit($dataGet["PageLimit"])
                        ->offset(($dataGet["Page"]-1)*$dataGet["PageLimit"])
                        ->get();
        $CountData = DB::table('user')
                        ->where("user_hidden", 0)
                        ->count();
        return response()->json(['success' => true, 'CountData' => $CountData, 'data' => $listData]);
    }

    //Hàm xóa cấu hình
    public function deleteusers(Request $request){
        $dataPost = $request->all();
        $result = DB::table('user')
                        ->where("user_id", $dataPost["id"])
                        ->where("user_hidden", 0)
                        ->update(["user_hidden" => 1]);
        return response()->json(['success' => $result]);
    }

    //Hàm thêm mới cấu hình
    public function addusers(Request $request){
        $dataPost = $request->all();
        $result = DB::table('user')
                        ->insert([
                            "user_id" => $this->getDateFormat(),
                            "user_fullname" => $dataPost["user_fullname"],
                            "user_birthday" => $dataPost["user_birthday"],
                            "user_email" => $dataPost["user_email"],
                            "user_phone" => $dataPost["user_phone"],
                            "user_username" => $dataPost["user_username"],
                            "user_password" => $dataPost["user_password"],
                            "permission_id" => $dataPost["permission_id"],
                            "user_hidden" => 0,
                        ]);
        return response()->json(['success' => $result]);
    }

    //Hàm cập nhật cấu hình
    public function updateusers(Request $request){
        $dataPost = $request->all();
        $result = DB::table('user')
                        ->where("user_id", $dataPost["user_id"])
                        ->update([
                             "user_fullname" => $dataPost["user_fullname"],
                            "user_birthday" => $dataPost["user_birthday"],
                            "user_email" => $dataPost["user_email"],
                            "user_phone" => $dataPost["user_phone"],
                            "user_username" => $dataPost["user_username"],
                            "user_password" => $dataPost["user_password"],
                            "permission_id" => $dataPost["permission_id"],
                        ]);
        return response()->json(['success' => $result]);
    }

    //Hàm tạo mã theo thời gian server
    public function getDateFormat(){
        return date('ymdHis');
    }
}