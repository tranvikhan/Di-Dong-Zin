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

// ==============================================================================================
// -------- ROUTE ADMIN -------------------------------------------------------------------------
// ==============================================================================================
Route::group(['prefix'=>'admin', 'middleware'=>'AdminMiddleware'], function(){
    
    Route::get('thongke', function(){
        $sodonhang = App\HoaDon::where('Trang_thai', '=', 0)->count();
        return view('admin.ThongKe', ['sodonhang'=>$sodonhang]);
    });

    Route::get('trang', function(){
        $sodonhang = App\HoaDon::where('Trang_thai', '=', 0)->count();
        return view('admin.Trang', ['sodonhang'=>$sodonhang]);
    });

    Route::get('caidat', function(){
        $sodonhang = App\HoaDon::where('Trang_thai', '=', 0)->count();
        return view('admin.CaiDat', ['sodonhang'=>$sodonhang]);
    });

    Route::group(['prefix'=>'hoadon'], function(){
        Route::get('danhsach', 'HoaDonController@getDanhSach');

        Route::get('TimHoaDonAjax/{id}', 'HoaDonController@FindBill');
    });

    Route::group(['prefix'=>'thanhvien'], function(){
        Route::get('danhsach', 'ThanhVienController@getDanhSach');

        Route::post('SuaThanhVien', 'ThanhVienController@postSua');

        Route::get('TimThanhVienAjax/{noiDung}', 'ThanhVienController@FindMember');
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

        Route::get('LocDienThoaiAjax/{hangDT}/{mucGia}/{sapXep}', 'DienThoaiController@FilterPhone');

        Route::get('TimKiemDienThoaiAjax/{noiDung}', 'DienThoaiController@FindPhone');
    });

    Route::group(['prefix'=>'hangdienthoai'], function(){
        Route::get('danhsach', 'HangDienThoaiController@getDanhSach');

        Route::post('them', 'HangDienThoaiController@postThem');

        Route::post('sua', 'HangDienThoaiController@postSua');

        Route::get('xoa/{id}', 'HangDienThoaiController@getXoa');
    });

    Route::get('dangxuat', function(){
        Auth::logout();
        return redirect('TrangChu')->with('dangXuat', 'Đăng xuất thành công');
    });
});


// ==============================================================================================
// -------- ROUTE USER --------------------------------------------------------------------------
// ==============================================================================================
    //TRANG CHỦ ==================================================================================
Route::get('TrangChu', 'UserController@getTrangChu');
        
        // Tìm kiếm điện thoại tại Trang chủ
Route::get('TimDienThoaiAjax/{noiDung}', 'UserController@TimDienThoaiAjax');

    // Khi người dùng nhập nội dung tìm kiếm rồi nhấn Enter
        //Nhưng do đang ở trong khác (không phải trang chủ) nên nội dung được gởi về để gọi ra trang chủ
Route::get('TimKiemTuKhoaDienThoai/{noiDung}', 'UserController@getTimKiemTuKhoaDienThoai');

Route::get('ChonHangDienThoai/{Ma_hang_dien_thoai}', 'UserController@getChonHangDienThoai');

        //Sắp xếp điện thoại tại Trang chủ
Route::get('SapXepDienThoaiAjax/{noiDung}/{maHangDT}/{mucGia}/{thuTu}', 'UserController@SapXepDienThoaiAjax');


    //ĐĂNG XUẤT ===================================================================================
Route::get('logout', 'UserController@getDangXuat');


    //NHẬN THÔNG TIN ĐĂNG NHẬP =====================================================================
Route::post('dangnhap', 'UserController@postDangNhap');

Route::post('dangky', 'UserController@postDangKy');
        
        // THAO TÁC ĐỔI MẬT KHẨU
        Route::post('KiemTraDieuKienDoiMatKhau', 'UserController@postKiemTraDieuKienDoiMatKhau');

    //HIỆN CHI TIẾT ĐIỆN THOẠI ====================================================================
Route::get('DienThoai/{id}.html', 'UserController@ShowPhone');

        // AJAX THÊM VÀ CẬP NHẬT BÌNH LUẬN
Route::get('ThemBinhLuan/{Ma_binh_luan_cha}/{Noi_dung}/{Ma_dien_thoai}', 'UserController@getThemBinhLuan');

