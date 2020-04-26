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
        $soLuongDT = DienThoaiDiDong::where('Dang_ban', '=', 1)->count();
        $dsDienThoai;

        //Danh sách điện thoại ---------------------------------------------------------
        if($soLuongDT >= 12)
        {
            $dsDienThoai = DienThoaiDiDong::where('Dang_ban', '=', 1)->orderBy('Ma_dien_thoai', 'desc')->take(12)->get();
        }
        else
        {
            $dsDienThoai = DienThoaiDiDong::where('Dang_ban', '=', 1)->orderBy('Ma_dien_thoai', 'desc')->get();
        }       
        
        //Danh sách điện thoại bán chạy --------------------------------------------------
        $dsMaDT = array();
        $dsSoLuongBan = array();
        $count = 0;

        $dienThoai = DienThoaiDiDong::where('Dang_ban', '=', 1)->get();
        foreach ($dienThoai as $dt) {
            $dsMaDT[$count] = $dt->Ma_dien_thoai;
            $dsSoLuongBan[$count] = $dt->ToChiTietGioHang->count();
            $count++;
        }
        for ($i=0; $i < count($dsMaDT)-1; $i++) { 
            for ($j=$i+1; $j < count($dsMaDT); $j++) { 
                if($dsSoLuongBan[$i] < $dsSoLuongBan[$j])
                {
                    //SWAP $dsSoLuongBan
                    $temp = $dsSoLuongBan[$i];
                    $dsSoLuongBan[$i] = $dsSoLuongBan[$j];
                    $dsSoLuongBan[$j] = $temp;

                    //SWAP $dsMaDT
                    $temp = $dsMaDT[$i];
                    $dsMaDT[$i] = $dsMaDT[$j];
                    $dsMaDT[$j] = $temp;
                }
            }
        }
        $soLuongToiThieu;
        if(count($dsMaDT) < 6){
            $soLuongToiThieu = count($dsMaDT);
        }
        else{
            $soLuongToiThieu = 6;
        }
            
        $dsMaBanChay = array();
        for ($i=0; $i < $soLuongToiThieu; $i++) { 
            $dsMaBanChay[$i] = $dsMaDT[$i];
        }

        //Danh sách điện thoại giảm giá mạnh -------------------------------------------------
        $dsMaDT = array();
        $dsSoLuongKM = array();
        $count = 0;

            //Lấy ngày hôm nay
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $today = date('Y-m-d');

        $dienThoai = DienThoaiDiDong::where('Dang_ban', '=', 1)->get();
        foreach ($dienThoai as $dt) {
            $hasKM = false;
            $km =$dt->ToKhuyenMai->last();
            if($km !== null)
            {
                if( $km->Tu_ngay<=$today && $today<=$km->Den_ngay )
                {
                    $hasKM = true;
                }
            }
            
            if( $hasKM )
            {
                $dsMaDT[$count] = $dt->Ma_dien_thoai;
                $dsSoLuongKM[$count] = $km->Phan_tram_khuyen_mai;
                $count++;
            }
        }
        for ($i=0; $i < count($dsMaDT)-1; $i++) { 
            for ($j=$i+1; $j < count($dsMaDT); $j++) { 
                if($dsSoLuongKM[$i] < $dsSoLuongKM[$j])
                {
                    //SWAP $dsSoLuongKM
                    $temp = $dsSoLuongKM[$i];
                    $dsSoLuongKM[$i] = $dsSoLuongKM[$j];
                    $dsSoLuongKM[$j] = $temp;

                    //SWAP $dsMaDT
                    $temp = $dsMaDT[$i];
                    $dsMaDT[$i] = $dsMaDT[$j];
                    $dsMaDT[$j] = $temp;
                }
            }
        }
        $soLuongToiThieu;
        if(count($dsMaDT) < 6){
            $soLuongToiThieu = count($dsMaDT);
        }
        else{
            $soLuongToiThieu = 6;
        }
            
        $dsMaGiamGia = array();
        for ($i=0; $i < $soLuongToiThieu; $i++) { 
            $dsMaGiamGia[$i] = $dsMaDT[$i];
        }

        return view('user.content', ['dsDienThoai'=>$dsDienThoai, 'dsMaBanChay'=>$dsMaBanChay, 'dsMaGiamGia'=>$dsMaGiamGia]);
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
        return view('user.account.ThongTin');
    }

    function getCapNhatTaiKhoan()
    {
        return view('user.account.TaiKhoan');
    }

    function getDonHang()
    {
        return view('user.account.DonHang');
    }

    function getThongTinThanhToan()
    {
        return view('user.account.ThongTinThanhToan');
    }

    function getCaiDat()
    {
        return view('user.account.CaiDat');
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
