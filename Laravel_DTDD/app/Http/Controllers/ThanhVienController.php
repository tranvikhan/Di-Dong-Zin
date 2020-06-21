<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TaiKhoan;

class ThanhVienController extends Controller
{
    function getDanhSach()
    {
        $thanhVien = TaiKhoan::all();
        return view('admin.ThanhVien', ['thanhVien'=>$thanhVien]);
    }

    function postSua(Request $request)
    {
        $id = $request->inputUserID;
        $loaiTaiKhoan = $request->loaitaikhoan;

        $user = TaiKhoan::find($id);
        $user->Tai_khoan_admin = $loaiTaiKhoan;
        $user->save();

        return redirect('admin/thanhvien/danhsach')->with('thongbao', 'Lưu thành viên thành công');
    }

    // ---------------- AJAX --------------------------------------------------------
    function FindMember($noiDung)
    {
        $found = false;
        $thanhVien = TaiKhoan::all();
        $dsMaThanhVien = array();

        if( is_numeric($noiDung) )
        {
            //Nếu dữ liệu nhập vào là số
            $max = TaiKhoan::max('Ma_tai_khoan');
            $num = (int)$noiDung;

            if( 1<=$noiDung && $noiDung<=$max)
            {
                $count = count($dsMaThanhVien);
                $dsMaThanhVien[$count] = $num;

                //Tìm thấy thành viên
                $found = true;
            }
        }
        else //Nếu dữ liệu nhập vào không phải là số
        {
            foreach ($thanhVien as $tv) {
                $hoTen = $tv->Ho_va_ten_lot .' '. $tv->Ten;
                
                // Ta làm cho noiDung và họ và tên thành chữ thường (strlower)
                $hoTen = strtolower($hoTen);
                $noiDung = strtolower($noiDung);

                // !==false : nghĩa là tìm thấy vị trí
                if( strpos($hoTen, $noiDung) !== false )
                {
                    $count = count($dsMaThanhVien);
                    $dsMaThanhVien[$count] = $tv->Ma_tai_khoan;
                    
                    //Tìm thấy thành viên
                    $found = true;
                }
            }
        }

        if( !$found )
        {
            echo '0';
        }
        
        foreach ($dsMaThanhVien as $maTV) {
            $tv = TaiKhoan::find($maTV);
            echo '<div class="col-4 col-4s cart-thanhvien">';
                echo '<div class="row">';
                    echo '<img src="DiDongZin/avatar/'. $tv->URL_Avatar .'" alt="avatar" class="col-5">';
                    echo '<img src="DiDongZin/assets/img/slider_50px.png" alt="setting" class="sua_thanhvien"
                        onclick="XemThanhVien(\''. $tv->URL_Avatar .'\', \''. $tv->Ma_tai_khoan .'\', \''. $tv->Tai_khoan_admin .'\', \''. $tv->Username .'\', \''. $tv->Ho_va_ten_lot .' '. $tv->Ten .'\', \''. $tv->Gioi_tinh .'\', \''. $tv->Ngay_sinh .'\', \''. $tv->So_dien_thoai .'\', \''. $tv->Dia_chi .'\')">';
                    
                    echo '<div class="col-7">';
                        echo '<h3>'. $tv->Ho_va_ten_lot .' '. $tv->Ten .'</h3>';
                        echo '<p>MS: '. $tv->Ma_tai_khoan .'</p>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        }    
    }
}
