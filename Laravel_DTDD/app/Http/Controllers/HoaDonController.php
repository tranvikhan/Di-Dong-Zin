<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HoaDon;

class HoaDonController extends Controller
{
    function getDanhSach()
    {
        $hoaDon = HoaDon::where('Trang_thai', '=', 1)->get();
        return view('admin.HoaDon', ['hoaDon'=>$hoaDon]);
    }

    //-------------------------------------------------------------------------------------
    // ------------------------- AJAX -----------------------------------------------------
    function FindBill($id)
    {
        $found = false;
        if( is_numeric($id) )
        {
            $max = HoaDon::where('Trang_thai', '=', 1)->max('Ma_hoa_don');
            $num = (int)$id;

            if( 1<=$num && $num<=$max)
            {
                $found = true;
                $hoaDon = HoaDon::find($num);
                
                echo '<div class="hoadon">';
                    
                    echo '<table class="tb1">';
                        echo '<tr>';
                            echo '<th>Mã đơn hàng:</th>';
                            echo '<td>'. $hoaDon->Ma_hoa_don .'</td>';
                            echo '<th>Ngày tạo:</th>';
                            echo '<td>'. $hoaDon->Ngay_tao .'</td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<th>Khách hàng:</th>';
                            echo '<td>'. $hoaDon->ToGioHang->ToTaiKhoan->Ho_va_ten_lot .' '. $hoaDon->ToGioHang->ToTaiKhoan->Ten .'</td>';
                            echo '<th>Mã khách hàng:</th>';
                            echo '<td>'. $hoaDon->ToGioHang->ToTaiKhoan->Ma_tai_khoan .'</td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<th>Số điện thoại:</th>';
                            echo '<td>'. $hoaDon->ToGioHang->ToTaiKhoan->So_dien_thoai .'</td>';
                            echo '<th>Hình thức thanh toán:</th>';
                            echo '<td>'. $hoaDon->Hinh_thuc_thanh_toan .'</td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<th>Địa chỉ nhận hàng:</th>';
                            echo '<td colspan="3">'. $hoaDon->Dia_chi_nhan_hang .'</td>';

                        echo '</tr>';
                    echo '</table>';
                    echo '<table class="tb2">';
                        echo '<tr>';
                            echo '<th>';
                                echo 'STT';
                            echo '</th>';
                            echo '<th>';
                                echo 'Điện thoại';
                            echo '</th>';
                            echo '<th>';
                                echo 'Số lượng';
                            echo '</th>';
                            echo '<th>';
                                echo 'Đơn giá';
                            echo '</th>';
                            echo '<th>';
                                echo 'Thành tiền';
                            echo '</th>';
                        echo '</tr>';
                        
                            $count = 1;
                            $tongCong = 0;
                        
                        foreach ($hoaDon->ToGioHang->ToChiTietGioHang as $chiTiet) {
                            echo '<tr>';
                                echo '<td>';
                                    echo $count;
                                    $count++;
                                echo '</td>';
                                echo '<td>';
                                echo '<img src="DiDongZin/imagePhone/'. $chiTiet->ToDienThoaiDiDong->Hinh_anh .'" width="50px">';
                                    echo '<span>'. $chiTiet->ToDienThoaiDiDong->Ten_dien_thoai .'</span>';
                                echo '</td>';
                                echo '<td>';
                                    echo $chiTiet->So_luong;
                                echo '</td>';
                                echo '<td>';
                                    echo $chiTiet->ToGiaBan->Gia;
                                echo '</td>';
                                echo '<td>';
                                    echo $chiTiet->So_luong *  $chiTiet->ToGiaBan->Gia;

                                    $tongCong +=  $chiTiet->So_luong *  $chiTiet->ToGiaBan->Gia; 
                                    
                                echo '</td>';
                            echo '</tr>';
                        }
                        
                        echo '<tr>';
                            echo '<th colspan="4">';
                                echo 'Tổng cộng:';
                            echo '</th>';
                            echo '<td>';
                                echo $tongCong;
                            echo '</td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<th colspan="4">';
                                echo 'Thuế VAT:';
                            echo '</th>';
                            echo '<td>';
                                echo ($hoaDon->Thue_VAT / 100) * $tongCong;
                            echo '</td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<th colspan="4">';
                                echo 'Tổng thanh toán:';
                            echo '</th>';
                            echo '<td>';
                                echo $tongCong + ($hoaDon->Thue_VAT / 100) * $tongCong;
                            echo '</td>';
                        echo '</tr>';
                    echo '</table>';
                    
                    echo '<div class="g-btn-xacnhan">';
                        echo '<button class="btnThemdienthoai" onclick="InHoaDon('. $hoaDon->Ma_hoa_don .')"><img src="DiDongZin/assets/img/print_30px.png">In hóa đơn</button>';
                    echo '</div>';
                echo '</div>';
            }  
        }
        if( !$found )
        {
            echo '0';
        }
    }
}
