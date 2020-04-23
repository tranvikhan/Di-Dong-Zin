<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\HoaDon;

class DonHangController extends Controller
{
    function ShowView()
    {
        $hoaDon = HoaDon::where('Trang_thai', '=', 0)->get();
        return view('admin.DonHang', ['hoaDon'=>$hoaDon]);
    }

    function XacNhanDonHang($id)
    {
        $hoaDon = HoaDon::find($id);
        $hoaDon->Trang_thai = 1;
        $hoaDon->save();

        return redirect('admin/donhang/danhsach')->with('thongbao', 'Xác nhận đơn hàng thành công');
    }

    function HuyBoDonHang($id)
    {
        $hoaDon = HoaDon::find($id);
        $Ma_gio_hang = $hoaDon->Ma_gio_hang;
        
        DB::table('Chi_tiet_gio_hang')->where('Ma_gio_hang', '=', $Ma_gio_hang)->delete();

        $hoaDon->delete();

        return redirect('admin/donhang/danhsach')->with('thongbao', 'Hủy bỏ đơn hàng thành công');
    }
}
