@extends('admin.layout.index')

@section('content')

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
                    <option value="2">Tuần:</option>
                    <option value="3">Tháng:</option>
                    <option value="4">Năm:</option>
                </select>
                <input type="date" id="ThoiGianBaoCao" name="thoigianbaocao">
                <select id="NamBaoCao" name="nambaocao">
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                </select>
                <div id="bangBaoCao">
                    <table>
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
                            <tr>
                                <td>
                                    1
                                </td>
                                <td>
                                    20/10/2020
                                </td>
                                <td>
                                    15.000.000đ
                                </td>
                                <td>
                                    1.500.000
                                </td>
                                <td>
                                    14.000.000
                                </td>
                                <td>
                                    1.000.000
                                </td>
                                <td>
                                    <a href="id=00001">Nguyễn Văn B</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    2
                                </td>
                                <td>
                                    20/10/2020
                                </td>
                                <td>
                                    15.000.000đ
                                </td>
                                <td>
                                    1.500.000
                                </td>
                                <td>
                                    14.000.000
                                </td>
                                <td>
                                    1.000.000
                                </td>
                                <td>
                                    <a href="id=00001">Nguyễn Văn B</a>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="6">Tổng thu:</th>
                                <td>15.000.000</td>
                            </tr>
                            <tr>
                                <th colspan="6">Tổng thuế:</th>
                                <td>1.500.000</td>
                            </tr>
                            <tr>
                                <th colspan="6">Tổng giá trị vốn:</th>
                                <td>14.000.000</td>
                            </tr>
                            <tr>
                                <th colspan="6">Tổng lãi gộp:</th>
                                <td>1.000.000</td>
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
                        <tbody>
                            <tr>
                                <td>
                                    SP0001
                                </td>
                                <td>
                                    Iphone 11 Pro Max
                                </td>
                                <td>
                                    15.000.000đ
                                </td>
                                <td>
                                    1.500.000
                                </td>
                                <td>
                                    14.000.000
                                </td>
                                <td>
                                    1.000.000
                                </td>
                                <td>
                                    1
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    SP0002
                                </td>
                                <td>
                                    Iphone 10
                                </td>
                                <td>
                                    15.000.000đ
                                </td>
                                <td>
                                    1.500.000
                                </td>
                                <td>
                                    14.000.000
                                </td>
                                <td>
                                    1.000.000
                                </td>
                                <td>
                                    1
                                </td>
                            </tr>
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
    </script>
@endsection