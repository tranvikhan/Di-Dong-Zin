<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DienThoaiDiDong;
use App\GiaBan;
use App\HangDienThoaiDiDong;
use App\HoaDon;

class AjaxController extends Controller
{
    function FilterPhone($hangDT, $mucGia, $sapXep)
    {
        $dsHangDT;               
        $dsMaDienThoaiTheoHang = array();     //danh sách mã điện thoại đã lọc theo hãng điện thoại
        $dsMaDienThoaiTheoGia = array();      //danh sách mã điện thoại đã lọc theo mức giá
        $dsMaDienThoaiTheoSapXep = array();   //danh sách mã điện thoại đã lọc theo sắp xếp

        //------------- LỌC ĐIỆN THOẠI THEO HÃNG ---------------------------------------------
        if($hangDT != "khongChon")
        {
            $dsHangDT = DienThoaiDiDong::where([
                ['Ma_hang_dien_thoai', '=', $hangDT],
                ['Dang_ban', '=', 1]
            ])->get();
        }
        else if($hangDT == "khongChon")
        {
            $dsHangDT = DienThoaiDiDong::where('Dang_ban', '=', 1)->get();
        }
        
        foreach ($dsHangDT as $dt) {
            $amount = count($dsMaDienThoaiTheoHang);
            $dsMaDienThoaiTheoHang[$amount] = $dt->Ma_dien_thoai;
        }
        
        //--------------- LỌC THEO MỨC GIÁ ---------------------------------------------
        if($mucGia == 'khongChon')
        {
            $dsMaDienThoaiTheoGia = $dsMaDienThoaiTheoHang;
        }
        else //Đã chọn một trong các mức giá
        {
            foreach ($dsMaDienThoaiTheoHang as $maDT) {

                switch ($mucGia) {
                    //DƯỚI 2 TRIỆU
                    case 'duoi2':
                        $dsGiaBan = DienThoaiDiDong::find($maDT)->ToGiaBan;
                        foreach ($dsGiaBan as $item) {
                            if( ($item->Trang_thai==1) && ($item->Gia < 2000000) )
                            {
                                $amount = count($dsMaDienThoaiTheoGia);
                                $dsMaDienThoaiTheoGia[$amount] = $maDT;
                            }
                        }
                        break;
                    
                    //TỪ 2 TRIỆU ĐẾN 5 TRIỆU
                    case '2Den5':
                        $dsGiaBan = DienThoaiDiDong::find($maDT)->ToGiaBan;
                        foreach ($dsGiaBan as $item) {
                            if( ($item->Trang_thai==1) && (2000000 <= $item->Gia) && ($item->Gia < 5000000) )
                            {
                                $amount = count($dsMaDienThoaiTheoGia);
                                $dsMaDienThoaiTheoGia[$amount] = $maDT;
                            }
                        }
                        break;
                    
                    //TỪ 5 TRIỆU ĐẾN 10 TRIỆU
                    case '5Den10':
                        $dsGiaBan = DienThoaiDiDong::find($maDT)->ToGiaBan;
                        foreach ($dsGiaBan as $item) {
                            if( ($item->Trang_thai==1) && (5000000 <= $item->Gia) && ($item->Gia < 10000000) )
                            {
                                $amount = count($dsMaDienThoaiTheoGia);
                                $dsMaDienThoaiTheoGia[$amount] = $maDT;
                            }
                        }
                        break;
        
                    //TỪ 10 TRIỆU ĐẾN 15 TRIỆU
                    case '10Den15':
                        $dsGiaBan = DienThoaiDiDong::find($maDT)->ToGiaBan;
                        foreach ($dsGiaBan as $item) {
                            if( ($item->Trang_thai==1) && (10000000 <= $item->Gia) && ($item->Gia < 15000000) )
                            {
                                $amount = count($dsMaDienThoaiTheoGia);
                                $dsMaDienThoaiTheoGia[$amount] = $maDT;
                            }
                        }
                        break;
        
                    //TRÊN 15 TRIỆU
                    case 'tren15':
                        $dsGiaBan = DienThoaiDiDong::find($maDT)->ToGiaBan;
                        foreach ($dsGiaBan as $item) {
                            if( ($item->Trang_thai==1) && (15000000 <= $item->Gia) )
                            {
                                $amount = count($dsMaDienThoaiTheoGia);
                                $dsMaDienThoaiTheoGia[$amount] = $maDT;
                            }
                        }
                        break;
                }
            }
        }

        //------------ SẮP XẾP ĐIỆN THOẠI THEO GIÁ BÁN -----------------------------
            
            //TẠO DANH SÁCH MÃ ĐIỆN THOẠI DÙNG ĐỂ SẮP XẾP LẠI
        $dsMaDienThoaiTheoSapXep = $dsMaDienThoaiTheoGia;

        //LIỆT KÊ RA DANH SÁCH CÁC GIÁ CỦA CÁC ĐIỆN THOẠI (DANH SÁCH NÀY CHỈ CHỨA GIÁ CỦA CÁC ĐIỆN THOẠI)
        $dsGia = array();
        foreach ($dsMaDienThoaiTheoGia as $maDT) {
            
            //Xuất ra 1 danh sách các đối tượng
            $dsGiaBan = DienThoaiDiDong::find($maDT)->ToGiaBan;
            foreach ($dsGiaBan as $item) {
                
                //Tìm đối tượng thỏa điều kiện (Trang_thai = 1: giá này đang được sử dụng)
                if( $item->Trang_thai == 1 )
                {
                    //Thêm vào mảng chứa danh sách các giá $dsGia
                    $amount = count($dsGia);
                    $dsGia[$amount] = $item->Gia;
                }
            }
        }

        //SẮP XẾP THEO GIÁ CAO ĐẾN THẤP
        if($sapXep == 'giaCao')
        {
            for ($i=0; $i < count($dsGia)-1; $i++) { 
                for ($j=$i+1; $j < count($dsGia); $j++) { 
                    if($dsGia[$i] < $dsGia[$j])
                    {
                        //SWAP dsGia
                        $temp = $dsGia[$i];
                        $dsGia[$i] = $dsGia[$j];
                        $dsGia[$j] = $temp;

                        //SWAP dsDienThoaiTheoSapXep
                        $temp = $dsMaDienThoaiTheoSapXep[$i];
                        $dsMaDienThoaiTheoSapXep[$i] = $dsMaDienThoaiTheoSapXep[$j];
                        $dsMaDienThoaiTheoSapXep[$j] = $temp;
                    }
                }
            }
        }

        //SẮP XẾP THEO GIÁ THẤP ĐẾN CAO
        else if($sapXep == 'giaThap')
        {
            for ($i=0; $i < count($dsGia)-1; $i++) { 
                for ($j=$i+1; $j < count($dsGia); $j++) { 
                    if($dsGia[$i] > $dsGia[$j])
                    {
                        //SWAP dsGia
                        $temp = $dsGia[$i];
                        $dsGia[$i] = $dsGia[$j];
                        $dsGia[$j] = $temp;

                        //SWAP dsDienThoaiTheoSapXep
                        $temp = $dsMaDienThoaiTheoSapXep[$i];
                        $dsMaDienThoaiTheoSapXep[$i] = $dsMaDienThoaiTheoSapXep[$j];
                        $dsMaDienThoaiTheoSapXep[$j] = $temp;
                    }
                }
            }
        }
        //GHI CHÚ: Ta không cần xét trường hợp 'khongChon', do ban đầu ta đã có $dsDienThoaiTheoSapXep = $dsDienThoaiTheoGia;       

        echo '<table>';
                echo '<tr>';
                    echo '<th>';
                        echo '<label class="mycheckbox">';
                            echo '<input type="checkbox" id="checkAll">';
                            echo '<span class="checkmark"></span>';
                        echo '</label>';
                    echo '</th>';
                    echo '<th>';
                        echo 'Ảnh';
                    echo '</th>';
                    echo '<th>';
                        echo 'Tên';
                    echo '</th>';
                    echo '<th>';
                        echo 'Mã';
                    echo '</th>';
                    echo '<th>';
                        echo 'Giá';
                    echo '</th>';
                    echo '<th>';
                        echo 'Giá khuyến mãi';
                    echo '</th>';
                    echo '<th>';
                        echo 'Hãng';
                    echo '</th>';
                    
                echo '</tr>';
                foreach ($dsMaDienThoaiTheoSapXep as $maDT) 
                {
                    $dt = DienThoaiDiDong::find($maDT);
                    if($dt->Dang_ban == 1)
                    {
                        echo '<tr>';
                            echo '<td>';
                                echo '<label class="mycheckbox">';
                                    echo '<input type="checkbox" name="check_phone[]">';
                                    echo '<span class="checkmark"></span>';
                                echo '</label>';
                            echo '</td>';
                            echo '<td>';
                                echo '<img src="DiDongZin/imagePhone/'. $dt->Hinh_anh .'">';
                            echo '</td>';
                            echo '<td>';
                                echo $dt->Ten_dien_thoai;
                                echo '<div class="mini-action">';
                                    echo '<a href="#">Xem</a>';
                                    echo '<a onclick="loadPage(\'admin/dienthoai/sua/'. $dt->Ma_dien_thoai .'\')">Chỉnh sửa</a>';
                                    echo '<a href="admin/dienthoai/xoa/'. $dt->Ma_dien_thoai .'" onclick="return XoaDienThoai(\''. $dt->Ten_dien_thoai .'\')">Xóa</a>';
                                echo '</div>';
                            echo '</td>';
                            echo '<td>';
                                echo $dt->Ma_dien_thoai;
                            echo '</td>';
                            echo '<td>';
                                echo $dt->ToGiaBan->last()->Gia;
                            echo '</td>';
                            echo '<td>';
                                //Lấy ngày hiện tại
                                date_default_timezone_set('Asia/Ho_Chi_Minh');
                                $today = date('Y-m-d');

                                //Lấy giá điện thoại
                                $gia = $dt->ToGiaBan->last()->Gia;

                                //Lấy ra ngày bắt đầu và ngày kết thúc khuyến mãi
                                $startDay = 0;
                                $endDay = 0;    //Ngày khuyến mãi kết thúc
                                $percent = 0;   //Phần trăm khuyến mãi của chương trình này
                                $khuyenMai = $dt->ToKhuyenMai->last();
                                if($khuyenMai !== null)
                                {
                                    $startDay = $khuyenMai->Tu_ngay;
                                    $endDay = $khuyenMai->Den_ngay;
                                    $percent = $khuyenMai->Phan_tram_khuyen_mai;
                                }
                                
                                if($startDay<=$today && $today <= $endDay)
                                {
                                    echo $gia*(1-($percent/100));
                                }
                                else
                                {
                                    echo '--';
                                }
                                    
                            echo '</td>';
                            echo '<td>';
                                echo $dt->ToHangDienThoaiDiDong->Ten_hang;
                            echo '</td>';
                            
                        echo '</tr>';
                    }      
                }                
        echo '</table>';
    }

