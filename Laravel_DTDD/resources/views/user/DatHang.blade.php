@extends('user.layout.index')

@section('content')

<?php
    //Hiển thị giá theo 1 định dạng khác
    function ShowPrice($price)
    {
        $price = $price."";
        $strPrice = "";
        while(strlen($price) >= 3)
        {
            $temp = substr($price, strlen($price)-3, strlen($price));
            if($strPrice == "") {
                $strPrice .= $temp;
            }else {
                $strPrice = $temp .'.'. $strPrice;    
            }
            $price = substr($price, 0, strlen($price)-3);
        }
        if(strlen($price) != 0)
        {
            $strPrice = $price .'.'. $strPrice;
        }

        return $strPrice;
    }
?>

<div class="container page-body">
    <div class="row">
        <form action="dathang.php" method="POST">
        <div class="col-12">
            <h2 class="title">Giỏ Hàng</h2>
            <table class="table table-bordered table-customize table-responsive">
                <thead>
                    <tr>
                        <th>Điện thoại</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Tạm tính</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $giaTamTinh = 0;
                    ?>
                    @for($i = 0; $i < count($dsMaDienThoai); $i++)
                        <?php
                            $dt = App\DienThoaiDiDong::find($dsMaDienThoai[$i]);
                            $soLuong = $dsSoLuongTheoMa[$i];
                        ?>
                        <tr id='{{ "rowDT".$dt->Ma_dien_thoai }}'>
                            <td data-title="Điện Thoại">
                                <img src="DiDongZin/imagePhone/{{ $dt->Hinh_anh }}" alt="dtdd">
                                <a href="DienThoai/{{ $dt->Ma_dien_thoai }}.html">{{ $dt->Ten_dien_thoai }}</a>
                            </td>
                            <td data-title="Số Lượng">
                                @if (Auth::check())
                                    <?php
                                        $uid = Auth::user()->Ma_tai_khoan;
                                        $maGioHang = App\TaiKhoan::find($uid)->ToGioHang->last()->Ma_gio_hang;
                                    ?>
                                @endif
                                <span class="tru-dt" 
                                    @if (Auth::check())
                                        onclick="TangGiamSoLuong(true, 'giam', '{{ $dt->Ma_dien_thoai }}', '{{ $maGioHang }}')"       
                                    @else
                                        onclick="TangGiamSoLuong(false, 'giam', '{{ $dt->Ma_dien_thoai }}', 0)"
                                    @endif
                                >-</span>
                                <span class="soluong-dt dsSoLuong" id="{{ 'sl'.$dt->Ma_dien_thoai }}">{{ $soLuong }}</span>
                                <span class="cong-dt" 
                                    @if (Auth::check())
                                        onclick="TangGiamSoLuong(true, 'tang', '{{ $dt->Ma_dien_thoai }}', '{{ $maGioHang }}')"        
                                    @else
                                        onclick="TangGiamSoLuong(false, 'tang', '{{ $dt->Ma_dien_thoai }}', 0)"
                                    @endif
                                >+</span>
                            </td>
                            {{-- Kiểm tra điện thoại có khuyến mãi không? ------}}
                            <?php
                                //Lấy khuyến mãi cuối cùng
                                $km = $dt->ToKhuyenMai->last();
                                $hasKM = false;
                                $phanTramKM;
                                $gia;
                                if($km !== null)
                                {
                                    //Lấy ngày hiện tại
                                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                                    $today = date('Y-m-d');

                                    if($km->Tu_ngay<=$today && $today<=$km->Den_ngay)
                                    {
                                        $hasKM = true;
                                        $phanTramKM = $km->Phan_tram_khuyen_mai;
                                    }
                                }
                                if( $hasKM )
                                {
                                    $gia = $dt->ToGiaBan->last()->Gia * (1- ($phanTramKM/100) );
                                }
                                else 
                                {
                                    $gia = $dt->ToGiaBan->last()->Gia;
                                }
                                $giaTamTinh += $gia * $soLuong;                                
                            ?>
                            <td data-title="Giá" id="{{ 'gia'.$dt->Ma_dien_thoai }}">
                                {{ ShowPrice($gia) }} VND
                                <input class="dsGia" type="text" hidden id="{{ 'giaHidden'.$dt->Ma_dien_thoai }}" value="{{ $gia }}">
                            </td>
                            <td data-title="Tạm tính" class="dsTamTinh" id="{{ 'tamTinh'.$dt->Ma_dien_thoai }}">{{ ShowPrice( $gia * $soLuong) }} VND</td>
                        </tr>
                    @endfor

                </tbody>
            </table>
        </div>  
        <div class="col-6 thongtindathang">
                <h2 class="title">Cộng giỏ hàng</h2>
                <table>
                    <tr>
                        <th>Tạm tính:</th>
                        <td id="tongTamTinh">
                            {{ ShowPrice($giaTamTinh) }} VND
                        </td>
                    </tr>
                    <tr>
                        <th>Thuế VAT:</th>
                        <td id="thueVAT">{{ ShowPrice($giaTamTinh * 0.1) }} VND</td>
                    </tr>
                    <tr>
                        <th>Tổng cộng:</th>
                        <td class="tongcong" id="tongCong">{{ ShowPrice($giaTamTinh + $giaTamTinh * 0.1) }} VND</td>
                    </tr>
                </table>            
        </div>
        <div class="col-6 thongtindathang thongtinthanhtoan">
            <h2 class="title">Thông tin thanh toán</h2>
            <table>
                <tr>
                    <th>Họ tên*</th>
                    <td>
                        <input type="text" placeholder="Điền tên của bạn..." name="tenKhachHang"
                            @if (Auth::check())
                                value="{{ Auth::user()->Ho_va_ten_lot }} {{ Auth::user()->Ten }}"
                            @endif
                        >
                    </td>
                </tr>
                <tr>
                    <th>Số điện thoại*</th>
                    <td>
                        <input type="text" placeholder="097414717..." name="soDT"
                        @if (Auth::check())
                            value="{{ Auth::user()->So_dien_thoai }}"
                        @endif
                        >
                    </td>
                </tr>
                <tr>
                    <th>
                       Địa chỉ giao hàng*
                    </th>
                    <td> 
                        <input type="text" placeholder="Điền địa chỉ..." name="diaChi"
                            @if (Auth::check())
                                value="{{ Auth::user()->Dia_chi }}"
                            @endif
                        >
                    </td>
                </tr>
                <tr>
                    <th>
                        Hình thức thanh toán
                    </th>
                    <td>
                        <select name="hinhthuc">
                            <option>Thanh toán Online</option>
                            <option>Thanh toán khi nhận hàng</option>
                        </select>
                    </td>
                </tr>
                <tr class="hint-thanhtoan">
                    <th>
                        Tên tài khoản ngân hàng
                    </th>
                    <td>
                        <input type="text" placeholder="Điền tên tài khoản ngân hàng..." name="tenChuThe">
                    </td>
                </tr>
                <tr class="hint-thanhtoan">
                    <th>
                        Số thẻ
                    </th>
                    <td>
                        <input type="text" placeholder="000-000-000-000" name="soThe">
                    </td>
                </tr>
                <tr class="hint-thanhtoan">
                    <th>
                        CVV/CVV2
                    </th>
                    <td>
                        <input type="text" placeholder="" name="CVV">
                    </td>
                </tr>
                <tr class="hint-thanhtoan">
                    <th>
                        Ngày hết hạn
                    </th>
                    <td>
                        <select name="thangHetHan">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                            <option>6</option>
                            <option>7</option>
                            <option>8</option>
                            <option>9</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                        </select>
                        <select name="namHetHan">
                            <option>2020</option>
                            <option>2021</option>
                            <option>2022</option>
                            <option>2023</option>
                            <option>2024</option>
                        </select>
                    </td>
                </tr>
                
            </table>
            <input type="submit" value="Đặt Hàng">
        </div>
        </form>
    </div>
