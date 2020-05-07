@extends('user.layout.index')

@section('content')

<div class="container page-body">
    <div class="row">
        <div class="col-8 banner">
            <img src="DiDongZin/assets/img/banner/327e8c9f185ad1c90470f5b86c2bb930.jpg"/>
        </div>
        <div class="col-4 right-banner">
            <div>
                <img src="DiDongZin/assets/img/truck_100px.png" />
                <p>GIAO HÀNG TẬN NƠI</p>
            </div>
            <div>
                <img src="DiDongZin/assets/img/guarantee_100px.png" />
                <p>CAM KẾT CHẤT LƯỢNG</p>
            </div>
            <div>
                <img src="DiDongZin/assets/img/origin_100px.png" />
                <p>ĐỔI TRẢ TRONG 30 NGÀY</p>
                
            </div>
        </div>
    </div>
    
    <!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-->
    <h2  class="title " id="title_allPhone">TẤT CẢ SẢN PHẨM</h2>
    <div class="sort-bar">
        Sắp xếp theo:
        <a onclick="SapXepGiaTheoThuTu('giaThap')" id="giaThap">GIÁ THẤP</a>
        <a onclick="SapXepGiaTheoThuTu('giaCao')" id="giaCao">GIÁ CAO</a>
        {{-- Lưu lại sắp xếp đang chọn --}}
        <input type="hidden" id="sapXepDangChon" value="">

        <div class="dropdown"><span id="sapXepMucGia">MỨC GIÁ</span>
            <div class="dropdown-content">
                <a onclick="ChonGia('duoi2')">Dưới 2 triệu</a>
                <a onclick="ChonGia('2Den5')">2 triệu-5 triệu</a>
                <a onclick="ChonGia('5Den10')">5 triệu-10 triệu</a>
                <a onclick="ChonGia('10Den15')">10 triệu-15 triệu</a>
                <a onclick="ChonGia('tren15')">Trên 15 triệu</a>
                <a onclick="ChonGia('')">Tất cả mức giá</a>
            </div>
            {{-- Lưu lại mức giá đang chọn --}}
            <input type="hidden" id="giaDangChon" value="">
        </div> 
    </div>
    <div class="list-phone row" id="phoneFound">
        @foreach($dsDienThoai as $dt)
            <div class="col-2s" onclick="GoToPhone({{ $dt->Ma_dien_thoai }})">
                <div class="mobile-phone">
                    <img src="DiDongZin/imagePhone/{{ $dt->Hinh_anh }}" style="height: 215px" alt="{{ $dt->Ten_dien_thoai }}">
                    <h2 class="name">{{ $dt->Ten_dien_thoai }}</h2>
                    <span class="price">{{ ShowPrice($dt->ToGiaBan->last()->Gia) }} VND</span>
                </div>
                <div class="hidden-info">
                    <h2 class="name">{{ $dt->Ten_dien_thoai }}</h2>
                    <span class="price">{{ ShowPrice($dt->ToGiaBan->last()->Gia) }} VND</span>
                    <span class="list-info">Màn hình: {{ $dt->Kich_thuoc_man_hinh }} {{ $dt->Do_phan_giai_man_hinh }}</span>
                    <span class="list-info">Chipset: {{ $dt->Chipset }}</span>
                    <span class="list-info">Ram: {{ $dt->RAM }}GB</span>
                    <span class="list-info">Rom: {{ $dt->ROM }}GB</span>
                    <span class="list-info">Khe sim: {{ $dt->Khe_sim }}</span>
                    <span class="list-info">Pin: {{ $dt->Pin }}mah</span>
                    <span class="list-info">OS: {{ $dt->OS }} {{ $dt->Phien_ban_OS }}</span>
                </div>
            </div>
        @endforeach
                
    </div>

    {{-- Nhận noiDung tìm kiếm trước đó --}}
    <input type="hidden" id="noiDungTimKiem" value="">

    <div class="see-more" id="btnXemThem_tatCa">
        <button class="prm-btn">Xem Thêm</button>
    </div>

    <!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-->
    <div id="banChay">
        <h2 class="title">BÁN CHẠY</h2>
        <div class="top-sale row">
            @foreach($dsMaBanChay as $maDT)
                <?php
                    $dt = App\DienThoaiDiDong::find($maDT);
                ?>
                <div class="col-2s"  onclick="GoToPhone({{ $dt->Ma_dien_thoai }})">
                    <div class="mobile-phone">
                        <img src="DiDongZin/imagePhone/{{ $dt->Hinh_anh }}" style="height: 215px" alt="{{ $dt->Ten_dien_thoai }}">
                        <h2 class="name">{{ $dt->Ten_dien_thoai }}</h2>
                        <span class="price">{{ ShowPrice($dt->ToGiaBan->last()->Gia) }} VND</span>
                    </div>
                    <div class="hidden-info">
                        <h2 class="name">{{ $dt->Ten_dien_thoai }}</h2>
                        <span class="price">{{ ShowPrice($dt->ToGiaBan->last()->Gia) }} VND</span>
                        <span class="list-info">Màn hình: {{ $dt->Kich_thuoc_man_hinh }} {{ $dt->Do_phan_giai_man_hinh }}</span>
                        <span class="list-info">Chipset: {{ $dt->Chipset }}</span>
                        <span class="list-info">Ram: {{ $dt->RAM }}GB</span>
                        <span class="list-info">Rom: {{ $dt->ROM }}GB</span>
                        <span class="list-info">Khe sim: {{ $dt->Khe_sim }}</span>
                        <span class="list-info">Pin: {{ $dt->Pin }}mah</span>
                        <span class="list-info">OS: {{ $dt->OS }} {{ $dt->Phien_ban_OS }}</span>
                    </div>
                </div>
            @endforeach

        </div>
        <div class="see-more">
            <button class="prm-btn">Xem Thêm</button>
        </div>
    </div>
    
    <!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-->
    <div id="giamGiaManh">
        <h2   class="title">GIẢM GIÁ MẠNH</h2>
        <div class="top-sale row">
            @foreach($dsMaGiamGia as $maDT)
                <?php
                    $dt = App\DienThoaiDiDong::find($maDT);
                ?>
                <div class="col-2s "  onclick="GoToPhone({{ $dt->Ma_dien_thoai }})">
                    <div class="mobile-phone">
                        <img src="DiDongZin/imagePhone/{{ $dt->Hinh_anh }}" style="height: 215px" alt="{{ $dt->Ten_dien_thoai }}">
                        <h2 class="name">{{ $dt->Ten_dien_thoai }}</h2>
                        <span class="price">{{ ShowPrice($dt->ToGiaBan->last()->Gia) }} VND</span>
                    </div>
                    <div class="hidden-info">
                        <h2 class="name">{{ $dt->Ten_dien_thoai }}</h2>
                        <span class="price">{{ ShowPrice($dt->ToGiaBan->last()->Gia) }} VND</span>
                        <span class="list-info">Màn hình: {{ $dt->Kich_thuoc_man_hinh }} {{ $dt->Do_phan_giai_man_hinh }}</span>
                        <span class="list-info">Chipset: {{ $dt->Chipset }}</span>
                        <span class="list-info">Ram: {{ $dt->RAM }}GB</span>
                        <span class="list-info">Rom: {{ $dt->ROM }}GB</span>
                        <span class="list-info">Khe sim: {{ $dt->Khe_sim }}</span>
                        <span class="list-info">Pin: {{ $dt->Pin }}mah</span>
                        <span class="list-info">OS: {{ $dt->OS }} {{ $dt->Phien_ban_OS }}</span>
                    </div>
                </div>
            @endforeach
            
        </div>
        <div class="see-more">
            <button class="prm-btn">Xem Thêm</button>
        </div>
    </div>

    @if (session('noiDungCanTimKiem'))
        <?php
            echo '<script>';
                $noiDung = session()->get('noiDungCanTimKiem');
                // Cắt khoảng trắng thừa ở đầu và cuối chuỗi
                $noiDung = trim($noiDung, ' ');
                
                echo 'document.getElementById("btnXemThem_tatCa").innerHTML = "";';
                echo 'document.getElementById("banChay").innerHTML = "";';
                echo 'document.getElementById("giamGiaManh").innerHTML = "";';
                
                // Gọi Ajax
                echo '$.get("SapXepDienThoaiAjax/'. $noiDung .'/khongChon/khongChon", function(data){
                    document.getElementById("phoneFound").innerHTML = data;
                });';
                echo 'document.getElementById("noiDungTimKiem").value = "'. $noiDung .'";';
                echo 'document.getElementById("title_allPhone").innerHTML = "Kết quả tìm kiếm \''. $noiDung .'\'";';
            echo '</script>';
        ?>
    @endif