    function FindPhone($noiDung)
    {
        $dienThoai = DienThoaiDiDong::where('Dang_ban', '=', 1)->get();
        $dsMaDienThoai = array();

        if( is_numeric($noiDung) )
        {
            $max = DienThoaiDiDong::where('Dang_ban', '=', 1)->max('Ma_dien_thoai');
            $num = (int)$noiDung;

            if( 1<=$noiDung && $noiDung<=$max)
            {
                $count = count($dsMaDienThoai);
                $dsMaDienThoai[$count] = $num;
            }
        }
        else //Nếu dữ liệu nhập vào không phải là số
        {
            foreach ($dienThoai as $dt) {
                if( strpos($dt->Ten_dien_thoai, $noiDung) !== false )
                {
                    $count = count($dsMaDienThoai);
                    $dsMaDienThoai[$count] = $dt->Ma_dien_thoai;
                }
            }
        }
        
        echo '<table>';
                echo '<tr>';
                    echo '<th>';
                        echo '<label class="mycheckbox">';
                            echo '<input type="checkbox" id="checkAll">';
                            echo '<span class="checkmark"></span>';
                        echo '</label>';
                    echo '</th>';
                    echo '<th>';
                        echo 'Ảnh';
                    echo '</th>';
                    echo '<th>';
                        echo 'Tên';
                    echo '</th>';
                    echo '<th>';
                        echo 'Mã';
                    echo '</th>';
                    echo '<th>';
                        echo 'Giá';
                    echo '</th>';
                    echo '<th>';
                        echo 'Giá khuyến mãi';
                    echo '</th>';
                    echo '<th>';
                        echo 'Hãng';
                    echo '</th>';
                    
                echo '</tr>';
                foreach ($dsMaDienThoai as $maDT) 
                {
                    $dt = DienThoaiDiDong::find($maDT);
                    if($dt->Dang_ban == 1)
                    {
                        echo '<tr>';
                            echo '<td>';
                                echo '<label class="mycheckbox">';
                                    echo '<input type="checkbox" name="check_phone[]">';
                                    echo '<span class="checkmark"></span>';
                                echo '</label>';
                            echo '</td>';
                            echo '<td>';
                                echo '<img src="DiDongZin/imagePhone/'. $dt->Hinh_anh .'">';
                            echo '</td>';
                            echo '<td>';
                                echo $dt->Ten_dien_thoai;
                                echo '<div class="mini-action">';
                                    echo '<a href="#">Xem</a>';
                                    echo '<a onclick="loadPage(\'admin/dienthoai/sua/'. $dt->Ma_dien_thoai .'\')">Chỉnh sửa</a>';
                                    echo '<a href="admin/dienthoai/xoa/'. $dt->Ma_dien_thoai .'" onclick="return XoaDienThoai(\''. $dt->Ten_dien_thoai .'\')">Xóa</a>';
                                echo '</div>';
                            echo '</td>';
                            echo '<td>';
                                echo $dt->Ma_dien_thoai;
                            echo '</td>';
                            echo '<td>';
                                echo $dt->ToGiaBan->last()->Gia;
                            echo '</td>';
                            echo '<td>';
                                //Lấy ngày hiện tại
                                date_default_timezone_set('Asia/Ho_Chi_Minh');
                                $today = date('Y-m-d');

                                //Lấy giá điện thoại
                                $gia = $dt->ToGiaBan->last()->Gia;

                                //Lấy ra ngày bắt đầu và ngày kết thúc khuyến mãi
                                $startDay = 0;
                                $endDay = 0;    //Ngày khuyến mãi kết thúc
                                $percent = 0;   //Phần trăm khuyến mãi của chương trình này
                                $khuyenMai = $dt->ToKhuyenMai->last();
                                if($khuyenMai !== null)
                                {
                                    $startDay = $khuyenMai->Tu_ngay;
                                    $endDay = $khuyenMai->Den_ngay;
                                    $percent = $khuyenMai->Phan_tram_khuyen_mai;
                                }
                                
                                if($startDay<=$today && $today <= $endDay)
                                {
                                    echo $gia*(1-($percent/100));
                                }
                                else
                                {
                                    echo '--';
                                }
                                    
                            echo '</td>';
                            echo '<td>';
                                echo $dt->ToHangDienThoaiDiDong->Ten_hang;
                            echo '</td>';
                            
                        echo '</tr>';
                    }      
                }                
        echo '</table>';
    }

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