</div>

@endsection

@section('script')
    <script src="DiDongZin/assets/js/checkout.js"></script>
    <script>
        function TangGiamSoLuong(checked, loai, idDT, maGioHang)
        {
            //TĂNG GIẢM SỐ LƯỢNG TRÊN GIAO DIỆN
            soLuong = document.getElementById('sl'+idDT).innerHTML;
            if(loai == 'tang')
            {
                document.getElementById('sl'+idDT).innerHTML = soLuong*1 + 1;
                ThayDoiGiaTongCong('tang', idDT);
            }
            else if(loai == 'giam')
            {
                document.getElementById('sl'+idDT).innerHTML = soLuong*1 - 1;   
                ThayDoiGiaTongCong('giam', idDT);
            }
            soLuong = document.getElementById('sl'+idDT).innerHTML;
            
            document.getElementById('soLuongIconGioHang'+idDT).innerHTML = 'X '+soLuong;
            if( checked )
                //ĐÃ ĐĂNG NHẬP
            {
                if( soLuong == 0)
                {
                    if(confirm('Bạn sẽ xóa điện thoại này ra khỏi giỏ hàng?'))
                    {
                        $.get('TangGiamSoLuongCHECKED_AJAX/xoa/'+idDT+'/'+maGioHang+'/'+soLuong, function(data){
                            //Cập nhật số lượng điện thoại, không cần sử dụng biến data
                        });
                        //Ẩn đi dòng bị xóa
                        document.getElementById('rowDT'+idDT).hidden = true;
                        
                        // Ẩn đi điện thoại bị xóa trên icon giỏ hảng phía trên góc phải
                        document.getElementById('rowIconGioHang'+idDT).hidden = true;
                        
                        // Giảm tổng số lượng điện thoại trong 2 icon giỏ hàng
                        count = document.getElementById('iconGioHangTren').innerHTML;
                            // Icon xuất hiện ở giao diện rộng (desktop)
                        document.getElementById('iconGioHangTren').innerHTML = count*1 - 1;
                            // Icon xuất hiện ở giao diện hẹp (smart phone)
                        document.getElementById('iconGioHangDuoi').innerHTML = count*1 - 1;
                    }
                }
                else
                {
                    $.get('TangGiamSoLuongCHECKED_AJAX/sua/'+idDT+'/'+maGioHang+'/'+soLuong, function(data){
                        //Cập nhật số lượng điện thoại, không cần sử dụng biến data
                    });
                }                
            }
            else
                //CHƯA ĐĂNG NHẬP
            {
                if( soLuong == 0)
                {
                    if(confirm('Bạn sẽ xóa điện thoại này ra khỏi giỏ hàng?'))
                    {
                        $.get('TangGiamSoLuongUNCHECK_AJAX/xoa/'+idDT+'/'+soLuong, function(data){
                            //Cập nhật số lượng điện thoại, không cần sử dụng biến data
                        });
                        //Ẩn đi dòng bị xóa
                        document.getElementById('rowDT'+idDT).hidden = true;
                        
                        // Ẩn đi điện thoại bị xóa trên icon giỏ hảng phía trên góc phải
                        document.getElementById('rowIconGioHang'+idDT).hidden = true;
                        
                        // Giảm tổng số lượng điện thoại trong 2 icon giỏ hàng
                        count = document.getElementById('iconGioHangTren').innerHTML;
                            // Icon xuất hiện ở giao diện rộng (desktop)
                        document.getElementById('iconGioHangTren').innerHTML = count*1 - 1;
                            // Icon xuất hiện ở giao diện hẹp (smart phone)
                        document.getElementById('iconGioHangDuoi').innerHTML = count*1 - 1;
                    }
                }
                else
                {
                    $.get('TangGiamSoLuongUNCHECK_AJAX/sua/'+idDT+'/'+soLuong, function(data){
                        //Cập nhật số lượng điện thoại, không cần sử dụng biến data
                    });
                }
            }
        }
        
        function ThayDoiGiaTongCong(loai, maDT)
        {
            tong = 0;

            // Lấy danh sách số lượng, giá bán và giá tạm tính ra
                // các phần tử này theo thứ tự mới có thể làm theo cách này được (Do chúng được tạo ra trong vòng foreach)
            dsSoLuong = document.getElementsByClassName('dsSoLuong');
            dsGia = document.getElementsByClassName('dsGia');
            dsTamTinh = document.getElementsByClassName('dsTamTinh');

            // Lấy ra số lượng và giá của từng điện thoại
            for (let i = 0; i < dsSoLuong.length; i++) {
                sl = dsSoLuong[i].innerHTML;
                gia = dsGia[i].value;

                // Hiển thị giá trị giá tạm tính
                dsTamTinh[i].innerHTML = ShowPrice(sl * gia)+' VND';

                // Cộng dồn các giá tạm tính, để tìm tổng cộng giá tạm tính
                tong += sl * gia;
            }

            // Hiển thị giá tổng kết các điện thoại: tổng giá tạm tính, thuế VAT, giá tổng cộng
            document.getElementById('tongTamTinh').innerHTML = ShowPrice(tong)+' VND';
            document.getElementById('thueVAT').innerHTML = ShowPrice(tong * 0.1)+' VND';
            document.getElementById('tongCong').innerHTML = ShowPrice(tong + tong * 0.1)+' VND';
        }

        //Hiển thị giá theo 1 định dạng khác (Phiên bản js ^^)
        function ShowPrice(price)
        {
            if(price != 0)
            {
                // Ép price thành chuỗi
                price = price+'';

                strPrice = "";
                //Nếu chiều dài >= 3 ký tự
                while(price.length >= 3)
                {
                    // Cắt 3 ký tự cuối
                    temp = price.substr(price.length-3, price.length);
                    if(strPrice == "") {
                        strPrice += temp;
                    }else {
                        strPrice = temp +'.'+ strPrice;    
                    }
                    // Cắt lại chuỗi price mới
                    price = price.substr(0, price.length-3);
                }
                // Nếu chuỗi price còn 1 hoặc 2 ký tự
                if(price.length != 0)
                {
                    strPrice = price +'.'+ strPrice;
                }
                return strPrice;
            } 
            else
                // price = 0: Phòng trường hợp không có điện thoại nào trong giỏ hàng 
            {
                return 0;
            }                           
        }
    </script>    
@endsection