@extends('admin.layout.index')

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

<!-- NOI DUNG CHINH ..................................................................................-->
<div class="content">
    <div id="thongke" class="tabcontent">
        <h2>THỐNG KÊ</h2>
        <div class="row">
            <?php
                $soDienThoai = App\DienThoaiDiDong::all()->count();
                $soHangDT = App\HangDienThoaiDiDong::all()->count();
                $soThanhVien = App\TaiKhoan::all()->count();
                $soHoaDonThanhCong = App\HoaDon::where('Trang_thai', '=', 1)->count();    
            ?>
            <div class="col-3 thongkeitem">
                <h1>{{ $soDienThoai }}</h1>
                <img src="DiDongZin/assets/img/smartphone_tablet_100px.png">
                <p>Điện thoại</p>
            </div>
            <div class="col-3 thongkeitem">
                <h1>{{ $soHangDT }}</h1>
                <img src="DiDongZin/assets/img/company_100px.png">
                <p>Hãng điện thoại</p>
            </div>
            <div class="col-3 thongkeitem">
                <h1>{{ $soThanhVien }}</h1>
                <img src="DiDongZin/assets/img/user_groups_50px.png">
                <p>Thành viên</p>
            </div>
            <div class="col-3 thongkeitem">
                <h1>{{ $soHoaDonThanhCong }}</h1>
                <img src="DiDongZin/assets/img/procurement_50px.png">
                <p>Đơn hàng thành công</p>
            </div>
            <div class="col-9 bieudo">
                <p>Thống kê tuần:</p>
                <input type="week" value="2020-W22">
                <canvas id="myChart" height="150" width="400"></canvas>
            </div>
            <div class="col-3 chitieu">
                <p>Chỉ tiêu hôm nay:</p>
                <svg viewBox="0 0 36 36" class="circular-chart">
                    <path class="circle-stroke" fill="none" stroke-width="3.8" d="M18 2.0845
                    a 15.9155 15.9155 0 0 1 0 31.831
                    a 15.9155 15.9155 0 0 1 0 -31.831" />
                    <path class="circle" fill="none" stroke="#e74c3c" stroke-width="2.8" stroke-linecap="round"
                        stroke-dasharray="60, 100" d="M18 2.0845
                    a 15.9155 15.9155 0 0 1 0 31.831
                    a 15.9155 15.9155 0 0 1 0 -31.831" />
                    <text x="18" y="20.35" class="percentage" text-anchor="middle" font-size="0.5em"
                        fill="#666666">60%</text>
                </svg>
                <p>Bán 10 điện thoại</p>
                <svg viewBox="0 0 36 36" class="circular-chart">
                    <path class="circle-stroke" fill="none" stroke-width="3.8" d="M18 2.0845
                    a 15.9155 15.9155 0 0 1 0 31.831
                    a 15.9155 15.9155 0 0 1 0 -31.831" />
                    <path class="circle" fill="none" stroke="#2c3e50" stroke-width="2.8" stroke-linecap="round"
                        stroke-dasharray="50, 100" d="M18 2.0845
                    a 15.9155 15.9155 0 0 1 0 31.831
                    a 15.9155 15.9155 0 0 1 0 -31.831" />
                    <text x="18" y="20.35" class="percentage" text-anchor="middle" font-size="0.5em"
                        fill="#666666">50%</text>
                </svg>
                <p>2 thành viên mới</p>
            </div>
            <div class="col-12 baocao">
                <p>Báo cáo doanh thu</p>
                <span>Loại báo cáo:</span>
                <select id="kieubaocao" onchange="doiKieuBC()">
                    <option value="1">Hóa Đơn</option>
                    <option value="2">Sản Phẩm</option>
                </select>
                
                <span>Thời gian báo cáo</span>
                <select onchange="doiLoaiBaoCao()" id="LoaiBaoCao" name="loaibaocao">
                    <option value="1">Ngày:</option>
                    {{-- <option value="2">Tuần:</option> --}}
                    <option value="3">Tháng:</option>
                    <option value="4">Năm:</option>
                </select>
                <input type="date" id="ThoiGianBaoCao" name="thoigianbaocao" onchange="LayDuLieuBaoCao()">
                <select id="NamBaoCao" name="nambaocao" onchange="LayDuLieuBaoCao()">
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                </select>
                <div id="bangBaoCao">
                    <table  id="duLieuBangHoaDon">
                        <thead>
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
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $tongThu = 0;
                                $tongThue = 0;
                                $tongVon = 0;
                                $tongLai = 0;    
                            ?>
                            @foreach ($dsHoaDon as $hd)
                                <tr>
                                    <td>
                                        {{ $hd->Ma_hoa_don }}
                                    </td>
                                    <td>
                                        {{ $hd->Ngay_tao }}
                                    </td>
                                    <td>
                                        <?php
                                            $tongHoaDon = 0;
                                            foreach ($hd->ToGioHang->ToChiTietGioHang as $chiTiet) {
                                                $tongHoaDon += $chiTiet->So_luong * $chiTiet->ToGiaBan->Gia;
                                            }
                                            $tongThu += $tongHoaDon;    
                                        ?>
                                        {{ ShowPrice($tongHoaDon) }} VND
                                    </td>
                                    <td>
                                        <?php
                                            $tongThue += $tongHoaDon * 0.1;    
                                        ?>
                                        {{ ShowPrice($tongHoaDon * 0.1) }} VND
                                    </td>
                                    <td>
                                        <?php
                                            $tongVonHoaDon = 0;
                                            foreach ($hd->ToGioHang->ToChiTietGioHang as $chiTiet) {
                                                $tongVonHoaDon += $chiTiet->So_luong * $chiTiet->ToGiaBan->ToGiaVon->Gia;
                                            }
                                            $tongVon += $tongVonHoaDon;    
                                        ?>
                                        {{ ShowPrice($tongVonHoaDon) }} VND
                                    </td>
                                    <td>
                                        <?php
                                            $tongLai += $tongHoaDon - $tongVonHoaDon;    
                                        ?>
                                        {{ ShowPrice($tongHoaDon - $tongVonHoaDon) }} VND
                                    </td>
                                    <td>
                                        <?php
                                            $user = $hd->ToGioHang->ToTaiKhoan;    
                                        ?>
                                        <a href="id=00001">{{ $user->Ho_va_ten_lot }} {{ $user->Ten }}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="6">Tổng thu:</th>
                                <td>{{ ShowPrice($tongThu) }} VND</td>
                            </tr>
                            <tr>
                                <th colspan="6">Tổng thuế:</th>
                                <td>{{ ShowPrice($tongThue) }} VND</td>
                            </tr>
                            <tr>
                                <th colspan="6">Tổng giá trị vốn:</th>
                                <td>{{ ShowPrice($tongVon) }} VND</td>
                            </tr>
                            <tr>
                                <th colspan="6">Tổng lãi gộp:</th>
                                <td>{{ ShowPrice($tongLai) }} VND</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div id="bangSanPham">
                    <table>
                        <thead>
                            <tr>
                                <th>
                                    Mã Sản Phẩm
                                </th>
                                <th>
                                    Tên sản phẩm
                                </th>
                                <th>
                                    Tổng tiền
                                </th>
                                <th>
                                    Tổng thuế
                                </th>
                                <th>
                                    Tổng vốn
                                </th>
                                <th>
                                    Tổng lãi
                                </th>
                                <th>
                                    Số lượng bán
                                </th>
                            </tr>
                        </thead>
                        <tbody id="duLieuBangSanPham">
                            @foreach ($dsMaDienThoai as $maDT)
                                <?php
                                    $tongTienDT = 0;
                                    $tongVonDT = 0;
                                    $tongLaiDT = 0;
                                    $soLuongBanDT = 0;

                                    $dt = App\DienThoaiDiDong::find($maDT);
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
                                ?>
                                <tr>
                                    <td>
                                        {{ $dt->Ma_dien_thoai }}
                                    </td>
                                    <td>
                                        {{ $dt->Ten_dien_thoai }}
                                    </td>
                                    <td>
                                        {{ ShowPrice($tongTienDT) }} VND
                                    </td>
                                    <td>
                                        {{ ShowPrice($tongTienDT * 0.1) }} VND
                                    </td>
                                    <td>
                                        {{ ShowPrice($tongVonDT) }} VND
                                    </td>
                                    <td>
                                        {{ ShowPrice($tongLaiDT) }} VND
                                    </td>
                                    <td>
                                        {{ $soLuongBanDT }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

{{-- SECTION 'SCRIPT' ................................................ --}}

@section('script')
    <script src="DiDongZin/assets/js/Chart.js"></script>
    <script src="DiDongZin/assets/js/_thongke.js"></script>
    <script>
        window.onload = function()
        {
            document.getElementById('thongKeMenu').classList.add('active');
        }

        function LayDuLieuBaoCao()
        {
            loaiThoiGian = document.getElementById('LoaiBaoCao').value;
            thoiGian = '';
            if(loaiThoiGian == 1)
            {
                loaiThoiGian = 'ngay'; 
                thoiGian = document.getElementById('ThoiGianBaoCao').value;   
            }
            else if(loaiThoiGian == 3 )
            {
                loaiThoiGian = 'thang';    
                thoiGian = document.getElementById('ThoiGianBaoCao').value;
            }
            else if( loaiThoiGian == 4)
            {
                loaiThoiGian = 'nam';
                thoiGian = document.getElementById('NamBaoCao').value;
            }
            
            kieuBaoCao = document.getElementById('kieubaocao').value;
            if(kieuBaoCao == 1)
            {
                $.get('admin/ThongKeHoaDonAjax/'+loaiThoiGian+'/'+thoiGian, function(data){
                    document.getElementById('duLieuBangHoaDon').innerHTML = data;
                });
            }
            else if(kieuBaoCao == 2)
            {
                $.get('admin/ThongKeDienThoaiAjax/'+loaiThoiGian+'/'+thoiGian, function(data){
                    document.getElementById('duLieuBangSanPham').innerHTML = data;
                });
            }
        }
    </script>
@endsection