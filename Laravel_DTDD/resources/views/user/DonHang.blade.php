@extends('user.layout.index')

@section('content')
    
<div class="container page-body">
    <div class="row">
        
        @include('user.layout.menu_QuanLy')

        <div class="col-10 user-tab-content">
            <h3 class="title">Đơn hàng</h3>
            <div class="donhangmoi row">
                <table class="tb1 col-6">
                    <tr>
                        <th>Mã đơn hàng:</th>
                        <td >001</td>
                    
                    </tr>
                    <tr>
                        <th>Khách hàng:</th>
                        <td>Trần Vi Khan</td>
                        
                    </tr>
                    <tr>
                        <th>Số điện thoại:</th>
                        <td >0974184717</td>
                       
                    </tr>
                    <tr>
                        <th>Địa chỉ nhận hàng:</th>
                        <td>Long Mỹ, Hậu Giang</td>
                    </tr>
                </table>
                <table class="tb1 col-6">
                    <tr>
                        <th>Ngày tạo:</th>
                        <td>22/4/2020</td>
                    </tr>
                    <tr>
                        <th>Mã khách hàng:</th>
                        <td>001</td>
                    </tr>
                    <tr>
                        <th>Hình thức thanh toán:</th>
                        <td>Online</td>
                    </tr>
                    <tr>
                        <th>Trạng thái:</th>
                        <td class="processing">Đang chờ xử lý..</td>
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
                        <tr>
                            <td data-title="Điện Thoại">
                                <img src="imagePhone/iphone11-black-1.png" alt="dtdd">
                                <a href="#">iPhone11 64Gb Mới Chính Hãng</a>
                            </td>
                            <td data-title="Số Lượng">
                                1
                            </td>
                            <td data-title="Giá">19.190.000 VND</td>
                            <td data-title="Tạm tính">19.190.000 VND</td>
                        </tr>
                        <tr>
                            <td data-title="Điện Thoại">
                                <img src="imagePhone/iphone11-black-1.png" alt="dtdd">
                                <a class="ten-dt" href="#">iPhone11 64Gb Mới Chính Hãng</a>
                            </td>
                            <td data-title="Số Lượng">
                                2
                            </td>
                            <td data-title="Giá">19.190.000 VND</td>
                            <td data-title="Tạm tính">19.190.000 VND</td>
                        </tr>
                         <tr>
                             <th class="title-th " >Tạm tính</th>
                             <td class="title-td dau-td" data-title="Tạm tính" colspan="3">
                                 31.916.151 VND
                             </td>
                         </tr>
                         <tr>
                             <th class="title-th" >Thuế VAT</th>
                             <td class="title-td" data-title="Thuế VAT" colspan="3">
                                 0
                             </td>
                         </tr>
                         <tr>
                             <th class="title-th" >Tổng cộng</th>
                             <td class="title-td" data-title="Tổng cộng" colspan="3">
                                 31.916.151 VND
                             </td>
                         </tr>
                    </tbody>
                </table>
                <button class="prm-btn">Hủy đơn hàng</button>
            </div>
            <div class="donhangmoi row">
                <a href="_user_chitietdonhang.html">Xem</a>
                <table class="tb1 col-6">
                    <tr>
                        <th>Mã đơn hàng:</th>
                        <td>002</td>

                    </tr>
                    <tr>
                        <th>Khách hàng:</th>
                        <td>Trần Vi Khan</td>

                    </tr>
                    <tr>
                        <th>Số điện thoại:</th>
                        <td>0974184717</td>

                    </tr>
                    <tr>
                        <th>Địa chỉ nhận hàng:</th>
                        <td>Cần Thơ</td>
                    </tr>
                </table>
                <table class="tb1 col-6">
                    <tr>
                        <th>Ngày tạo:</th>
                        <td>2/4/2020</td>
                    </tr>
                    <tr>
                        <th>Mã khách hàng:</th>
                        <td>001</td>
                    </tr>
                    <tr>
                        <th>Hình thức thanh toán:</th>
                        <td>Offline</td>
                    </tr>
                    <tr>
                        <th>Trạng thái:</th>
                        <td class="processing">Đã hoàn thành</td>
                    </tr>
                    
                </table>
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
    </script>
@endsection