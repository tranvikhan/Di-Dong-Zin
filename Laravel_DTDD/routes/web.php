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

    Route::get('hoadon', function(){
        $hoaDon = App\HoaDon::where('Trang_thai', '=', 1)->get();
        $sodonhang = App\HoaDon::where('Trang_thai', '=', 0)->count();
        View::share('sodonhang', $sodonhang);
        return view('admin.HoaDon', ['hoaDon'=>$hoaDon]);
    });

    Route::group(['prefix'=>'donhang'], function(){
        Route::get('danhsach', 'DonHangController@ShowView');

        Route::get('xacnhan/{id}', 'DonHangController@XacNhanDonHang');

        Route::get('huybo/{id}', 'DonHangController@HuyBoDonHang');
    });

    Route::group(['prefix'=>'dienthoai'], function(){
        Route::get('danhsach', 'DienThoaiController@getDanhSach');

        Route::get('them', 'DienThoaiController@getThem');
        Route::post('them', 'DienThoaiController@postThem');

        Route::get('sua/{id}', 'DienThoaiController@getSua');
        Route::post('sua/{id}', 'DienThoaiController@postSua');

        Route::get('xoa/{id}', 'DienThoaiController@getXoa');
    });

    Route::group(['prefix'=>'hangdienthoai'], function(){
        Route::get('danhsach', 'HangDienThoaiController@getDanhSach');

        Route::post('them', 'HangDienThoaiController@postThem');

        Route::post('sua', 'HangDienThoaiController@postSua');

        Route::get('xoa/{id}', 'HangDienThoaiController@getXoa');
    });

    Route::group(['prefix'=>'ajax'], function(){
        Route::get('LocDienThoai/{hangDT}/{mucGia}/{sapXep}', 'AjaxController@FilterPhone');

        Route::get('TimKiemDienThoai/{noiDung}', 'AjaxController@FindPhone');

        Route::get('TimHoaDon/{id}', 'AjaxController@FindBill');
    });
    
});

Route::get('temp', function(){
    date_default_timezone_set('Asia/Ho_Chi_Minh');
   
    $time = date('Y-m-d H:i:s');
    echo $time;
});