<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HoaDon;
use App\DienThoaiDiDong;
use App\PHP_Classes\Price;

class ThongKeController extends Controller
{
    function getThongKe(){
        $sodonhang = HoaDon::where('Trang_thai', '=', 0)->count();

        $dsHoaDon = HoaDon::where('Trang_thai', '=', 1)->orderBy('Ma_hoa_don', 'DESC')->get();

        $dsMaDienThoai = array();
        $dsDienThoai = DienThoaiDiDong::all();
        foreach ($dsDienThoai as $dt) {
            $dsChiTiet = $dt->ToChiTietGioHang;
            
            // > 0 : Nếu tồn tại một chi tiết nào đó
            if(count($dsChiTiet) > 0)
            {
                // Kiểm tra có chi tiết nào nằm trong hóa đơn đã được thanh toán không
                foreach ($dsChiTiet as $chiTiet) {
                    if($chiTiet->ToGioHang->Da_thanh_toan == 1)
                    {
                        $trangThaiHoaDon = $chiTiet->ToGioHang->ToHoaDon->Trang_thai;
                        if( $trangThaiHoaDon == 1 )
                        {
                            $count = count($dsMaDienThoai);
                            $dsMaDienThoai[$count] = $dt->Ma_dien_thoai;
                            
                            break;
                        }
                    }                    
                }
            }
        }
        return view('admin.ThongKe', ['sodonhang'=>$sodonhang, 'dsHoaDon'=>$dsHoaDon, 'dsMaDienThoai'=>$dsMaDienThoai]);
    }

    function getThongKeHoaDonAjax($loaiThoiGian, $thoiGian)
    {
        $dsMaHoaDon = array();
        $dsHoaDon = HoaDon::orderBy('Ma_hoa_don', 'DESC')->get();
        $start = '';
        $end = '';
        
        // Kiểm tra hóa đơn nào đạt yêu cầu thời gian thì lấy mã hóa đơn
        foreach ($dsHoaDon as $hd) {
            $found = false;
            if( $hd->Trang_thai == 1)
            {
                // Chỉ lấy ngày tạo hóa đơn
                $index = strpos($hd->Ngay_tao, ' ');
                $ngayTaoHoaDon = substr($hd->Ngay_tao, 0, $index);
                
                if( $loaiThoiGian == 'ngay' )
                {
                    $start = $thoiGian;
                    if( $ngayTaoHoaDon == $start )
                    {
                        $found = true;
                    }
                }
                else if( $loaiThoiGian == 'thang' )
                {
                    $start = $thoiGian .'-01';
                    $end = $thoiGian .'-31';
                    if( $start <= $ngayTaoHoaDon && $ngayTaoHoaDon <= $end )
                    {
                        $found = true;
                    }
                }
                else if( $loaiThoiGian == 'nam' )
                {
                    $start = $thoiGian .'-01-01';
                    $end = $thoiGian .'-12-31';
                    if( $start <= $ngayTaoHoaDon && $ngayTaoHoaDon <= $end )
                    {
                        $found = true;
                    }
                }

                if( $found )
                {
                    $count = count($dsMaHoaDon);
                    $dsMaHoaDon[$count] = $hd->Ma_hoa_don;
                }
            }
        }

        //Ajax ra dữ liệu
        $price = new Price();
        echo '<thead>
                <tr>
                    <th>
                        Mã Hóa Đơn
                    </th>
                    <th>
                        Ngày
                    </th>
                    <th>
                        Tổng tiền
                    </th>
                    <th>
                        Thuế
                    </th>
                    <th>
                        Giá trị vốn
                    </th>
                    <th>
                        Lãi gộp
                    </th>
                    <th>
                        Khách hàng
                    </th>
                </tr>';
        echo '</thead>';
        echo '<tbody>';
            $tongThu = 0;
            $tongThue = 0;
            $tongVon = 0;
            $tongLai = 0;    
            foreach ($dsMaHoaDon as $maHD)
            {
                $hd = HoaDon::find($maHD);
                echo '<tr>
                        <td>
                            '. $hd->Ma_hoa_don .'
                        </td>
                        <td>
                            '. $hd->Ngay_tao .'
                        </td>
                        <td>';
                            $tongHoaDon = 0;
                            foreach ($hd->ToGioHang->ToChiTietGioHang as $chiTiet) {
                                $tongHoaDon += $chiTiet->So_luong * $chiTiet->ToGiaBan->Gia;
                            }
                            $tongThu += $tongHoaDon;    
                            
                        echo $price->ShowPrice($tongHoaDon) .' VND';
                    echo'</td>
                        <td>';
                            $tongThue += $tongHoaDon * 0.1;    
                            
                            echo $price->ShowPrice($tongHoaDon * 0.1) .' VND';
                    echo '</td>
                        <td>';
                            $tongVonHoaDon = 0;
                            foreach ($hd->ToGioHang->ToChiTietGioHang as $chiTiet) {
                                $tongVonHoaDon += $chiTiet->So_luong * $chiTiet->ToGiaBan->ToGiaVon->Gia;
                            }
                            $tongVon += $tongVonHoaDon;    
                            
                            echo $price->ShowPrice($tongVonHoaDon) .' VND';
                    echo '</td>
                        <td>';
                            $tongLai += $tongHoaDon - $tongVonHoaDon;    
                            
                            echo $price->ShowPrice($tongHoaDon - $tongVonHoaDon) .' VND';
                    echo '</td>
                        <td>';
                            $user = $hd->ToGioHang->ToTaiKhoan;    
                            
                            echo '<a href="id=00001">'. $user->Ho_va_ten_lot .' '. $user->Ten .'</a>';
                    echo '</td>
                </tr>';
            }
        echo '</tbody>';
        echo '<tfoot>
            <tr>
                <th colspan="6">Tổng thu:</th>
                <td>'. $price->ShowPrice($tongThu) .' VND</td>
            </tr>
            <tr>
                <th colspan="6">Tổng thuế:</th>
                <td>'. $price->ShowPrice($tongThue) .' VND</td>
            </tr>
            <tr>
                <th colspan="6">Tổng giá trị vốn:</th>
                <td>'. $price->ShowPrice($tongVon) .' VND</td>
            </tr>
            <tr>
                <th colspan="6">Tổng lãi gộp:</th>
                <td>'. $price->ShowPrice($tongLai) .' VND</td>
            </tr>
        </tfoot>';
    }

