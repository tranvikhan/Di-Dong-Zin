<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\TaiKhoan;
use App\DienThoaiDiDong;

class UserController extends Controller
{
    function getTrangChu()
    {
        return view('user.content');
    }
    
    function postDangNhap(Request $request)
    {
        $uid = $request->username;
        $pass = $request->password;

        if(Auth::attempt(['Username'=>$uid, 'password'=>$pass]))
        {
            return redirect('TrangChu')->with('thongBaoDangNhap', 'Đăng nhập thành công');
        }
        else
        {
            return redirect('TrangChu')->with('thongBaoDangNhap', 'Đăng nhập thất bại');
        }
    }

    function getDangXuat()
    {
        if(Auth::check())
        {
            Auth::logout();
            return redirect('TrangChu')->with('dangXuat', 'Đăng xuất thành công');
        }
        else
            return redirect('TrangChu');
    }

    //CÁC TRANG QUẢN LÝ TÀI KHOẢN
    function getThongTinCaNhan()
    {
        return view('user.ThongTin');
    }

    function getCapNhatTaiKhoan()
    {
        return view('user.TaiKhoan');
    }

    function getDonHang()
    {
        return view('user.DonHang');
    }

    function getThongTinThanhToan()
    {
        return view('user.ThongTinThanhToan');
    }

    function getCaiDat()
    {
        return view('user.CaiDat');
    }
    //- THE END ------------------ CÁC TRANG QUẢN LÝ TÀI KHOẢN







    // function taoUser()
    // {
    //     $taiKhoan = new TaiKhoan;
    //     $taiKhoan->Username = 'abc6';
    //     $taiKhoan->Password = bcrypt('123456');
    //     $taiKhoan->Ho_va_ten_lot = 'Le Minh';
    //     $taiKhoan->Ten = 'Hai';
    //     $taiKhoan->Ngay_sinh = '1999-02-26';
    //     $taiKhoan->Gioi_tinh = 1;
    //     $taiKhoan->Dia_chi = 'Kien giang';
    //     $taiKhoan->So_dien_thoai = '0235632569';
    //     $taiKhoan->URL_Avatar = 'acsac.png';
    //     $taiKhoan->Tai_khoan_admin = 1;

    //     $taiKhoan->save();
    //     echo 'tao tai khoan thanh cong';
    // }
}
