@extends('user.layout.index')

@section('content')

<div class="container page-body">
    <div class="row">
        
        @include('user.layout.menu_QuanLy')

        <div class="col-10 user-tab-content">
            <h3 class="title">Đơn hàng: {{ $hoaDon->Ma_hoa_don }}</h3>
            <div class="donhangmoi row">
                <table class="tb1 col-6">
                    <tr>
                        <th>Mã đơn hàng:</th>
                        <td>{{ $hoaDon->Ma_hoa_don }}</td>
                    
                    </tr>
                    <tr>
                        <th>Khách hàng:</th>
                        <td>{{ $hoaDon->ToGioHang->ToTaiKhoan->Ho_va_ten_lot }} {{ $hoaDon->ToGioHang->ToTaiKhoan->Ten }}</td>
                        
                    </tr>
                    <tr>
                        <th>Số điện thoại:</th>
                        <td>{{ $hoaDon->ToGioHang->ToTaiKhoan->So_dien_thoai }}</td>
                       
                    </tr>
                    <tr>
                        <th>Địa chỉ nhận hàng:</th>
                        <td>{{ $hoaDon->Dia_chi_nhan_hang }}</td>
                    </tr>
                </table>
                <table class="tb1 col-6">
                    <tr>
                        <th>Ngày tạo:</th>
                        <td>{{ $hoaDon->Ngay_tao }}</td>
                    </tr>
                    <tr>
                        <th>Mã khách hàng:</th>
                        <td>{{ $hoaDon->ToGioHang->ToTaiKhoan->Ma_tai_khoan }}</td>
                    </tr>
                    <tr>
                        <th>Hình thức thanh toán:</th>
                        <td>{{ $hoaDon->Hinh_thuc_thanh_toan }}</td>
                    </tr>
                    <tr>
                        <th>Trạng thái:</th>
                        <td class="processing">Đã hoàn thành</td>
                    </tr>
                </table>
                <table class="table table-bordered table-customize table-responsive col-12">
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
                            $dsChiTiet = $hoaDon->ToGioHang->ToChiTietGioHang;
                            $tongTamTinh = 0;    
                        ?>
                        @foreach($dsChiTiet as $chiTiet)
                            <tr>
                                <td data-title="Điện Thoại">
                                    <img src="DiDongZin/imagePhone/{{ $chiTiet->ToDienThoaiDiDong->Hinh_anh }}" alt="dtdd">
                                    <a href="DienThoai/{{ $chiTiet->Ma_dien_thoai }}.html">
                                        {{ $chiTiet->ToDienThoaiDiDong->Ten_dien_thoai }}
                                    </a>
                                </td>
                                <td data-title="Số Lượng">
                                    {{ $chiTiet->So_luong }}
                                </td>

                                {{-- Kiểm tra điện thoại đã mua có trong khuyến mãi không? ------}}
                                <?php
                                    //Lấy điện thoại
                                    $dt = App\DienThoaiDiDong::find($chiTiet->Ma_dien_thoai);

                                    //Lấy khuyến mãi cuối cùng
                                    $dsKM = $dt->ToKhuyenMai;
                                    $hadKM = false;
                                    $phanTramKM;
                                    $gia;                                        

                                    //Ngày tạo kiểu datetime nhưng ngày khuyến mãi kiểu date, nên không so sánh được
                                        //Nên phải cắt chuỗi
                                    $ngayTaoHD = $hoaDon->Ngay_tao;
                                    $pos = strpos($ngayTaoHD, ' ');
                                    
                                        //Ngày tạo đã được cắt chuỗi
                                    $ngayTaoHD = substr($ngayTaoHD, 0, $pos);

                                    foreach ($dsKM as $km) {
                                        if($km->Tu_ngay<=$ngayTaoHD && $ngayTaoHD<=$km->Den_ngay)
                                        {
                                            $hadKM = true;
                                            $phanTramKM = $km->Phan_tram_khuyen_mai;
                                            break;
                                        }
                                    }

                                    if( $hadKM )
                                    {
                                        $gia = $chiTiet->ToGiaBan->Gia * (1- ($phanTramKM/100) );
                                    }
                                    else 
                                    {
                                        $gia = $chiTiet->ToGiaBan->Gia;
                                    }                                
                                ?>
                                <td data-title="Giá">{{ ShowPrice($gia).' VND' }}</td>
                                <td data-title="Tạm tính">{{ ShowPrice($gia * $chiTiet->So_luong).' VND' }}</td>
                                    <?php 
                                        $tongTamTinh += $gia * $chiTiet->So_luong; 
                                    ?>
                            </tr>
                        @endforeach

                        <tr>
                            <th class="title-th " >Tạm tính</th>
                            <td class="title-td dau-td" data-title="Tạm tính" colspan="3">
                                {{ ShowPrice($tongTamTinh).' VND' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="title-th" >Thuế VAT</th>
                            <td class="title-td" data-title="Thuế VAT" colspan="3">
                                {{ ShowPrice($tongTamTinh * 0.1).' VND' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="title-th" >Tổng cộng</th>
                            <td class="title-td" data-title="Tổng cộng" colspan="3">
                                {{ ShowPrice($tongTamTinh + $tongTamTinh * 0.1).' VND' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button class="prm-btn" onclick="InHoaDon()">In hóa đơn</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    <script src="DiDongZin/assets/js/user_manage.js"></script>
    <script>
        window.onload = function(){
            document.getElementById('donHangMenu').classList.add('active');
        }

        function InHoaDon()
        {
            if(confirm('Bạn sẽ in hóa đơn này'))
            {
                alert('Quá trình in hóa đơn bắt đầu. Bạn chờ trong giây lát');
            }
        }
    </script>
@endsection