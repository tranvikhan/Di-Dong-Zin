<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix'=>'admin'], function(){
    Route::get('thongke', function(){
        return view('admin.ThongKe');
    });

    Route::group(['prefix'=>'dienthoai'], function(){
        Route::get('danhsach', 'DienThoaiController@getDanhSach');

        Route::get('them', 'DienThoaiController@getThem');

        Route::get('sua/{id}', 'DienThoaiController@getSua');
    });

    Route::group(['prefix'=>'hangdienthoai'], function(){
        Route::get('danhsach', 'HangDienThoaiController@getDanhSach');
    });
});

Route::get('temp', function(){
    $phone = App\HangDienThoaiDiDong::find(1)->ToDienThoaiDiDong->count();

    echo $phone;
}); 