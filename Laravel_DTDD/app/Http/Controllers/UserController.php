<?php

namespace App\Http\Controllers;

use App\PHP_Classes\Price;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;
use Mail;
use App\Mail\MailDoiMatKhau;

use App\TaiKhoan;
use App\DienThoaiDiDong;
use App\BinhLuan;
use App\GioHang;
use App\ChiTietGioHang;
use App\HoaDon;

class UserController extends Controller
{
    // ===========================================================================================
    // ---------------- TRANG CHỦ ----------------------------------------------------------------
    // ===========================================================================================

    function getTrangChu()
    {
        // Xác định số lượng hiển thị tối đa và số lượng hiển thị hiện tại của GIẢM GIÁ, BÁN CHẠY, TẤT CẢ ĐIỆN THOẠI
            // GIẢM GIÁ
        $soLuongToiDa_GiamGia = 0;
        $soLuongHienTai_GiamGia = 0;
            // BÁN CHẠY
        $soLuongToiDa_BanChay = 0;
        $soLuongHienTai_BanChay = 0;
            // TẤT CẢ ĐIỆN THOẠI
        $soLuongToiDa_TatCa = 0;
        $soLuongHienTai_TatCa = 0;

        //Danh sách điện thoại ---------------------------------------------------------
        $soLuongDT = DienThoaiDiDong::where([
                ['Dang_ban', '=', 1],
                ['So_luong', '>', 0]
            ])->count();
        $dsDienThoai;
        
        $soLuongToiDa_TatCa = $soLuongDT;
        if($soLuongDT >= 12)
        {
            $dsDienThoai = DienThoaiDiDong::where([
                    ['Dang_ban', '=', 1],
                    ['So_luong', '>', 0]
                ])->orderBy('Ma_dien_thoai', 'desc')->take(12)->get();
            $soLuongHienTai_TatCa = 12;
        }
        else
        {
            $dsDienThoai = DienThoaiDiDong::where([
                    ['Dang_ban', '=', 1],
                    ['So_luong', '>', 0]
                ])->orderBy('Ma_dien_thoai', 'desc')->get();
            $soLuongHienTai_TatCa = $soLuongDT;
        }       
        
        //Danh sách điện thoại bán chạy --------------------------------------------------
        $dsMaDT = array();
        $dsSoLuongBan = array();
        $count = 0;

        $dienThoai = DienThoaiDiDong::where([
                ['Dang_ban', '=', 1],
                ['So_luong', '>', 0]
            ])->get();

        // Tạo danh sách chứa mã điện thoại và số lượng bán được của điện thoại đó
        foreach ($dienThoai as $dt) {
            $dsMaDT[$count] = $dt->Ma_dien_thoai;
            $dsSoLuongBan[$count] = $dt->ToChiTietGioHang->count();
            $count++;
        }

        // Sắp xếp lại theo thứ tự giảm dần
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
        $soLuongToiDa_BanChay = count($dsMaDT);
        if(count($dsMaDT) < 6){
            $soLuongHienTai_BanChay = count($dsMaDT);
        }
        else{
            $soLuongHienTai_BanChay = 6;
        }
            
        $dsMaBanChay = array();
        for ($i=0; $i < $soLuongHienTai_BanChay; $i++) { 
            $dsMaBanChay[$i] = $dsMaDT[$i];
        }

        //Danh sách điện thoại giảm giá mạnh -------------------------------------------------
        $dsMaDT = array();
        $dsSoLuongKM = array();
        $count = 0;

            //Lấy ngày hôm nay
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $today = date('Y-m-d');

        $dienThoai = DienThoaiDiDong::where([
                ['Dang_ban', '=', 1],
                ['So_luong', '>', 0]
            ])->get();

        // Tạo danh sách mã điện thoại và danh sách chứa phần trăm khuyến mãi
        foreach ($dienThoai as $dt) {
            $hasKM = false;
            $km = $dt->ToKhuyenMai->last();
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

        // Sắp xếp lại 2 danh sách này dựa vào phần trăm khuyến mãi
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
        $soLuongToiDa_GiamGia = count($dsMaDT);
        if(count($dsMaDT) < 6){
            $soLuongHienTai_GiamGia = count($dsMaDT);
        }
        else{
            $soLuongHienTai_GiamGia = 6;
        }
            
        $dsMaGiamGia = array();
        for ($i=0; $i < $soLuongHienTai_GiamGia; $i++) { 
            $dsMaGiamGia[$i] = $dsMaDT[$i];
        }

        return view('user.content', ['dsDienThoai'=>$dsDienThoai, 'dsMaBanChay'=>$dsMaBanChay, 'dsMaGiamGia'=>$dsMaGiamGia, 
                    'soLuongToiDa_TatCa'=>$soLuongToiDa_TatCa, 'soLuongHienTai_TatCa'=>$soLuongHienTai_TatCa,
                    'soLuongToiDa_BanChay'=>$soLuongToiDa_BanChay, 'soLuongHienTai_BanChay'=>$soLuongHienTai_BanChay,
                    'soLuongToiDa_GiamGia'=>$soLuongToiDa_GiamGia, 'soLuongHienTai_GiamGia'=>$soLuongHienTai_GiamGia  
                ]);
    }
        
    function TimDienThoaiAjax($noiDung)
    {
        $dienThoai = DienThoaiDiDong::where([
                ['Dang_ban', '=', 1],
                ['So_luong', '>', 0]
            ])->get();
        $dsMaDienThoai = array();
        $price = new Price();

        foreach ($dienThoai as $dt) {
            // Ta làm cho noiDung và tên điện thoại thành chữ thường (strlower)
            $tenDT = strtolower($dt->Ten_dien_thoai);
            $noiDung = strtolower($noiDung);
            
            if( strpos($tenDT, $noiDung) !== false )
            {
                $count = count($dsMaDienThoai);
                $dsMaDienThoai[$count] = $dt->Ma_dien_thoai;
            }
        }
        
        //Hiển thị tối đa 4 điện thoại
        $max = 0;
        if(count($dsMaDienThoai) > 4)
        {
            $max =  4;
        }
        else
        {
            $max = count($dsMaDienThoai);
        }
        $price = new Price();
        for($i = 0; $i < $max; $i++)
        {
            $dt = DienThoaiDiDong::find($dsMaDienThoai[$i]);
            
            echo '<div class="phone-results" onclick="window.location.href=\'DienThoai/'. $dt->Ma_dien_thoai .'.html\'">';
                echo '<img src="DiDongZin/imagePhone/'. $dt->Hinh_anh .'" alt="'. $dt->Ten_dien_thoai .'"/>';
                echo '<h2 class="name">'. $dt->Ten_dien_thoai .'</h2>';
        
                //Lấy ngày hiện tại
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $today = date('Y-m-d');

                //Lấy giá điện thoại
                $gia = $dt->ToGiaBan->last()->Gia;

                //Lấy ra ngày bắt đầu và ngày kết thúc khuyến mãi
                $hasKM = false;
                $startDay = 0;
                $endDay = 0;    //Ngày khuyến mãi kết thúc
                $percent = 0;   //Phần trăm khuyến mãi của chương trình này
                $khuyenMai = $dt->ToKhuyenMai->last();
                if($khuyenMai !== null)
                {
                    $startDay = $khuyenMai->Tu_ngay;
                    $endDay = $khuyenMai->Den_ngay;
                    if( $startDay<=$today && $today <= $endDay )
                    {
                        $hasKM = true;
                        $percent = $khuyenMai->Phan_tram_khuyen_mai;
                    }                                        
                }
                if ( $hasKM )
                {
                    echo '<span class="price">'. $price->ShowPrice( $gia*(1-($percent/100)) ) .' VND</span>';
                }
                else
                {
                    echo '<span class="price">'. $price->ShowPrice( $dt->ToGiaBan->last()->Gia ).' VND</span>';
                }
            echo '</div>';
        }
    }

    function SapXepDienThoaiAjax($noiDung, $maHangDT, $mucGia, $sapXep)
    {
        $dsDienThoai;               
        $dsMaDienThoaiTheoNoiDung = array();  //danh sách mã điện thoại đã lọc theo nội dung tìm kiếm
        $dsMaDienThoaiTheoHangDT = array();   //danh sách mã điện thoại đã lọc theo nội dung hãng điện thoại
        $dsMaDienThoaiTheoGia = array();      //danh sách mã điện thoại đã lọc theo mức giá
        $dsMaDienThoaiTheoSapXep = array();   //danh sách mã điện thoại đã lọc theo sắp xếp

        //------------- LỌC ĐIỆN THOẠI THEO HÃNG ---------------------------------------------
        $dsDienThoai = DienThoaiDiDong::where([
                ['Dang_ban', '=', 1],
                ['So_luong', '>', 0]
            ])->get();
        
        if($noiDung != "khongChon")
        {
            foreach ($dsDienThoai as $dt) {
                // Ta làm cho noiDung và tên điện thoại thành chữ thường (strtolower)
                $tenDT = strtolower($dt->Ten_dien_thoai);
                $noiDung = strtolower($noiDung);
                
                if( strpos($tenDT, $noiDung) !== false )
                {
                    $count = count($dsMaDienThoaiTheoNoiDung);
                    $dsMaDienThoaiTheoNoiDung[$count] = $dt->Ma_dien_thoai;
                }
            }
        }
        else if($noiDung == "khongChon")
        {
            // Nội dung không được chọn sẽ đổ toàn bộ mã vào dsMaDienThoaiTheoNoiDung
            foreach ($dsDienThoai as $dt) {
                $count = count($dsMaDienThoaiTheoNoiDung);
                $dsMaDienThoaiTheoNoiDung[$count] = $dt->Ma_dien_thoai;
            }
        }

        //--------------- LỌC THEO HÃNG ĐIỆN THOẠI -------------------------------------
        if($maHangDT != 'khongChon')
        {
            // Do hãng điện thoại và nội dung không kết hợp bộ lọc
                // Nên ta có thể lọc hãng riêng, không cần dựa vào dsMaDienThoaiTheoNoiDung
            $dsDienThoai = DienThoaiDiDong::where('Ma_hang_dien_thoai', '=', $maHangDT)->get();
            foreach ($dsDienThoai as $dt)
            {
                $count = count($dsMaDienThoaiTheoHangDT);
                $dsMaDienThoaiTheoHangDT[$count] = $dt->Ma_dien_thoai;
            }
        }
        else if($maHangDT == 'khongChon')
        {
            $dsMaDienThoaiTheoHangDT = $dsMaDienThoaiTheoNoiDung;
        }
        
        //--------------- LỌC THEO MỨC GIÁ ---------------------------------------------
        if($mucGia == 'khongChon')
        {
            $dsMaDienThoaiTheoGia = $dsMaDienThoaiTheoHangDT;
        }
        else //Đã chọn một trong các mức giá
        {
            foreach ($dsMaDienThoaiTheoHangDT as $maDT) 
            {
                $gia = DienThoaiDiDong::find($maDT)->ToGiaBan->last();
                switch ($mucGia) {
                    //DƯỚI 2 TRIỆU
                    case 'duoi2':
                        if( $gia->Gia < 2000000 )
                        {
                            $amount = count($dsMaDienThoaiTheoGia);
                            $dsMaDienThoaiTheoGia[$amount] = $maDT;
                        }
                        break;
                    
                    //TỪ 2 TRIỆU ĐẾN 5 TRIỆU
                    case '2Den5':
                        if( (2000000 <= $gia->Gia) && ($gia->Gia < 5000000) )
                        {
                            $amount = count($dsMaDienThoaiTheoGia);
                            $dsMaDienThoaiTheoGia[$amount] = $maDT;
                        }
                        break;
                    
                    //TỪ 5 TRIỆU ĐẾN 10 TRIỆU
                    case '5Den10':
                        if( (5000000 <= $gia->Gia) && ($gia->Gia < 10000000) )
                        {
                            $amount = count($dsMaDienThoaiTheoGia);
                            $dsMaDienThoaiTheoGia[$amount] = $maDT;
                        }
                        break;
        
                    //TỪ 10 TRIỆU ĐẾN 15 TRIỆU
                    case '10Den15':
                        if( (10000000 <= $gia->Gia) && ($gia->Gia < 15000000) )
                        {
                            $amount = count($dsMaDienThoaiTheoGia);
                            $dsMaDienThoaiTheoGia[$amount] = $maDT;
                        }
                        break;
        
                    //TRÊN 15 TRIỆU
                    case 'tren15':
                        if( 15000000 <= $gia->Gia )
                        {
                            $amount = count($dsMaDienThoaiTheoGia);
                            $dsMaDienThoaiTheoGia[$amount] = $maDT;
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
            // Không cần kiểm tra Trang_thai: vì giá nào cùng chắc chắn có một item cuối cùng có Trang_thai=1
            $gia = DienThoaiDiDong::find($maDT)->ToGiaBan->last();

            //Thêm vào mảng chứa danh sách các giá $dsGia
            $amount = count($dsGia);
            $dsGia[$amount] = $gia->Gia;
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

        //Tạo biến $price để dùng ShowPrice của class Price
        $price = new Price();

        foreach($dsMaDienThoaiTheoSapXep as $maDT)
        {
            $dt = DienThoaiDiDong::find($maDT);
            
            echo '<div class="col-2s" onclick="GoToPhone('. $dt->Ma_dien_thoai .')">';
                echo '<div class="mobile-phone">';
                    echo '<img src="DiDongZin/imagePhone/'. $dt->Hinh_anh .'" style="height: 215px" alt="'. $dt->Ten_dien_thoai .'">';
                    echo '<h2 class="name">'. $dt->Ten_dien_thoai .'</h2>';
                    echo '<span class="price">'. $price->ShowPrice($dt->ToGiaBan->last()->Gia) .' VND</span>';
                echo '</div>';
                echo '<div class="hidden-info">';
                    echo '<h2 class="name">'. $dt->Ten_dien_thoai .'</h2>';
                    echo '<span class="price">'. $price->ShowPrice($dt->ToGiaBan->last()->Gia) .' VND</span>';
                    echo '<span class="list-info">Màn hình: '. $dt->Kich_thuoc_man_hinh .' '. $dt->Do_phan_giai_man_hinh .'</span>';
                    echo '<span class="list-info">Chipset: '. $dt->Chipset .'</span>';
                    echo '<span class="list-info">Ram: '. $dt->RAM .'GB</span>';
                    echo '<span class="list-info">Rom: '. $dt->ROM .'GB</span>';
                    echo '<span class="list-info">Khe sim: '. $dt->Khe_sim .'</span>';
                    echo '<span class="list-info">Pin: '. $dt->Pin .'mah</span>';
                    echo '<span class="list-info">OS: '. $dt->OS .' '. $dt->Phien_ban_OS .'</span>';
                echo '</div>';
            echo '</div>';
        }
    }

    function getTimKiemTuKhoaDienThoai($noiDung)
    {
        return redirect('TrangChu')->with('noiDungCanTimKiem', $noiDung);
    }
    
    function getChonHangDienThoai($id_hangDT)
    {
        return redirect('TrangChu')->with('hangDienThoaiDuocChon', $id_hangDT);
    }

    // Nhấn nút Xem Thêm: Giảm giá mạnh
    function getXemThemGiamGiaManhAjax($soLuongSeHienThi)
    {
        //Danh sách điện thoại giảm giá mạnh -------------------------------------------------
        $dsMaDT = array();
        $dsSoLuongKM = array();
        $count = 0;

            //Lấy ngày hôm nay
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $today = date('Y-m-d');

        $dienThoai = DienThoaiDiDong::where([
                ['Dang_ban', '=', 1],
                ['So_luong', '>', 0]
            ])->get();

        // Tạo danh sách mã điện thoại và danh sách chứa phần trăm khuyến mãi
        foreach ($dienThoai as $dt) {
            $hasKM = false;
            $km = $dt->ToKhuyenMai->last();
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

        // Sắp xếp lại 2 danh sách này dựa vào phần trăm khuyến mãi
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
            
        $dsMaGiamGia = array();
        for ($i=0; $i < $soLuongSeHienThi; $i++) { 
            $dsMaGiamGia[$i] = $dsMaDT[$i];
        }

        //Hiển thị ra
        $price = new Price();
        foreach($dsMaGiamGia as $maDT)
        {
            $dt = DienThoaiDiDong::find($maDT);

            echo '<div class="col-2s " onclick="GoToPhone('. $dt->Ma_dien_thoai .')">';
                echo '<div class="mobile-phone">
                        <img src="DiDongZin/imagePhone/'. $dt->Hinh_anh .'" style="height: 215px" alt="'. $dt->Ten_dien_thoai .'">
                        <h2 class="name">'. $dt->Ten_dien_thoai .'</h2>';
                        echo '<div class="giaca">';
                            $phanTramKM = $dt->ToKhuyenMai->last()->Phan_tram_khuyen_mai;   
                            $gia = $dt->ToGiaBan->last()->Gia; 
                            echo '<span class="price">'. $price->ShowPrice($gia * (1-($phanTramKM/100))) .' VND</span>
                                  <span class="price-old">'. $price->ShowPrice($gia) .' VND</span>';
                        echo '</div>';
                        
                        echo '<span class="sale-giam-gia">Giảm '. $phanTramKM .'%</span>';
                echo '</div>';

                echo '<div class="hidden-info">';
                    echo '<h2 class="name">'. $dt->Ten_dien_thoai .'</h2>
                        <span class="price">'. $price->ShowPrice($dt->ToGiaBan->last()->Gia) .' VND</span>
                        <span class="list-info">Màn hình: '. $dt->Kich_thuoc_man_hinh .' '. $dt->Do_phan_giai_man_hinh .'</span>
                        <span class="list-info">Chipset: '. $dt->Chipset .'</span>
                        <span class="list-info">Ram: '. $dt->RAM .'GB</span>
                        <span class="list-info">Rom: '. $dt->ROM .'GB</span>
                        <span class="list-info">Khe sim: '. $dt->Khe_sim .'</span>
                        <span class="list-info">Pin: '. $dt->Pin .'mah</span>
                        <span class="list-info">OS: '. $dt->OS .' '. $dt->Phien_ban_OS .'</span>';
                echo '</div>';
            echo '</div>';
        }
    }

    // Nhấn nút Xem Thêm: Bán chạy
    function getXemThemBanChayAjax($soLuongSeHienThi)
    {
        //Danh sách điện thoại bán chạy --------------------------------------------------
        $dsMaDT = array();
        $dsSoLuongBan = array();
        $count = 0;

        $dienThoai = DienThoaiDiDong::where([
                ['Dang_ban', '=', 1],
                ['So_luong', '>', 0]
            ])->get();

        // Tạo danh sách chứa mã điện thoại và số lượng bán được của điện thoại đó
        foreach ($dienThoai as $dt) {
            $dsMaDT[$count] = $dt->Ma_dien_thoai;
            $dsSoLuongBan[$count] = $dt->ToChiTietGioHang->count();
            $count++;
        }

        // Sắp xếp lại theo thứ tự giảm dần
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
            
        $dsMaBanChay = array();
        for ($i=0; $i < $soLuongSeHienThi; $i++) { 
            $dsMaBanChay[$i] = $dsMaDT[$i];
        }

        //Hiển thị ra
        $price = new Price();
        foreach($dsMaBanChay as $maDT)
        {
            $dt = DienThoaiDiDong::find($maDT);
            
            echo '<div class="col-2s" onclick="GoToPhone('. $dt->Ma_dien_thoai .')">';
                echo '<div class="mobile-phone">
                        <img src="DiDongZin/imagePhone/'. $dt->Hinh_anh .'" style="height: 215px" alt="'. $dt->Ten_dien_thoai .'">
                        <h2 class="name">'. $dt->Ten_dien_thoai .'</h2>
                        <span class="price">'. $price->ShowPrice($dt->ToGiaBan->last()->Gia) .' VND</span>';
                echo '</div>';
                echo '<div class="hidden-info">
                        <h2 class="name">'. $dt->Ten_dien_thoai .'</h2>
                        <span class="price">'. $price->ShowPrice($dt->ToGiaBan->last()->Gia) .' VND</span>
                        <span class="list-info">Màn hình: '. $dt->Kich_thuoc_man_hinh .' '. $dt->Do_phan_giai_man_hinh .'</span>
                        <span class="list-info">Chipset: '. $dt->Chipset .'</span>
                        <span class="list-info">Ram: '. $dt->RAM .'GB</span>
                        <span class="list-info">Rom: '. $dt->ROM .'GB</span>
                        <span class="list-info">Khe sim: '. $dt->Khe_sim .'</span>
                        <span class="list-info">Pin: '. $dt->Pin .'mah</span>
                        <span class="list-info">OS: '. $dt->OS .' '. $dt->Phien_ban_OS .'</span>';
                echo '</div>';
            echo '</div>';
        }
    }

    // Nhấn nút Xem Thêm: Tất cả sản phẩm
    function getXemThemTatCaAjax($soLuongSeHienThi)
    {
        //Danh sách điện thoại ---------------------------------------------------------
        $dsDienThoai = DienThoaiDiDong::where([
                ['Dang_ban', '=', 1],
                ['So_luong', '>', 0]
            ])->orderBy('Ma_dien_thoai', 'desc')->take($soLuongSeHienThi)->get(); 
        
        //Hiển thị ra
        $price = new Price();
        foreach($dsDienThoai as $dt)
        {            
            echo '<div class="col-2s" onclick="GoToPhone('. $dt->Ma_dien_thoai .')">';
                echo '<div class="mobile-phone">
                        <img src="DiDongZin/imagePhone/'. $dt->Hinh_anh .'" style="height: 215px" alt="'. $dt->Ten_dien_thoai .'">
                        <h2 class="name">'. $dt->Ten_dien_thoai .'</h2>
                        <span class="price">'. $price->ShowPrice($dt->ToGiaBan->last()->Gia) .' VND</span>';
                echo '</div>';
                echo '<div class="hidden-info">
                        <h2 class="name">'. $dt->Ten_dien_thoai .'</h2>
                        <span class="price">'. $price->ShowPrice($dt->ToGiaBan->last()->Gia) .' VND</span>
                        <span class="list-info">Màn hình: '. $dt->Kich_thuoc_man_hinh .' '. $dt->Do_phan_giai_man_hinh .'</span>
                        <span class="list-info">Chipset: '. $dt->Chipset .'</span>
                        <span class="list-info">Ram: '. $dt->RAM .'GB</span>
                        <span class="list-info">Rom: '. $dt->ROM .'GB</span>
                        <span class="list-info">Khe sim: '. $dt->Khe_sim .'</span>
                        <span class="list-info">Pin: '. $dt->Pin .'mah</span>
                        <span class="list-info">OS: '. $dt->OS .' '. $dt->Phien_ban_OS .'</span>';
                echo '</div>';
            echo '</div>';
        }        
    }

    function postDangNhap(Request $request)
    {
        $this->validate($request, 
            [
                'username'=>'required',
                'password'=>'required'
            ], 
            [
                'username.required'=>'Tên đăng nhập không được rỗng',
                'password.required'=>'Mật khẩu không được rỗng'
            ]);

        $uid = $request->username;
        $pass = $request->password;

        if(Auth::attempt(['Username'=>$uid, 'password'=>$pass]))
        {
            // NẾU LÀ ADMIN ĐĂNG NHẬP THÌ ĐƯA QUA TRANG QUẢN LÝ CỦA ADMIN
            if(Auth::user()->Tai_khoan_admin == 1)
            {
                return redirect('admin/dienthoai/danhsach');
            }    

            // ĐƯA CÁC ĐIỆN THOẠI VÀO GIỎ HÀNG
            //Nếu biến count đã tồn tại rồi (đã chọn thêm vào giỏ hàng trước khi đăng nhập)
            if( session()->has('count') )
            {
                // KIỂM TRA CÓ TỒN TẠI GIỎ HÀNG KHÔNG
                $hasGioHang = false;
                $maTK = Auth::user()->Ma_tai_khoan;
                $gioHang = TaiKhoan::find($maTK)->ToGioHang->last();
                if($gioHang !== null)
                {
                    if($gioHang->Da_thanh_toan == 0)
                    {
                        $hasGioHang = true;
                    }
                }
                //Nếu chưa tồn tại giỏ hàng, thì tạo giỏ hàng mới
                if( !$hasGioHang )
                {
                    $gioHang = new GioHang;
                    $gioHang->Ma_gio_hang = GioHang::all()->max('Ma_gio_hang') + 1;
                    $gioHang->Da_thanh_toan = 0;
                    $gioHang->Ma_tai_khoan = $maTK;

                    $gioHang->save();
                }

                //Lấy giỏ hàng ra dùng
                $gioHang = TaiKhoan::find($maTK)->ToGioHang->last();

                $count = session()->get('count');
                // Gọi những điện thoại trước đó ra để thêm vào giỏ hàng
                for ($i=0; $i < $count; $i++) { 
                    $maDT = session()->get('dt'.$i);
                    $soLuongDT = session()->get('sl'.$i);

                    //Kiểm tra chiTiet này đã có trong giỏ hàng chưa, nếu có rồi thì bỏ qua
                    $countChiTiet = ChiTietGioHang::where([
                                    ['Ma_dien_thoai', '=', $maDT],
                                    ['Ma_gio_hang', '=', $gioHang->Ma_gio_hang]
                                ])->count();
                    if($countChiTiet == 0)
                    {
                        //Lưu chi tiết giỏ hàng mới (của những điện thoại đã thêm vào khi chưa đăng nhập)
                        $chiTiet = new ChiTietGioHang;
                        $chiTiet->Ma_dien_thoai = $maDT;
                        $chiTiet->Ma_gio_hang = $gioHang->Ma_gio_hang;
                        $chiTiet->Ma_gia_ban = DienThoaiDiDong::find($maDT)->ToGiaBan->last()->Ma_gia_ban;
                        $chiTiet->So_luong = $soLuongDT;

                        $chiTiet->save();
                    }                                            
                }
                // Sau khi đã xử lý những session lưu mã điện thoại xong, ta xóa những session này
                for ($i=0; $i < $count; $i++) { 
                    session()->forget('dt'.$i);
                    session()->forget('sl'.$i);
                }
                session()->forget('count');
            }          
            return redirect('TrangChu');
        }
        else
        {
            return redirect('TrangChu')->with('thongBaoDangNhap', 'Đăng nhập thất bại');
        }
    }

    function postDangKy(Request $request)
    {
        if(is_numeric($request->hoVaTenLot))
        {
            return redirect('TrangChu')->with('loiDangKy', 'Họ và tên lót không được là số');
        }

        if(is_numeric($request->ten))
        {
            return redirect('TrangChu')->with('loiDangKy', 'Tên không được là số');
        }

        $this->validate($request, 
            [
                'hoVaTenLot'=>'required|max:50',
                'ten'=>'required|max:20',
                'email'=>'required|email',
                'username2'=>'required|unique:Tai_khoan,Username',
                'password2'=>'required',
                're_password2'=>'same:password2'
            ], 
            [
                'hoVaTenLot.required'=>'Họ và tên lót bắt buộc phải nhập',
                'hoVaTenLot.max'=>'Họ và tên lót tối đa 50 ký tự',
                'ten.required'=>'Tên bắt buộc phải nhập',
                'ten.max'=>'Tên tối đa 50 ký tự',
                'email.required'=>'Email bắt buộc phải nhập',
                'email.email'=>'Địa chỉ email không hợp lệ',
                'username2.required'=>'Tên đăng nhập bắt buộc phải nhập',
                'username2.unique'=>'Tên đăng nhập đã bị trùng',
                'password2.required'=>'Mật khẩu bắt buộc phải nhập',
                're_password2.same'=>'Mật khẩu nhập lại không chính xác'
            ]);        

        $user = new TaiKhoan;
        $user->Ma_tai_khoan = TaiKhoan::all()->max('Ma_tai_khoan') + 1;
        $user->Username = $request->username2;
        $user->password = bcrypt($request->password2);
        $user->Ho_va_ten_lot = $request->hoVaTenLot;
        $user->Ten = $request->ten;
        $user->Email = $request->email;
        $user->URL_Avatar = 'male_user_100px.png';
        $user->Tai_khoan_admin = 0;
        
        $user->save();
        return redirect('TrangChu')->with('thongBaoDangKy', 'Bạn đã đăng ký thành công tài khoản, bạn có thể đăng nhập vào hệ thống');
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

        // ĐỔI MẬT KHẨU
    function postKiemTraDieuKienDoiMatKhau(Request $request)
    {
        //$user = TaiKhoan::find(2);
        $user = TaiKhoan::where([
                ['Username', '=', $request->username],
                ['Email', '=', $request->email],
            ])->get();
        $isUser = false;

        // Tìm thấy user
        if(count($user) == 1)
        {
            $isUser = true;
        }

        if( $isUser )
        {
            // Tạo mật khẩu mới
            $newPass = Str::random(10);
            
            // Lưu mật khẩu
            $account = TaiKhoan::find($user[0]['Ma_tai_khoan']);
            $account->password = bcrypt($newPass);
            $account->save();

            // Gửi Mail
            $hoTen = $user[0]['Ho_va_ten_lot'].' '.$user[0]['Ten'];
            $valArr = ['hoTen'=>$hoTen, 'matKhau'=>$newPass];
            Mail::to($account->Email)->send(new MailDoiMatKhau($valArr));

            return redirect('TrangChu')->with('DoiMatKhauThanhCong', 'DiDongZin đã gửi mật khẩu mới về email của bạn. Bây giờ bạn có thể sử dụng mật khẩu đó để đăng nhập vào hệ thống');
        }
        else
        {
            return redirect('TrangChu')->with('DoiMatKhauThatBai', 'Tên đăng nhập hoặc email không đúng');
        }
    }

    // ===========================================================================================
    // ---------------- CÁC TRANG QUẢN LÝ TÀI KHOẢN ----------------------------------------------
    // ===========================================================================================
        // THÔNG TIN CÁ NHÂN
    function getThongTinCaNhan()
    {
        return view('user.account.ThongTin', ['fileCSS'=>'taiKhoan']);
    }

    function postCapNhatThongTin(Request $request)
    {
        $this->validate($request, 
            [
                'fullname'=>'required',
                'avatar'=>'image|mimes:png,jpg,jpeg'
            ], 
            [
                'fullname.required'=>'Họ và tên không được trống',
                'avatar.image'=>'Ảnh đại diện phải là hình ảnh',
                'avatar.mimes'=>'Ảnh đại diện thuộc 1 trong các định dạng png, jpg, jpeg'
            ]);
        $hoTen = $request->fullname;
        $viTri = strrpos($hoTen, ' ');
        $ten = '';
        $hoVaTenLot = '';
            // Họ tên phải bao gồm họ tên lót và tên
        if($viTri != '')
        {
            $ten = substr($hoTen, $viTri + 1, strlen($hoTen));
            $hoVaTenLot = substr($hoTen, 0, $viTri);
        }
        else
        {
            return redirect('taikhoan/ThongTinCaNhan')->with('thongBaoCapNhat', 'Họ tên phải bao gồm họ tên lót và tên');
        }

        // Kiểm tra ngày sinh không được lớn hơn ngày hiện tại
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $today = date("Y-m-d");
        if($request->dateOfBirth > $today)
        {
            return redirect('taikhoan/ThongTinCaNhan')->with('thongBaoCapNhat', 'Ngày sinh không hợp lệ');
        }
        
        $id = Auth::user()->Ma_tai_khoan;
        $user = TaiKhoan::find($id);

        // Gán tên mới và di chuyển file ảnh đại diện
        if($request->avatar != "")
        {
            $file = $request->file('avatar');
            $tenHinh = $file->getClientOriginalName();
            $tenHinh = Str::random(4) .'_'. $tenHinh;
            while( file_exists('DiDongZin/avatar/'.$tenHinh))
            {
                $tenHinh = Str::random(4) .'_'. $tenHinh;
            }
            $file->move('DiDongZin/avatar', $tenHinh);

            // Xóa ảnh cũ trong hệ thống trước khi cập nhật ảnh mới
                // unlink($filename): dùng để xóa file trong hệ thống, $filename: đường dẫn tới file 
                // Nếu người dùng đã có avatar thì khi đổi ảnh thì xóa avatar cũ
                // male_user_100px.png là avatar mặc định nên không xóa
            if($user->URL_Avatar !== 'male_user_100px.png')
            {
                unlink('DiDongZin/avatar/'.$user->URL_Avatar);
            }
                //Cập nhật lại ảnh
            $user->URL_Avatar = $tenHinh;
        }
        
        $user->Ho_va_ten_lot = $hoVaTenLot;
        $user->Ten = $ten;
        $user->Ngay_sinh = $request->dateOfBirth;
        $user->Gioi_tinh = $request->sex;
        $user->Dia_chi = $request->address;
            // Cắt hết các khoảng trắng trong số điện thoại
        $user->So_dien_thoai = str_replace(' ', '', $request->phonenumber);

        $user->save();
        return redirect('taikhoan/ThongTinCaNhan')->with('thongBaoCapNhat', 'Cập nhật thông tin thành công');
    }
        // THÔNG TIN ĐĂNG NHẬP
    function getCapNhatTaiKhoan()
    {
        return view('user.account.ThongTinDangNhap', ['fileCSS'=>'taiKhoan']);
    }

    function postCapNhatThongTinDangNhap(Request $request)
    {
        $this->validate($request, 
            [
                'email'=>'required|email',
            ], 
            [
                'email.required'=>'Email không được trống',
                'email.email'=>'Địa chỉ email không hợp lệ',
            ]);
        
        $hasChanged = false;
        // Cập nhật email nếu email có sự thay đổi
        if($request->email != Auth::user()->Email)
        {
            $ma = Auth::user()->Ma_tai_khoan;
            $user = TaiKhoan::find($ma);
            $user->Email = $request->email;

            $user->save();
            $hasChanged = true;
        }    

        // Nếu password khác rỗng là có hành động thay đổi mật khẩu
        if($request->password != '')
        {
            if(Auth::attempt(['Username'=>$request->username, 'password'=>$request->password]))
            {
                $this->validate($request, 
                    [
                        'newPassword'=>'required',
                        'reNewPassword'=>'same:newPassword'
                    ], 
                    [
                        'newPassword.required'=>'Mật khẩu mới không được trống',
                        'reNewPassword.same'=>'Nhập lại mật khẩu mới không chính xác'
                    ]);

                $ma = Auth::user()->Ma_tai_khoan;
                $user = TaiKhoan::find($ma);
                $user->password = bcrypt($request->newPassword);

                $user->save();
                $hasChanged = true;
            }
            else
            {
                return redirect('taikhoan/CapNhatTaiKhoan')->with('thongBaoCapNhat', 'Mật khẩu hiện tại không đúng');
            }
        }

        if( $hasChanged )
        {            
            return redirect('taikhoan/CapNhatTaiKhoan')->with('thongBaoCapNhat', 'Cập nhật thông tin đăng nhập thành công');
        }
        else
        {            
            return redirect('taikhoan/CapNhatTaiKhoan');
        }
    }

        // THÔNG TIN ĐƠN HÀNG
    function getDonHang()
    {
        $user = TaiKhoan::find( Auth::user()->Ma_tai_khoan );
        $dsGioHang = $user->ToGioHang;
        $dsMaDaHoanThanh = array();
        $dsMaChuaHoanThanh = array();
        
        foreach ($dsGioHang as $gioHang) {
            if($gioHang->Da_thanh_toan == 1)
            {
                $hoaDon = $gioHang->ToHoaDon;
                if($hoaDon->Trang_thai == 1)
                {
                    $count = count($dsMaDaHoanThanh);
                    $dsMaDaHoanThanh[$count] = $hoaDon->Ma_hoa_don;
                }
                else if($hoaDon->Trang_thai == 0)
                {
                    $count = count($dsMaChuaHoanThanh);
                    $dsMaChuaHoanThanh[$count] = $hoaDon->Ma_hoa_don;
                }
            }
        }

        return view('user.account.DonHang', ['fileCSS'=>'taiKhoan_donHang', 'dsMaDaHoanThanh'=>$dsMaDaHoanThanh, 'dsMaChuaHoanThanh'=>$dsMaChuaHoanThanh]);
    }

    function getHuyDonHang($id)
    {
        $hoaDon = HoaDon::find($id);
        $gioHang = $hoaDon->ToGioHang;

        // Tăng số lượng điện thoại trong lên do hủy đơn hàng
        $dsChiTiet = $gioHang->ToChiTietGioHang;
        foreach ($dsChiTiet as $chiTiet) {
            $dt = $chiTiet->ToDienThoaiDiDong;
            $dt->So_luong = $dt->So_luong + $chiTiet->So_luong;
            $dt->save();
        } 

        // Xóa chi tiết giỏ hàng có liên quan
        DB::table('Chi_tiet_gio_hang')->where('Ma_gio_hang', '=', $gioHang->Ma_gio_hang)->delete();

        // Xóa hóa đơn, và giỏ hàng
        $hoaDon->delete();
        $gioHang->delete();
        
        return redirect('taikhoan/DonHang')->with('thongBaoHuy', 'Bạn đã hủy đơn hàng thành công');
    }

    function getChiTietDonHang($id)
    {
        $hoaDon = HoaDon::find($id);
        return view('user.account.ChiTietDonHang', ['fileCSS'=>'taiKhoan_donHang', 'hoaDon'=>$hoaDon]);
    }

    function getInHoaDon($maHD)
    {
        $hoaDon = HoaDon::find($maHD);
        return view('user.account.InHoaDon', ['hoaDon'=>$hoaDon]);
    }

        // CÀI ĐẶT
    function getCaiDat()
    {
        return view('user.account.CaiDat', ['fileCSS'=>'taiKhoan']);
    }


    // ===========================================================================================
    // ---------------- HIỂN THỊ CHI TIẾT ĐIỆN THOẠI ---------------------------------------------
    // ===========================================================================================
    function ShowPhone($id)
    {
        $dienThoai = DienThoaiDiDong::find($id);
        $dsBinhLuanCha = BinhLuan::where([
                ['Ma_dien_thoai', '=', $dienThoai->Ma_dien_thoai],
                ['Ma_binh_luan_cha', '=', null]
            ])->orderBy('Ma_binh_luan', 'DESC')->paginate(4);

        $dsBinhLuanCon = BinhLuan::where([
                ['Ma_dien_thoai', '=', $dienThoai->Ma_dien_thoai],
                ['Ma_binh_luan_cha', '<>', null]
            ])->get();

        return view('user.DienThoai', ['fileCSS'=>'dienThoai', 'dienThoai'=>$dienThoai, 'dsBinhLuanCha'=>$dsBinhLuanCha, 'dsBinhLuanCon'=>$dsBinhLuanCon]);
    }

    // THAO TÁC VỚI BÌNH LUẬN
    function getThemBinhLuan($maBinhLuanCha, $noiDung, $maDienThoai)
    {
        // Lấy ngày giờ hiện tại
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $now = date('Y-m-d H:i:s');

        // Lấy Mã tài khoản đang đăng nhập
        $maTaiKhoan = Auth::user()->Ma_tai_khoan;

        $bl = new BinhLuan;
        $bl->Ma_binh_luan = BinhLuan::all()->max('Ma_binh_luan') + 1;
        if($maBinhLuanCha == '0')
        {
            $bl->Ma_binh_luan_cha = null;
        }
        else
        {
            $bl->Ma_binh_luan_cha = $maBinhLuanCha;
        }        
        $bl->Noi_dung = $noiDung;
        $bl->Thoi_gian_binh_luan = $now;
        $bl->Ma_tai_khoan = $maTaiKhoan;
        $bl->Ma_dien_thoai = $maDienThoai;

        $bl->save();
    }

    function getCapNhatBinhLuan($loai, $maBinhLuan, $noiDung)
    {
        if($loai == 'sua')
        {
            // Lấy ngày giờ hiện tại
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $now = date('Y-m-d H:i:s');

            $bl = BinhLuan::find($maBinhLuan);
            $bl->Noi_dung = $noiDung;
            $bl->Thoi_gian_binh_luan = $now;

            $bl->save();
        }
        else if($loai == 'xoa')
        {
            // Khi xóa có 2 trường hợp: 
            $bl = BinhLuan::find($maBinhLuan);

            if($bl->Ma_binh_luan_cha == null)
            {
                // Nếu là bình luận cha: xóa binh luận cha và các bình luận con (nếu có)
                DB::table('Binh_luan')->where('Ma_binh_luan_cha', '=', $maBinhLuan)->delete();

                $bl->delete();
            }
            else
            {
                // Nếu là bình luận con: chỉ cần xóa bình luận đó
                $bl->delete();
            }
            
        }
    }


    // ===========================================================================================
    // ---------------- THANH TOÁN GIỎ HÀNG ------------------------------------------------------
    // ===========================================================================================
    function getThanhToanGioHang()
    {
        $dsMaDienThoai = array();
        $dsSoLuongTheoMa = array();
        $hasGioHang = false;
        if(Auth::check())
            // KHI ĐÃ ĐĂNG NHẬP
        {
            $maTK = Auth::user()->Ma_tai_khoan;
            $gioHang = TaiKhoan::find($maTK)->ToGioHang->last();
            if($gioHang !== null)
            {
                if($gioHang->Da_thanh_toan == 0)
                {
                    $hasGioHang = true;
                }
            }

            if( $hasGioHang )
            {
                $dsChiTietGioHang = $gioHang->ToChiTietGioHang;
                $count = 0;
                foreach ($dsChiTietGioHang as $chiTiet) {
                    $count = count($dsMaDienThoai);
                    $dsMaDienThoai[$count] = $chiTiet->Ma_dien_thoai;
                    $dsSoLuongTheoMa[$count] = $chiTiet->So_luong;
                }
            }
        }
        else
            // KHI CHƯA ĐĂNG NHẬP
        {
            //Nếu biến count đã được tạo
            if( session()->has('count') )
            {
                $soLuongDT = session()->get('count');

                // Đưa các điện thoại trong giỏ hàng vào dsMaDienThoai để hiện ra màn hình
                for ($i=0; $i < $soLuongDT; $i++) { 
                    $maDT = session()->get('dt'.$i);
                    $soLuong = session()->get('sl'.$i);

                    $count = count($dsMaDienThoai);
                    $dsMaDienThoai[$count] = $maDT;
                    $dsSoLuongTheoMa[$count] = $soLuong;
                }
            }            
        }
        return view('user.DatHang', ['fileCSS'=>'datHang', 'dsMaDienThoai'=>$dsMaDienThoai, 'dsSoLuongTheoMa'=>$dsSoLuongTheoMa]);
    }

    function getThemVaoGioHang($ma)
    {
            // ĐÃ ĐĂNG NHẬP
        if(Auth::check())
        {
            //KIỂM TRA CÓ TỒN TẠI GIỎ HÀNG KHÔNG
            $hasGioHang = false;
            $maTK = Auth::user()->Ma_tai_khoan;
            $gioHang = TaiKhoan::find($maTK)->ToGioHang->last();
            if($gioHang !== null)
            {
                if($gioHang->Da_thanh_toan == 0)
                {
                    $hasGioHang = true;
                }
            }

            // Tạo giỏ hàng mới chưa có
            if( !$hasGioHang )
            {
                $gioHang = new GioHang;
                $gioHang->Ma_gio_hang = GioHang::all()->max('Ma_gio_hang') + 1;
                $gioHang->Da_thanh_toan = 0;
                $gioHang->Ma_tai_khoan = $maTK;

                $gioHang->save();
            }

            //Lấy giỏ hàng ra dùng
            $gioHang = TaiKhoan::find($maTK)->ToGioHang->last();

            //Lấy điện thoại có mã vừa chọn ra
            $countChiTiet = ChiTietGioHang::where([
                ['Ma_dien_thoai', '=', $ma],
                ['Ma_gio_hang', '=', $gioHang->Ma_gio_hang]
            ])->count();

            //Kiểm tra điện thoại đã tồn tại trong giỏ hàng chưa
            if($countChiTiet == 0)
            {
                //Chưa tồn tại, lưu điện thoại vừa chọn vào giỏ hàng 
                $chiTiet = new ChiTietGioHang;
                $chiTiet->Ma_dien_thoai = $ma;
                $chiTiet->Ma_gio_hang = $gioHang->Ma_gio_hang;
                $chiTiet->Ma_gia_ban = DienThoaiDiDong::find($ma)->ToGiaBan->last()->Ma_gia_ban;
                $chiTiet->So_luong = 1;

                $chiTiet->save();
            }
            // Đã tồn tại, thì tăng số lượng thêm 1
            else
            {
                $chiTiet = ChiTietGioHang::where([
                    ['Ma_dien_thoai', '=', $ma],
                    ['Ma_gio_hang', '=', $gioHang->Ma_gio_hang]
                ])->get();
                
                $soLuong = $chiTiet[0]['So_luong'];
                $soLuong++;
                echo $soLuong;
                DB::table('Chi_tiet_gio_hang')->where([
                    ['Ma_dien_thoai', '=', $ma],
                    ['Ma_gio_hang', '=', $gioHang->Ma_gio_hang]
                ])->update(['So_luong' => $soLuong]);
            }        
        }
        else
            // CHƯA ĐĂNG NHẬP
        {
            //Nếu biến count chưa được tạo
            if( !session()->has('count') )
            {
                session()->put('count', 0);
            }

            $count = session()->get('count');
            
            // Kiểm tra trong giỏ hàng đã có điện thoại này chưa
            $found = false;
            for ($i=0; $i < $count; $i++) { 
                $maDT = session()->get('dt'.$i);
                if($maDT == $ma)
                {
                    // Tăng số lượng điện thoại thêm 1 nếu tìm thấy
                    $soLuong = session('sl'.$i);
                    $soLuong++;
                    session()->put('sl'.$i, $soLuong);

                    $found = true;
                    break;
                }
            }

            // Nếu chưa có thì thêm vào
            if( !$found )
            {
                //Tạo session lưu mã, số lượng của điện thoại vừa được chọn
                session()->put('dt'.$count, $ma);
                session()->put('sl'.$count, 1);
                $count++;
                session()->put('count', $count);
            }            
        }
        return redirect('DienThoai/'. $ma .'.html');
    }

    function postTaoDonHang(Request $request)
    {
        //Thiết lập giờ tại khu vục
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        
        $this->validate($request, 
            [
                'tenKhachHang'=>'required',
                'soDT'=>'required',
                'diaChi'=>'required'
            ], 
            [
                'tenKhachHang.required'=>'Tên khách hàng không được trống',
                'soDT.required'=>'Số điện thoại không được trống',
                'diaChi.required'=>'Địa chỉ giao hàng không được trống'
            ]);

        if($request->hinhthuc == 'Thanh toán Online')
        {
            $this->validate($request, 
                [
                    'tenChuThe'=>'required',
                    'soThe'=>'required',
                    'CVV'=>'required|numeric'
                ], 
                [
                    'tenChuThe.required'=>'Tên chủ thẻ không được trống',
                    'soThe.required'=>'Số thẻ không được trống',
                    'CVV.required'=>'CVV/CVV2 không được trống',
                    'CVV.numeric'=>'CVV/CVV2 phải là số'
                ]);

            $daySo = str_replace(" ", "", $request->soThe);
            // Kiểm tra phải là một dãy các con số
            if( !is_numeric($daySo) )
            {
                return redirect('ThanhToanGioHang')->with('thongBaoTaoDonHang', 'Số thẻ phải là dãy số');
            }

            $month = date('m');
            $year  = date('Y');
            if(($request->namHetHan < $year) || ($request->namHetHan == $year && $request->thangHetHan <= $month))
            {
                return redirect('ThanhToanGioHang')->with('thongBaoTaoDonHang', 'Thẻ của bạn phải còn hạn dùng ít nhất một tháng mới có thể thực hiện đặt hàng');
            }
        }
 
        // Kiểm tra có giỏ hàng chưa
        $user = TaiKhoan::find(Auth::user()->Ma_tai_khoan);
        
        // Lấy giỏ hàng cuối cùng
            // Nếu tồn tại giỏ hàng, Da_thanh_toan = 0, số hàng hóa trong giỏ hàng > 0
                // => Có giỏ hàng hợp lệ
        $gioHang = $user->ToGioHang->last();
        $hasBasket = false;
        if($gioHang != null)
        {
            if( ($gioHang->Da_thanh_toan == 0) && (count($gioHang->ToChiTietGioHang) > 0) )
            {
                $hasBasket = true;                
            }
        }

        if( $hasBasket )
        {
            // Lấy ngày giờ hiện tại
            $now = date('Y-m-d H:i:s');

            $hoaDon = new HoaDon;
            $hoaDon->Ma_hoa_don = HoaDon::all()->max('Ma_hoa_don') + 1;
            $hoaDon->Ma_gio_hang = $gioHang->Ma_gio_hang;
            $hoaDon->Ma_tai_khoan = Auth::user()->Ma_tai_khoan;
            $hoaDon->Ngay_tao = $now;
            $hoaDon->Hinh_thuc_thanh_toan = $request->hinhthuc;
            $hoaDon->Dia_chi_nhan_hang = $request->diaChi;
            $hoaDon->Thue_VAT = 10;
                // Nếu là thanh toán online thì đơn hàng sẽ trở thành hóa đơn luôn, do Thành viên đã trả tiền
            if($request->hinhthuc == 'Thanh toán Online')
            {
                $hoaDon->Trang_thai = 1;
            }
            else
            {
                $hoaDon->Trang_thai = 0;
            }            
            $hoaDon->save();

            // Sửa Da_thanh_toan = 1 trong giỏ hàng
            $gioHang->Da_thanh_toan = 1;
            $gioHang->save();

            // Lưu địa chỉ và số điện thoại của người dùng, nếu trong thông tin cá nhân còn trống
            if($user->Dia_chi == '' || $user->So_dien_thoai == '')
            {
                $user->Dia_chi = $request->diaChi;
                $user->So_dien_thoai = $request->soDT;
                $user->save();
            }

            //Cập nhật lại số lượng điện thoại trong kho
            // $dsChiTiet = $gioHang->ToChiTietGioHang;
            // foreach ($dsChiTiet as $chiTiet) {
            //     $dt = $chiTiet->ToDienThoaiDiDong;
            //     $dt->So_luong = $dt->So_luong - $chiTiet->So_luong;
            //     $dt->save();
            // }

            return redirect('ThanhToanGioHang')->with('thongBaoTaoDonHang', 'Bạn đã tạo đơn hàng thành công');
        }
        else
        {
            return redirect('ThanhToanGioHang')->with('thongBaoTaoDonHang', 'Trong giỏ hàng của bạn không có điện thoại nào nên không thể tạo đơn hàng');
        }
    }

    // LAY SO LUONG DIEN THOAI TRONG KHO
    function getLaySoLuongKhoAjax($idDT)
    {
        $dt = DienThoaiDiDong::find($idDT);
        echo $dt->So_luong;
    }

    //THỰC HIỆN AJAX VIỆC TĂNG GIẢM SỐ LƯỢNG KHI ĐÃ ĐĂNG NHẬP
    function getTangGiamSoLuongCHECKED_AJAX($loai, $maDT, $maGioHang, $soLuong)
    {
        if($loai == 'sua')
        {
            DB::table('Chi_tiet_gio_hang')->where([
                    ['Ma_dien_thoai', '=', $maDT],
                    ['Ma_gio_hang', '=', $maGioHang]
                ])->update(['So_luong'=>$soLuong]);
        }
        else if($loai == 'xoa')
        {
            DB::table('Chi_tiet_gio_hang')->where([
                ['Ma_dien_thoai', '=', $maDT],
                ['Ma_gio_hang', '=', $maGioHang]
            ])->delete();
        }
    }

    //THỰC HIỆN AJAX VIỆC TĂNG GIẢM SỐ LƯỢNG KHI CHƯA ĐĂNG NHẬP
    function getTangGiamSoLuongUNCHECK_AJAX($loai, $maDT, $soLuong)
    {
        $soLuongDT = session()->get('count');
        $viTri = 0;
        for ($i=0; $i < $soLuongDT; $i++) { 
            $id = session()->get('dt'.$i);
            if($id == $maDT)
            {
                $viTri = $i;
                break;
            }
        }

        if($loai == 'sua')
        {
            //Sửa lại số lượng ngay chính vị trí đó
            session()->put('sl'.$viTri, $soLuong);
        }
        else if($loai == 'xoa')
        {
            //Đi từ vị trí tìm thấy đến vị trí cuối cùng -1
            for ($i=$viTri; $i < $soLuongDT-1; $i++) { 
                //Lấy mã của vị trí phía sau, chồng lên mã của vị trí phía trước
                $ma = session()->get('dt'.($i+1));

                session()->put('dt'.$i, $ma);
            }
            // Xóa session chứa mã và số lượng cuối cùng, và giảm count
            $soLuongDT--;
            session()->forget('dt'.$soLuongDT);
            session()->forget('sl'.$soLuongDT);

            session()->put('count', $soLuongDT);
        }
    }
}
