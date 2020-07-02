<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\HoaDon;
use App\GioHang;

class DonHangController extends Controller
{
    function ShowView()
    {
        $hoaDon = HoaDon::where('Trang_thai', '=', 0)->orderBy('Ma_hoa_don', 'DESC')->get();
        return view('admin.DonHang', ['hoaDon'=>$hoaDon]);
    }

    function XacNhanDonHang($id)
    {
        $hoaDon = HoaDon::find($id);
        $hoaDon->Trang_thai = 1;
        $hoaDon->save();

        // Cập nhật lại số lượng điện thoại trong kho
        $dsChiTiet = $hoaDon->ToGioHang->ToChiTietGioHang;
        foreach ($dsChiTiet as $chiTiet) {
            $dt = $chiTiet->ToDienThoaiDiDong;
            $dt->So_luong = $dt->So_luong - $chiTiet->So_luong;
            $dt->save();
        }

        return redirect('admin/donhang/danhsach')->with('thongbao', 'Xác nhận đơn hàng thành công');
    }

    function HuyBoDonHang($id)
    {
        $hoaDon = HoaDon::find($id);
        $Ma_gio_hang = $hoaDon->Ma_gio_hang;
        
        // Tăng số lượng điện thoại trong lên do hủy đơn hàng
        $dsChiTiet = $hoaDon->ToGioHang->ToChiTietGioHang;
        foreach ($dsChiTiet as $chiTiet) {
            $dt = $chiTiet->ToDienThoaiDiDong;
            $dt->So_luong = $dt->So_luong + $chiTiet->So_luong;
            $dt->save();
        }

        DB::table('Chi_tiet_gio_hang')->where('Ma_gio_hang', '=', $Ma_gio_hang)->delete();

        $hoaDon->delete();

        $gioHang = GioHang::find($Ma_gio_hang)->delete();

        return redirect('admin/donhang/danhsach')->with('thongbao', 'Hủy bỏ đơn hàng thành công');
    }
}