    function getThongKeDienThoaiAjax($loaiThoiGian, $thoiGian)
    {
        $dsMaDienThoai = array();
        $dsDienThoai = DienThoaiDiDong::all();
        foreach ($dsDienThoai as $dt) {
            $dsChiTiet = $dt->ToChiTietGioHang;
            
            // > 0 : Nếu tồn tại một chi tiết nào đó
            if(count($dsChiTiet) > 0)
            {
                // Kiểm tra có chi tiết nào nằm trong hóa đơn đã được thanh toán không
                foreach ($dsChiTiet as $chiTiet) {
                    $found = false;
                    // Kiểm tra chi tiết có nằm trong giỏ hàng đã được thanh toán không
                    if($chiTiet->ToGioHang->Da_thanh_toan == 1)
                    {
                        $hd = $chiTiet->ToGioHang->ToHoaDon;
                        if( $hd->Trang_thai == 1)
                        {
                            // Chỉ lấy ngày tạo hóa đơn (Trong ngày tạo có ngày và giờ)
                            $index = strpos($hd->Ngay_tao, ' ');
                            $ngayTaoHoaDon = substr($hd->Ngay_tao, 0, $index);
                            
                            if( $loaiThoiGian == 'ngay' )
                            {
                                $start = $thoiGian;
                                if( $ngayTaoHoaDon == $start )
                                {
                                    $found = true;
                                }
                            }
                            else if( $loaiThoiGian == 'thang' )
                            {
                                $start = $thoiGian .'-01';
                                $end = $thoiGian .'-31';
                                if( $start <= $ngayTaoHoaDon && $ngayTaoHoaDon <= $end )
                                {
                                    $found = true;
                                }
                            }
                            else if( $loaiThoiGian == 'nam' )
                            {
                                $start = $thoiGian .'-01-01';
                                $end = $thoiGian .'-12-31';
                                if( $start <= $ngayTaoHoaDon && $ngayTaoHoaDon <= $end )
                                {
                                    $found = true;
                                }
                            }

                            if( $found )
                            {
                                $count = count($dsMaDienThoai);
                                $dsMaDienThoai[$count] = $dt->Ma_dien_thoai;

                                break;
                            }
                        }
                        // $trangThaiHoaDon = $hd->Trang_thai;
                        // if( $trangThaiHoaDon == 1 )
                        // {
                        //     $count = count($dsMaDienThoai);
                        //     $dsMaDienThoai[$count] = $dt->Ma_dien_thoai;
                            
                        //     break;
                        // }
                    }                    
                }
            }
        }
        // Hiển thị dữ liệu
        $price = new Price();
        foreach ($dsMaDienThoai as $maDT)
        {
            $tongTienDT = 0;
            $tongVonDT = 0;
            $tongLaiDT = 0;
            $soLuongBanDT = 0;

            $dt = DienThoaiDiDong::find($maDT);
            $dsChiTiet = $dt->ToChiTietGioHang;
            foreach ($dsChiTiet as $chiTiet) {
                if( $chiTiet->ToGioHang->Da_thanh_toan == 1 )
                {
                    if( $chiTiet->ToGioHang->ToHoaDon->Trang_thai == 1 )
                    {
                        $tongTienDT += $chiTiet->So_luong * $chiTiet->ToGiaBan->Gia;
                        $tongVonDT += $chiTiet->So_luong * $chiTiet->ToGiaBan->ToGiaVon->Gia;
                        $tongLaiDT += ($chiTiet->So_luong * $chiTiet->ToGiaBan->Gia) - ($chiTiet->So_luong * $chiTiet->ToGiaBan->ToGiaVon->Gia);
                        $soLuongBanDT += $chiTiet->So_luong;
                    }
                }
            }
            echo '<tr>
                    <td>
                        '. $dt->Ma_dien_thoai .'
                    </td>
                    <td>
                        '. $dt->Ten_dien_thoai .'
                    </td>
                    <td>
                        '. $price->ShowPrice($tongTienDT) .' VND
                    </td>
                    <td>
                        '. $price->ShowPrice($tongTienDT * 0.1) .' VND
                    </td>
                    <td>
                        '. $price->ShowPrice($tongVonDT) .' VND
                    </td>
                    <td>
                        '. $price->ShowPrice($tongLaiDT) .' VND
                    </td>
                    <td>
                        '. $soLuongBanDT .'
                    </td>';
            echo '</tr>';
        }
    }
}