</div>

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

@endsection

@section('script')
    <script>
        function GoToPhone(ma)
        {
            window.location.href = 'DienThoai/'+ma+'.html';
        }

        // document.getElementById('text_search').onkeydown = function(e){
        //     if(e.keyCode == 13)
        //     {
        //         noiDung = document.getElementById('text_search').value;
        //         // Cắt khoảng trắng thừa ở đầu và cuối chuỗi
        //         noiDung = noiDung.trim(noiDung);
                
        //         // Nếu là lần tìm kiếm đầu tiên
        //         if( document.getElementById('btnXemThem_tatCa').innerHTML != '')
        //         {
        //             document.getElementById('btnXemThem_tatCa').innerHTML = '';
        //             document.getElementById('banChay').innerHTML = '';
        //             document.getElementById('giamGiaManh').innerHTML = '';
        //         }

        //         // Lấy giá trị của mức giá và kiểu sắp xếp
        //         mucGia = document.getElementById('giaDangChon').value;
        //         thuTu = document.getElementById('sapXepDangChon').value;
        //         if(mucGia == '')
        //         {
        //             mucGia = 'khongChon';
        //         }
        //         if(thuTu == '')
        //         {
        //             thuTu = 'khongChon';
        //         }
        //         // Kiểm tra nội dung nhập khi nhân Enter có rỗng không
        //         if(noiDung == '')
        //         {
        //             noiDung = 'khongChon';
        //             document.getElementById('title_allPhone').innerHTML = 'TẤT CẢ SẢN PHẨM';
        //         }
        //         else
        //         {
        //             document.getElementById('title_allPhone').innerHTML = 'Kết quả tìm kiếm \''+noiDung+'\'';
        //         }

        //         // Gọi Ajax
        //         $.get('SapXepDienThoaiAjax/'+noiDung+'/'+mucGia+'/'+thuTu, function(data){
        //             document.getElementById('phoneFound').innerHTML = data;
        //         });
        //         document.getElementById('text_search').value = '';
        //         document.getElementById('noiDungTimKiem').value = noiDung;
        //     }
        // }

        function ChonGia(mucGia)
        {
            switch(mucGia)
            {
                case 'duoi2':
                    document.getElementById('sapXepMucGia').innerHTML = 'Dưới 2 triệu';
                    document.getElementById('giaDangChon').value = "duoi2";
                    break;
                
                case '2Den5':
                    document.getElementById('sapXepMucGia').innerHTML = '2 triệu-5 triệu';
                    document.getElementById('giaDangChon').value = "2Den5";
                    break;
                
                case '5Den10':
                    document.getElementById('sapXepMucGia').innerHTML = '5 triệu-10 triệu';
                    document.getElementById('giaDangChon').value = "5Den10";
                    break;

                case '10Den15':
                    document.getElementById('sapXepMucGia').innerHTML = '10 triệu-15 triệu';
                    document.getElementById('giaDangChon').value = "10Den15";
                    break;

                case 'tren15':
                    document.getElementById('sapXepMucGia').innerHTML = 'Trên 15 triệu';
                    document.getElementById('giaDangChon').value = "tren15";
                    break;

                // Chọn tất cả mức giá
                case '':
                    document.getElementById('sapXepMucGia').innerHTML = 'Tất cả mức giá';
                    document.getElementById('giaDangChon').value = "";
                    break;
            }
            // Nếu là lần tìm kiếm đầu tiên
            if( document.getElementById('btnXemThem_tatCa').innerHTML != '')
            {
                document.getElementById('title_allPhone').innerHTML = 'Kết quả tìm kiếm';
                document.getElementById('btnXemThem_tatCa').innerHTML = '';
                document.getElementById('banChay').innerHTML = '';
                document.getElementById('giamGiaManh').innerHTML = '';
            }

            // Lấy giá trị của nội dung tìm kiếm và kiểu sắp xếp
            noiDung = document.getElementById('noiDungTimKiem').value;
            thuTu = document.getElementById('sapXepDangChon').value;
            if(noiDung == '')
            {
                noiDung = 'khongChon';
            }
            if(thuTu == '')
            {
                thuTu = 'khongChon';
            }
            if(mucGia == '')
            {
                mucGia = 'khongChon';
            }

            // Gọi Ajax
            $.get('SapXepDienThoaiAjax/'+noiDung+'/'+mucGia+'/'+thuTu, function(data){
                document.getElementById('phoneFound').innerHTML = data;
            });
        }

        function SapXepGiaTheoThuTu(thuTu)
        {
            //Gán màu lại bình thường cho 1 trong 2 màu đã được chọn
            document.getElementById('giaCao').style.color = 'black';
            document.getElementById('giaThap').style.color = 'black';
            
            // Lấy giá trị của nội dung tìm kiếm và mức giá
            noiDung = document.getElementById('noiDungTimKiem').value;
            mucGia = document.getElementById('giaDangChon').value;
            if(noiDung == '')
            {
                noiDung = 'khongChon';
            }
            if(mucGia == '')
            {
                mucGia = 'khongChon';
            }

            if(thuTu == 'giaCao')
            {
                document.getElementById('giaCao').style.color = 'var(--primary-color)';
                document.getElementById('sapXepDangChon').value = 'giaCao';
            }
            else if(thuTu == 'giaThap')
            {
                document.getElementById('giaThap').style.color = 'var(--primary-color)';
                document.getElementById('sapXepDangChon').value = 'giaThap';
            }

            // Nếu là lần tìm kiếm đầu tiên
            if( document.getElementById('btnXemThem_tatCa').innerHTML != '')
            {
                document.getElementById('title_allPhone').innerHTML = 'Kết quả tìm kiếm';
                document.getElementById('btnXemThem_tatCa').innerHTML = '';
                document.getElementById('banChay').innerHTML = '';
                document.getElementById('giamGiaManh').innerHTML = '';
            }
            
            // Gọi Ajax
            $.get('SapXepDienThoaiAjax/'+noiDung+'/'+mucGia+'/'+thuTu, function(data){
                document.getElementById('phoneFound').innerHTML = data;
            });
        }
    </script>
@endsection