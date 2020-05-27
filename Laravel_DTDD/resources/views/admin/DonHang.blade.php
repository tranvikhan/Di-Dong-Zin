@extends('admin.layout.index')

@section('content')

<!-- NOI DUNG CHINH ..................................................................................-->
<div class="content">
    <div id="donhang" class="tabcontent">
        <h2>QUẢN LÝ ĐƠN HÀNG</h2>
        @foreach ($hoaDon as $hd)

            <div class="donhangmoi">
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
                                    {{ $chiTiet->ToGiaBan->Gia }}
                                </td>
                                <td>
                                    {{ $chiTiet->So_luong *  $chiTiet->ToGiaBan->Gia}}
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
                                {{ $tongCong }}
                            </td>
                        </tr>
                        <tr>
                            <th colspan="4">
                                Thuế VAT:
                            </th>
                            <td>
                                {{ ($hd->Thue_VAT / 100) * $tongCong }}
                            </td>
                        </tr>
                        <tr>
                            <th colspan="4">
                                Tổng thanh toán:
                            </th>
                            <td>
                                {{ $tongCong + ($hd->Thue_VAT / 100) * $tongCong }}
                            </td>
                        </tr>
                    </table>
                    <div class="g-btn-xacnhan">
                        <button class="btnThemdienthoai" onclick="HuyBo({{ $hd->Ma_hoa_don }})"><img src="DiDongZin/assets/img/cancel_30px.png">Hủy bỏ</button>
                        <button class="btnThemdienthoai" onclick="XacNhan({{ $hd->Ma_hoa_don }})"><img src="DiDongZin/assets/img/checked_30px.png">Xác nhận</button>
                    </div>
                </div>
            </div>
        @endforeach

        @if (session('thongbao'))
            <?php
                echo '<script>alert("'. session('thongbao') .'")</script>';
            ?>
        @endif
    </div>
</div>

@endsection

@section('script')
    <script src="DiDongZin/assets/js/_donhang.js"></script>
    <script>
        window.onload = function(){
            document.getElementById('donHangMenu').classList.add('active');
        }

        function HuyBo(ma)
        {
            if(confirm("Bạn không đồng ý xác nhận đơn hàng có mã là: "+ma))
            {
                if(confirm("Bạn sẽ xóa bỏ đơn hàng này ra khỏi danh sách đơn hàng"))
                {
                    window.location.href = "admin/donhang/huybo/"+ ma;
                }
            }
        }

        function XacNhan(ma)
        {
            if( confirm("Bạn đồng ý xác nhận đơn hàng có mã là: "+ma) )
            {
                window.location.href = "admin/donhang/xacnhan/"+ ma;
            }
        }
    </script>
@endsection