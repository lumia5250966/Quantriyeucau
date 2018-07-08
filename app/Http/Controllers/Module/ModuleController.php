<?php

namespace App\Http\Controllers\Config;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class ConfigController extends Controller
{
    //Hàm trả ra trang quản lý module
    public function index(){
        return view("backend.module.listModule");
    }

    //Hàm lấy danh sách cấu hình
    public function list(Request $request){
        $dataGet = $request->all();
        $listData = DB::table('config')
                        ->where("config_hidden", 0)
                        ->limit($dataGet["PageLimit"])
                        ->offset(($dataGet["Page"]-1)*$dataGet["PageLimit"])
                        ->get();
        $CountData = DB::table('config')
                        ->where("config_hidden", 0)
                        ->count();
        return response()->json(['success' => true, 'CountData' => $CountData, 'data' => $listData]);
    }

    //Hàm xóa cấu hình
    public function delete(Request $request){
        $dataPost = $request->all();
        $result = DB::table('config')
                        ->where("config_id", $dataPost["id"])
                        ->where("config_hidden", 0)
                        ->update(["config_hidden" => 1]);
        return response()->json(['success' => $result]);
    }

    //Hàm thêm mới cấu hình
    public function addConfig(Request $request){
        $dataPost = $request->all();
        $result = DB::table('config')
                        ->insert([
                            "config_id" => $this->getDateFormat(),
                            "config_name" => $dataPost["config_name"],
                            "config_value" => $dataPost["config_value"],
                            "config_dateapply" => $dataPost["config_dateapply"],
                            "config_hidden" => 0,
                        ]);
        return response()->json(['success' => $result]);
    }

    //Hàm cập nhật cấu hình
    public function updateConfig(Request $request){
        $dataPost = $request->all();
        $result = DB::table('config')
                        ->where("config_id", $dataPost["config_id"])
                        ->update([
                            "config_name" => $dataPost["config_name"],
                            "config_value" => $dataPost["config_value"],
                            "config_dateapply" => $dataPost["config_dateapply"],
                        ]);
        return response()->json(['success' => $result]);
    }

    //Hàm tạo mã theo thời gian server
    public function getDateFormat(){
        return date('ymdHis');
    }
}