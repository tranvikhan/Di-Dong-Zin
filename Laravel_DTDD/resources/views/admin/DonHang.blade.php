@extends('admin.layout.index')

@section('content')

<!-- NOI DUNG CHINH ..................................................................................-->
<div class="content">
    <div id="donhang" class="tabcontent">
        <h2>QUẢN LÝ ĐƠN HÀNG</h2>
        <div class="donhangmoi">
            <table class="tb1">
                <tr>
                    <th>Mã đơn hàng:</th>
                    <td>001</td>
                    <th>Ngày tạo:</th>
                    <td>22/4/2020</td>
                </tr>
                <tr>
                    <th>Khách hàng:</th>
                    <td>Trần Vi Khan</td>
                    <th>Mã khách hàng:</th>
                    <td>001</td>
                </tr>
                <tr>
                    <th>Số điện thoại:</th>
                    <td >0974184717</td>
                    <th>Hình thức thanh toán:</th>
                    <td>Online</td>
                </tr>
                <tr>
                    <th>Địa chỉ nhận hàng:</th>
                    <td colspan="3">Long Mỹ, Hậu Giang</td>

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
                <tr>
                    <td>
                        1
                    </td>
                    <td>
                        <img src="DiDongZin/imagePhone/ABv0_s20-hong.png" width="50px">
                        <span>iPhone11 64Gb Mới Chính Hãng</span>
                    </td>
                    <td>
                        1
                    </td>
                    <td>
                        19.190.000
                    </td>
                    <td>
                        19.190.000
                    </td>
                </tr>
                <tr>
                    <th colspan="4">
                        Tổng cộng:
                    </th>
                    <td>
                        19.190.000
                    </td>
                </tr>
                <tr>
                    <th colspan="4">
                        Thuế VAT:
                    </th>
                    <td>
                        100.000
                    </td>
                </tr>
                <tr>
                    <th colspan="4">
                        Tổng thanh toán:
                    </th>
                    <td>
                        19.290.000
                    </td>
                </tr>
            </table>
            <div class="g-btn-xacnhan">
                <button class="btnThemdienthoai"><img src="DiDongZin/assets/img/cancel_30px.png">Hủy bỏ</button>
                <button class="btnThemdienthoai"><img src="DiDongZin/assets/img/checked_30px.png">Xác nhận</button>
            </div>


        </div>
        <div class="donhangmoi">
            <table class="tb1">
                <tr>
                    <th>Mã đơn hàng:</th>
                    <td colspan="3">002</td>
                    <th>Ngày tạo:</th>
                    <td>22/4/2020</td>
                </tr>
                <tr>
                    <th>Khách hàng:</th>
                    <td colspan="3">Nguyễn Tấn Thịnh</td>
                    <th>Mã khách hàng:</th>
                    <td>002</td>
                </tr>
                <tr>
                    <th>Số điện thoại:</th>
                    <td colspan="3">097654512</td>
                    <th>Hình thức thanh toán:</th>
                    <td>Offline</td>
                </tr>
                <tr>
                    <th>Địa chỉ nhận hàng:</th>
                    <td colspan="5">Campuchia</td>

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
                <tr>
                    <td>
                        1
                    </td>
                    <td>
                        <img src="DiDongZin/imagePhone/ABv0_s20-hong.png" width="50px">
                        <span>Samsung Galaxy S20 8Gb/256Gb Mới Chính Hãng</span>
                    </td>
                    <td>
                        1
                    </td>
                    <td>
                        19.490.000
                    </td>
                    <td>
                        19.490.000
                    </td>
                </tr>
                <tr>
                    <td>
                        1
                    </td>
                    <td>
                        <img src="DiDongZin/imagePhone/ABv0_s20-hong.png" width="50px">
                        <span>iPhone11 64Gb Mới Chính Hãng</span>
                    </td>
                    <td>
                        1
                    </td>
                    <td>
                        19.490.000
                    </td>
                    <td>
                        19.490.000
                    </td>
                </tr>
                <tr>
                    <th colspan="4">
                        Tổng cộng:
                    </th>
                    <td>
                        38.680.000
                    </td>
                </tr>
                <tr>
                    <th colspan="4">
                        Thuế VAT:
                    </th>
                    <td>
                        200.000
                    </td>
                </tr>
                <tr>
                    <th colspan="4">
                        Tổng thanh toán:
                    </th>
                    <td>
                        38.880.000
                    </td>
                </tr>
            </table>
            <div class="g-btn-xacnhan">
                <button class="btnThemdienthoai"><img src="DiDongZin/assets/img/cancel_30px.png">Hủy bỏ</button>
                <button class="btnThemdienthoai"><img src="DiDongZin/assets/img/checked_30px.png">Xác nhận</button>
            </div>


        </div>
    </div>
</div>

@endsection

@section('script')
    <script src="DiDongZin/assets/js/_donhang.js"></script>
    <script>
        window.onload = function(){
            document.getElementById('donHangMenu').classList.add('active');
        }
    </script>
@endsection