Route::get('CapNhatBinhLuan/{loai}/{Ma_binh_luan}/{Noi_dung}','UserController@getCapNhatBinhLuan');


    //THANH TOÁN GIỎ HÀNG ===========================================================================
Route::get('ThanhToanGioHang', 'UserController@getThanhToanGioHang');

Route::post('TaoDonHang', 'UserController@postTaoDonHang');

        // AJAX KIỂM TRA KHO VÀ ĐƯA RA THÔNG BÁO NẾU KHI THIẾU HOẶC KHÔNG CÓ ĐIỆN THOẠI
Route::get('KiemTraKhoAjax', 'UserController@getKiemTraKhoAjax');

        // AJAX LÚC NÀO CŨNG CHẠY: CHỈ CẬP NHẬT KHI THIẾU HOẶC KHÔNG CÓ ĐIỆN THOẠI
Route::get('CapNhatGioHangAjax', 'UserController@getCapNhatGioHangAjax');

        //TẠO SESSION ĐIỆN THOẠI CHO VÀO GIỎ HÀNG
Route::get('ThemVaoGioHang/{id}', 'UserController@getThemVaoGioHang');

Route::get('TangGiamSoLuongCHECKED_AJAX/{loai}/{maDT}/{maGioHang}/{soLuong}', 'UserController@getTangGiamSoLuongCHECKED_AJAX');

Route::get('TangGiamSoLuongUNCHECK_AJAX/{loai}/{maDT}/{soLuong}', 'UserController@getTangGiamSoLuongUNCHECK_AJAX');


    //QUẢN LÝ THÔNG TIN THÀNH VIÊN ================================================================
Route::group(['prefix'=>'taikhoan', 'middleware'=>'UserMiddleware'], function(){
        //THÔNG TIN THÀNH VIÊN
    Route::get('ThongTinCaNhan', 'UserController@getThongTinCaNhan');

    Route::post('CapNhatThongTin', 'UserController@postCapNhatThongTin');

        // TÀI KHOẢN
    Route::get('CapNhatTaiKhoan', 'UserController@getCapNhatTaiKhoan');

    Route::post('CapNhatThongTinDangNhap', 'UserController@postCapNhatThongTinDangNhap');
        
    // ĐƠN HÀNG
    Route::get('DonHang', 'UserController@getDonHang');

    Route::get('HuyDonHang/{id}.html', 'UserController@getHuyDonHang');

    Route::get('ChiTietDonHang/{id}.html', 'UserController@getChiTietDonHang');

        // CÀI ĐẶT
    Route::get('CaiDat', 'UserController@getCaiDat');
});


//-------- NHÁP -------------------------------------------------------
Route::get('temp', function(){
    date_default_timezone_set('Asia/Ho_Chi_Minh');
   
    $time = date('Y-m-d H:i:s');
    echo $time;
});

Route::group(['middleware'=>'web'], function(){
    Route::get('taoSessionCount', function(){
        Session::put('count', 0);
    });
    Route::get('goiCount', function(){
        echo Session('count');
    });
    Route::get('taoNEW', function(){
        $count = Session('count');
        Session::put('a'.$count, $count+10);
        $count++;
        Session::put('count', $count);
    });
    Route::get('dsSession', function(){
        $count = Session('count');
        for ($i=0; $i < $count; $i++) { 
            echo Session('a'.$i).' ';
        }
    });
    Route::get('ShowDT', function(){
        $soLuongDT = session()->get('count');
        $dsMaDienThoai = array();
        $dsSoLuongTheoMa = array();
        // Đưa các điện thoại trong giỏ hàng vào dsMaDienThoai để hienj ra màn hình
        for ($i=0; $i < $soLuongDT; $i++) { 
            $maDT = session()->get('dt'.$i);

            $count = count($dsMaDienThoai);
            $dsMaDienThoai[$count] = $maDT;
            $dsSoLuongTheoMa[$count] = 1;

            echo $dsMaDienThoai[$i].' '.$dsSoLuongTheoMa[$i].'<br>';
        }
    });
    Route::get('xoaSession', function(){
        session()->flush();
    });

    Route::get('dangnhapchong', function(){
        if(Auth::attempt(['Username'=>'abc6', 'password'=>'12345']))
        {
            echo 'da dang nhap chong thanh cong';
        }
        else
            echo 'that bai';
    });
    Route::get('getView', function(){
        return view('user.Email_DoiMatKhau');
    });
});