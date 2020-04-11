@extends('admin.layout.index')

@section('content')

<!-- NOI DUNG CHINH ..................................................................................-->
<div class="content">
    <div id="thongke" class="tabcontent">
          <h2>THỐNG KÊ</h2>
          <div class="row">
              <div class="col-3 thongkeitem">
                  <h1>91</h1>
                  <img src="DiDongZin/assets/img/smartphone_tablet_100px.png">
                  <p>Điện thoại</p>
              </div>
              <div class="col-3 thongkeitem">
                  <h1>7</h1>
                  <img src="DiDongZin/assets/img/company_100px.png">
                  <p>Hãng điện thoại</p>
              </div>
              <div class="col-3 thongkeitem">
                  <h1>172</h1>
                  <img src="DiDongZin/assets/img/user_groups_50px.png">
                  <p>Thành viên</p>
              </div>
              <div class="col-3 thongkeitem">
                  <h1>100+</h1>
                  <img src="DiDongZin/assets/img/procurement_50px.png">
                  <p>Đơn hàng thành công</p>
              </div>
              <div class="col-9 bieudo">
                  <p>Thống kê tuần:</p>
                  <input type="week">
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
              <div class="col-6 phanhoi">
                  <p>Phản hồi khách hàng:</p>
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