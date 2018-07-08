<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Khi truy cập vào đường dẫn default chuyển về trang login
Route::get('/', function () {
    return redirect('login');
});

Route::group(['middleware' => 'isLoggedIn'], function(){ //Check trong middle
    Route::get('/login', 'Auth\AuthController@loginPage'); //Hàm trả về trang đăng nhập
    Route::post('/login', ['uses' => 'Auth\AuthController@AuthenticateLogin']); //Hàm đăng nhập
});

Route::group(['middleware' => 'routePers'], function(){ //Check trong middle
    Route::get('/logout', ['uses' => 'Auth\AuthController@logout']); //Hàm đăng xuất

    Route::get('/admin', 'Admin\AdminController@dashboard'); //Trang chủ

    //Nhóm route dành cho quản lý cấu hình
    Route::get('/listConfig', 'Config\ConfigController@index'); //Trang danh sách cấu hình

    Route::get('/api/getListConfig', 'Config\ConfigController@list'); //Trang danh sách cấu hình
    Route::post('/api/deleteConfig', 'Config\ConfigController@delete'); //Hàm xóa cấu hình
    Route::post('/api/addConfig', 'Config\ConfigController@addConfig'); //Hàm tạo mới
    Route::post('/api/updateConfig', 'Config\ConfigController@updateConfig'); //Hàm cập nhật


     //Nhóm route dành cho quản lý user
    Route::get('/listusers', 'user\Usercontroller@indexusers'); //Trang danh sách cấu hình

    Route::get('/api/getListuser', 'user\Usercontroller@listusers'); //Trang danh sách cấu hình
    Route::post('/api/deleteuser', 'user\Usercontroller@deleteusers'); //Hàm xóa cấu hình
    Route::post('/api/adduser', 'user\Usercontroller@addusers'); //Hàm tạo mới
    Route::post('/api/updateuser', 'user\Usercontroller@updateusers'); //Hàm cập nhật


});





// Route::get('/home', function () {
//     return view('backend.home');
// });
// Route::get('taobang',function (){
//         Schema::create('tblinfo',function ($table){
//        $table->increments('id');
//        $table->string('ten',50);
//     });
//     echo "Đã nhập thành công";
// });
// // duong dan den form
// Route::get('cf/create','Controller@created');
// //duong dan control submit
// Route::post('cf/create','Controller@store');
// Route::get('/form', function () {
//     return view('backend.dashboard');



// });