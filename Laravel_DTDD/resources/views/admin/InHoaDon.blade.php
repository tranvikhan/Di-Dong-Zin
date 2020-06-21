<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Quản Lý - Đơn Hàng</title>

    <base href="http://localhost:8080/didongzin/Laravel_DTDD/public/">

    <style>
        body{
            height:210mm;
            width:297mm;
            margin-left:auto;
            margin-right:auto;
        }
    </style>

    <meta charset="utf-8">
    <script src="DiDongZin/assets/js/jquery-3.5.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="DiDongZin/assets/img/logo-min.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="DiDongZin/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="DiDongZin/assets/css/manage.css">
    <!--open lib animation...........................................................................-->
    <link rel="stylesheet" type="text/css" href="DiDongZin/assets/css/animate.css">
</head>

<body onload="window.print()">

    <?php
    //Hiển thị giá theo 1 định dạng khác
    function ShowPrice($price)
    {
        if(strlen($price) > 3)
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
        return $price;
    }
?>

<!-- NOI DUNG CHINH ..................................................................................-->
<div style="padding:20px 0px 0px 50px ;margin-bottom: -45px">
    <img src="DiDongZin/assets/img/logo-min.png" alt="" style="height: 100px">
</div>
<div>
    <div id="hoadon" class="tabcontent">
        <div id="hoaDon">
            <div class="hoadon">
                    
                <table class="tb1">
                    <tr>
                        <th>Mã đơn hàng:</th>
                        <td>{{ $hd->Ma_hoa_don }}</td>
                        <th>Ngày tạo:</th>
                        <td>{{ $hd->Ngay_tao }}</td>
                    </tr>
                    <tr>
                        <th>Khách hàng:</th>
                        <td>{{ $hd->ToGioHang->ToTaiKhoan->Ho_va_ten_lot }} {{ $hd->ToGioHang->ToTaiKhoan->Ten }}</td>
                        <th>Mã khách hàng:</th>
                        <td>{{ $hd->ToGioHang->ToTaiKhoan->Ma_tai_khoan }}</td>
                    </tr>
                    <tr>
                        <th>Số điện thoại:</th>
                        <td>{{ $hd->ToGioHang->ToTaiKhoan->So_dien_thoai }}</td>
                        <th>Hình thức thanh toán:</th>
                        <td>{{ $hd->Hinh_thuc_thanh_toan }}</td>
                    </tr>
                    <tr>
                        <th>Địa chỉ nhận hàng:</th>
                        <td colspan="3">{{ $hd->Dia_chi_nhan_hang }}</td>

                    </tr>
                </table>
                <table class="tb2">
                    <tr>
                        <th>
                            STT
                        </th>
                        <th>
                            Điện thoại
                        </th>
                        <th>
                            Số lượng
                        </th>
                        <th>
                            Đơn giá
                        </th>
                        <th>
                            Thành tiền
                        </th>
                    </tr>
                    <?php  
                        $count = 1;
                        $tongCong = 0;
                    ?>
                    @foreach ($hd->ToGioHang->ToChiTietGioHang as $chiTiet)
                        <tr>
                            <td>
                                {{ $count }}
                                <?php
                                    $count++;
                                ?>
                            </td>
                            <td>
                            <img src="DiDongZin/imagePhone/{{ $chiTiet->ToDienThoaiDiDong->Hinh_anh }}" width="50px">
                                <span>{{ $chiTiet->ToDienThoaiDiDong->Ten_dien_thoai }}</span>
                            </td>
                            <td>
                                {{ $chiTiet->So_luong }}
                            </td>
                            <td>
                                {{ ShowPrice($chiTiet->ToGiaBan->Gia) }} VND
                            </td>
                            <td>
                                {{ ShowPrice($chiTiet->So_luong *  $chiTiet->ToGiaBan->Gia) }} VND
                                <?php  
                                    $tongCong +=  $chiTiet->So_luong *  $chiTiet->ToGiaBan->Gia; 
                                ?>
                            </td>
                        </tr>
                    @endforeach
                    
                    <tr>
                        <th colspan="4">
                            Tổng cộng:
                        </th>
                        <td>
                            {{ ShowPrice($tongCong) }} VND
                        </td>
                    </tr>
                    <tr>
                        <th colspan="4">
                            Thuế VAT:
                        </th>
                        <td>
                            {{ ShowPrice(($hd->Thue_VAT / 100) * $tongCong) }} VND
                        </td>
                    </tr>
                    <tr>
                        <th colspan="4">
                            Tổng thanh toán:
                        </th>
                        <td>
                            {{ ShowPrice($tongCong + ($hd->Thue_VAT / 100) * $tongCong) }} VND
                        </td>
                    </tr>
                </table>
                    
                    {{-- <div class="g-btn-xacnhan">
                        <button class="btnThemdienthoai" onclick="InHoaDon({{ $hd->Ma_hoa_don }})"><img src="DiDongZin/assets/img/print_30px.png">In hóa đơn</button>
                    </div> --}}
            </div>
                
                
                {{-- <div class="hoadon">
                    
                    <table class="tb1">
                        <tr>
                            <th>Mã đơn hàng:</th>
                            <td>4</td>
                            <th>Ngày tạo:</th>
                            <td>2020-04-16 00:00:00</td>
                        </tr>
                        <tr>
                            <th>Khách hàng:</th>
                            <td>Nguyễn Minh Thắng</td>
                            <th>Mã khách hàng:</th>
                            <td>3</td>
                        </tr>
                        <tr>
                            <th>Số điện thoại:</th>
                            <td>0214563256</td>
                            <th>Hình thức thanh toán:</th>
                            <td>Thanh toán khi nhận hàng</td>
                        </tr>
                        <tr>
                            <th>Địa chỉ nhận hàng:</th>
                            <td colspan="3">Châu Thành, Hậu Giang</td>

                        </tr>
                    </table>
                    <div class="dropdown-btn">
                        <img src="DiDongZin/assets/img/xemthem.png">
                    </div>
                    <div class="dropdown-cnt">
                        <table class="tb2">
                            <tr>
                                <th>
                                    STT
                                </th>
                                <th>
                                    Điện thoại
                                </th>
                                <th>
                                    Số lượng
                                </th>
                                <th>
                                    Đơn giá
                                </th>
                                <th>
                                    Thành tiền
                                </th>
                            </tr>
                                                                                        <tr>
                                    <td>
                                        1
                                                                            </td>
                                    <td>
                                    <img src="DiDongZin/imagePhone/WAeh_Vsmart-star-3-xanh.png" width="50px">
                                        <span>Vsmart Star 3 Chính Hãng</span>
                                    </td>
                                    <td>
                                        1
                                    </td>
                                    <td>
                                        1.790.000 VND
                                    </td>
                                    <td>
                                        1.790.000 VND
                                                                            </td>
                                </tr>
                                                        
                            <tr>
                                <th colspan="4">
                                    Tổng cộng:
                                </th>
                                <td>
                                    1.790.000 VND
                                </td>
                            </tr>
                            <tr>
                                <th colspan="4">
                                    Thuế VAT:
                                </th>
                                <td>
                                    179.000 VND
                                </td>
                            </tr>
                            <tr>
                                <th colspan="4">
                                    Tổng thanh toán:
                                </th>
                                <td>
                                    1.969.000 VND
                                </td>
                            </tr>
                        </table>
                        
                        <div class="g-btn-xacnhan">
                            <button class="btnThemdienthoai" onclick="InHoaDon(4)"><img src="DiDongZin/assets/img/print_30px.png">In hóa đơn</button>
                        </div>
                    </div>
                </div>
                <div class="hoadon">
                    
                    <table class="tb1">
                        <tr>
                            <th>Mã đơn hàng:</th>
                            <td>3</td>
                            <th>Ngày tạo:</th>
                            <td>2020-03-06 00:00:00</td>
                        </tr>
                        <tr>
                            <th>Khách hàng:</th>
                            <td>Nguyễn Tấn Thịnh</td>
                            <th>Mã khách hàng:</th>
                            <td>1</td>
                        </tr>
                        <tr>
                            <th>Số điện thoại:</th>
                            <td>0214563256</td>
                            <th>Hình thức thanh toán:</th>
                            <td>Thanh toán online</td>
                        </tr>
                        <tr>
                            <th>Địa chỉ nhận hàng:</th>
                            <td colspan="3">Châu Thành, Đồng Tháp</td>

                        </tr>
                    </table>
                    <div class="dropdown-btn">
                        <img src="DiDongZin/assets/img/xemthem.png">
                    </div>
                    <div class="dropdown-cnt">
                        <table class="tb2">
                            <tr>
                                <th>
                                    STT
                                </th>
                                <th>
                                    Điện thoại
                                </th>
                                <th>
                                    Số lượng
                                </th>
                                <th>
                                    Đơn giá
                                </th>
                                <th>
                                    Thành tiền
                                </th>
                            </tr>
                                                                                        <tr>
                                    <td>
                                        1
                                                                            </td>
                                    <td>
                                    <img src="DiDongZin/imagePhone/Y8kW_s10e-den.png" width="50px">
                                        <span>Samsung Galaxy S10e 128Gb Likenew</span>
                                    </td>
                                    <td>
                                        1
                                    </td>
                                    <td>
                                        8.790.000 VND
                                    </td>
                                    <td>
                                        8.790.000 VND
                                                                            </td>
                                </tr>
                                                            <tr>
                                    <td>
                                        2
                                                                            </td>
                                    <td>
                                    <img src="DiDongZin/imagePhone/1Rvz_xsmax-đen.png" width="50px">
                                        <span>iPhone Xs Max 64Gb Mới Chính Hãng 2 Sim</span>
                                    </td>
                                    <td>
                                        1
                                    </td>
                                    <td>
                                        28.690.000 VND
                                    </td>
                                    <td>
                                        28.690.000 VND
                                                                            </td>
                                </tr>
                                                        
                            <tr>
                                <th colspan="4">
                                    Tổng cộng:
                                </th>
                                <td>
                                    37.480.000 VND
                                </td>
                            </tr>
                            <tr>
                                <th colspan="4">
                                    Thuế VAT:
                                </th>
                                <td>
                                    3.748.000 VND
                                </td>
                            </tr>
                            <tr>
                                <th colspan="4">
                                    Tổng thanh toán:
                                </th>
                                <td>
                                    41.228.000 VND
                                </td>
                            </tr>
                        </table>
                        
                        <div class="g-btn-xacnhan">
                            <button class="btnThemdienthoai" onclick="InHoaDon(3)"><img src="DiDongZin/assets/img/print_30px.png">In hóa đơn</button>
                        </div>
                    </div>
                </div>
                <div class="hoadon">
                    
                    <table class="tb1">
                        <tr>
                            <th>Mã đơn hàng:</th>
                            <td>2</td>
                            <th>Ngày tạo:</th>
                            <td>2020-02-26 00:00:00</td>
                        </tr>
                        <tr>
                            <th>Khách hàng:</th>
                            <td>Nguyễn Phương Vy</td>
                            <th>Mã khách hàng:</th>
                            <td>4</td>
                        </tr>
                        <tr>
                            <th>Số điện thoại:</th>
                            <td>0214563256</td>
                            <th>Hình thức thanh toán:</th>
                            <td>Thanh toán khi nhận hàng</td>
                        </tr>
                        <tr>
                            <th>Địa chỉ nhận hàng:</th>
                            <td colspan="3">Châu Thành, Long An</td>

                        </tr>
                    </table>
                    <div class="dropdown-btn">
                        <img src="DiDongZin/assets/img/xemthem.png">
                    </div>
                    <div class="dropdown-cnt">
                        <table class="tb2">
                            <tr>
                                <th>
                                    STT
                                </th>
                                <th>
                                    Điện thoại
                                </th>
                                <th>
                                    Số lượng
                                </th>
                                <th>
                                    Đơn giá
                                </th>
                                <th>
                                    Thành tiền
                                </th>
                            </tr>
                                                                                        <tr>
                                    <td>
                                        1
                                                                            </td>
                                    <td>
                                    <img src="DiDongZin/imagePhone/Bo3o_galaxy-a71.png" width="50px">
                                        <span>Samsung Galaxy A71 128Gb Chính Hãng</span>
                                    </td>
                                    <td>
                                        2
                                    </td>
                                    <td>
                                        7.990.000 VND
                                    </td>
                                    <td>
                                        15.980.000 VND
                                                                            </td>
                                </tr>
                                                        
                            <tr>
                                <th colspan="4">
                                    Tổng cộng:
                                </th>
                                <td>
                                    15.980.000 VND
                                </td>
                            </tr>
                            <tr>
                                <th colspan="4">
                                    Thuế VAT:
                                </th>
                                <td>
                                    1.598.000 VND
                                </td>
                            </tr>
                            <tr>
                                <th colspan="4">
                                    Tổng thanh toán:
                                </th>
                                <td>
                                    17.578.000 VND
                                </td>
                            </tr>
                        </table>
                        
                        <div class="g-btn-xacnhan">
                            <button class="btnThemdienthoai" onclick="InHoaDon(2)"><img src="DiDongZin/assets/img/print_30px.png">In hóa đơn</button>
                        </div>
                    </div>
                </div> --}}
        </div>
        
    </div>
</div>

    <script src="DiDongZin/assets/js/_hoadon.js"></script>
    <script src="DiDongZin/assets/js/manage.js"></script>         
</body>
</html>