@extends('admin.layout.index')

@section('content')

<!-- NOI DUNG CHINH ..................................................................................-->
<div class="content">
    <div id="trang" class="tabcontent">
            <h2>QUẢN LÝ TRANG</h2>
            <img src="DiDongZin/assets/img/undraw_tabs_jf82.svg">
            <div class="row">
                <div class="col-4 col-4s cart-thanhvien" onclick="loadPage('index-login-success.html')">
                    <div class="row">
                        <img src="DiDongZin/assets/img/logo-min.png" alt="avatar" class="col-5">
                        <div class="col-7">
                            <h3>Trang chủ</h3>
                            <p>didongzin</p>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-4s cart-thanhvien">
                    <div class="row">
                        <img src="DiDongZin/assets/img/guarantee_200px.png" alt="avatar" class="col-5">
                        <div class="col-7">
                            <h3>Chính sách bảo hành</h3>
                            <p>/chinhsachbaohanh</p>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-4s cart-thanhvien">
                    <div class="row">
                        <img src="DiDongZin/assets/img/cheap_2_100px.png" alt="avatar" class="col-5">
                        <div class="col-7">
                            <h3>Chính sách thanh toán</h3>
                            <p>/chinhsachthanhtoan</p>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-4s cart-thanhvien">
                    <div class="row">
                        <img src="DiDongZin/assets/img/restore_100px.png" alt="avatar" class="col-5">
                        <div class="col-7">
                            <h3>Chính sách đổi trả</h3>
                            <p>/chinhsachdoitra</p>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-4s cart-thanhvien">
                    <div class="row">
                        <img src="DiDongZin/assets/img/worker_100px.png" alt="avatar" class="col-5">
                        <div class="col-7">
                            <h3>Thông tin tác giả</h3>
                            <p>/thongtintacgia</p>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>

@endsection

@section('script')
    <script src="DiDongZin/assets/js/_trang.js"></script>
    <script>
        window.onload = function(){
            document.getElementById('trangMenu').classList.add('active');
        }
    </script>
@endsection