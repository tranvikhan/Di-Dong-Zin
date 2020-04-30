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
    <h2  class="title ">TẤT CẢ SẢN PHẨM</h2>
    <div class="sort-bar">
        Sắp xếp theo:
        <a>GIÁ THẤP</a>
        <a>GIÁ CAO</a>
        <div class="dropdown">MỨC GIÁ
            <div class="dropdown-content">
                <a>Dưới 2 triệu</a>
                <a>2 triệu-5 triệu</a>
                <a>5 triệu-10 triệu</a>
                <a>10 triệu-15 triệu</a>
                <a>Trên 15 triệu</a>
            </div>
        </div> 
    </div>
    <div class="list-phone row">
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
    <div class="see-more">
        <button class="prm-btn">Xem Thêm</button>
    </div>
    <!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-->
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
    <!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-->
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
    </script>
@endsection