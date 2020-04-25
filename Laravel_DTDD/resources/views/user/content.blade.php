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
    <div   class="list-phone row">
        <div class="col-2s ">
            <div class="mobile-phone">
                <img src="DiDongZin/imagePhone/iphone11-black-1.png" alt="iphone11">
                <h2 class="name">iPhone 11 64GB Mới Chính Hãng</h2>
                <span class="price">19.190.000 VND</span>
            </div>
            <div class="hidden-info">
                <h2 class="name">iPhone 11 64GB Mới Chính Hãng</h2>
                <span class="price">19.190.000 VND</span>
                <span class="list-info">Màn hình: 6.5 inch 1231x555</span>
                <span class="list-info">Chipset: Apple A11</span>
                <span class="list-info">Ram: 3Gb</span>
                <span class="list-info">Rom: 64Gb</span>
                <span class="list-info">Khe sim: 1</span>
                <span class="list-info">Pin: 2500mah</span>
                <span class="list-info">OS: IOS 13</span>
            </div>
        </div>
        <div class="col-2s">
            <div class="mobile-phone">
                <img src="DiDongZin/imagePhone/iphoneX-space-gray-300x400.png" alt="iphoneX">
                <h2 class="name">iPhoneX 64Gb Mới Chính Hãng</h2>
                <span class="price">11.190.000 VND</span>
            </div>
            <div class="hidden-info">
                <h2 class="name">iPhoneX 64Gb Mới Chính Hãng</h2>
                <span class="price">11.190.000 VND</span>
                <span class="list-info">Màn hình: 6.5 inch 1231x555</span>
                <span class="list-info">Chipset: Apple A11</span>
                <span class="list-info">Ram: 3Gb</span>
                <span class="list-info">Rom: 64Gb</span>
                <span class="list-info">Khe sim: 1</span>
                <span class="list-info">Pin: 2500mah</span>
                <span class="list-info">OS: IOS 13</span>
            </div>
        </div>
        <div class="col-2s">
            <div class="mobile-phone">
                <img src="DiDongZin/imagePhone/s20-hong.png" alt="galaxys20">
                <h2 class="name">Samsung Galaxy S20 8Gb/256Gb Mới Chính Hãng</h2>
                <span class="price">19.490.000 VND</span>
            </div>
            <div class="hidden-info">
                <h2 class="name">Samsung Galaxy S20 8Gb/256Gb Mới Chính Hãng</h2>
                <span class="price">19.490.000 VND</span>
                <span class="list-info">Màn hình: 6.5 inch 1231x555</span>
                <span class="list-info">Chipset: Apple A11</span>
                <span class="list-info">Ram: 3Gb</span>
                <span class="list-info">Rom: 64Gb</span>
                <span class="list-info">Khe sim: 1</span>
                <span class="list-info">Pin: 2500mah</span>
                <span class="list-info">OS: IOS 13</span>
            </div>
        </div>
        <div class="col-2s">
            <div class="mobile-phone">
                <img src="DiDongZin/imagePhone/SAMSUNG-GALAXY-S10-300x400.png" alt="galaxys10">
                <h2 class="name">Samsung Galaxy S10 128Gb Chính Hãng</h2>
                <span class="price">13.990.000 VND</span>
            </div>
            <div class="hidden-info">
                <h2 class="name">Samsung Galaxy S10 128Gb Chính Hãng</h2>
                <span class="price">13.990.000 VND</span>
                <span class="list-info">Màn hình: 6.5 inch 1231x555</span>
                <span class="list-info">Chipset: Apple A11</span>
                <span class="list-info">Ram: 3Gb</span>
                <span class="list-info">Rom: 64Gb</span>
                <span class="list-info">Khe sim: 1</span>
                <span class="list-info">Pin: 2500mah</span>
                <span class="list-info">OS: IOS 13</span>
            </div>
        </div>
        <div class="col-2s">
            <div class="mobile-phone">
                <img src="DiDongZin/imagePhone/note-10-lite-trang.png" alt="note10lite">
                <h2 class="name">Samsung Note 10 Lite 8Gb/128Gb Chính Hãng</h2>
                <span class="price">10.190.000 VND</span>
            </div>
            <div class="hidden-info">
                <h2 class="name">Samsung Note 10 Lite 8Gb/128Gb Chính Hãng</h2>
                <span class="price">10.190.000 VND</span>
                <span class="list-info">Màn hình: 6.5 inch 1231x555</span>
                <span class="list-info">Chipset: Apple A11</span>
                <span class="list-info">Ram: 3Gb</span>
                <span class="list-info">Rom: 64Gb</span>
                <span class="list-info">Khe sim: 1</span>
                <span class="list-info">Pin: 2500mah</span>
                <span class="list-info">OS: IOS 13</span>
            </div>
        </div>
        <div class="col-2s">
            <div class="mobile-phone">
                <img src="DiDongZin/imagePhone/galaxy-a70-xanh.png" alt="galaxya70">
                <h2 class="name">Samsung Galaxy A70 Mới Chính Hãng</h2>
                <span class="price">8.190.000 VND</span>
            </div>
            <div class="hidden-info">
                <h2 class="name">Samsung Galaxy A70 Mới Chính Hãng</h2>
                <span class="price">8.190.000 VND</span>
                <span class="list-info">Màn hình: 6.5 inch 1231x555</span>
                <span class="list-info">Chipset: Apple A11</span>
                <span class="list-info">Ram: 3Gb</span>
                <span class="list-info">Rom: 64Gb</span>
                <span class="list-info">Khe sim: 1</span>
                <span class="list-info">Pin: 2500mah</span>
                <span class="list-info">OS: IOS 13</span>
            </div>
        </div>
        <div class="col-2s">
            <div class="mobile-phone">
                <img src="DiDongZin/imagePhone/iphone11-black-1.png" alt="iphone11">
                <h2 class="name">iPhone 11 64GB Mới Chính Hãng</h2>
                <span class="price">19.190.000 VND</span>
            </div>
            <div class="hidden-info">
                <h2 class="name">iPhone 11 64GB Mới Chính Hãng</h2>
                <span class="price">19.190.000 VND</span>
                <span class="list-info">Màn hình: 6.5 inch 1231x555</span>
                <span class="list-info">Chipset: Apple A11</span>
                <span class="list-info">Ram: 3Gb</span>
                <span class="list-info">Rom: 64Gb</span>
                <span class="list-info">Khe sim: 1</span>
                <span class="list-info">Pin: 2500mah</span>
                <span class="list-info">OS: IOS 13</span>
            </div>
        </div>
        <div class="col-2s">
            <div class="mobile-phone">
                <img src="DiDongZin/imagePhone/iphoneX-space-gray-300x400.png" alt="iphoneX">
                <h2 class="name">iPhoneX 64Gb Mới Chính Hãng</h2>
                <span class="price">11.190.000 VND</span>
            </div>
            <div class="hidden-info">
                <h2 class="name">iPhoneX 64Gb Mới Chính Hãng</h2>
                <span class="price">11.190.000 VND</span>
                <span class="list-info">Màn hình: 6.5 inch 1231x555</span>
                <span class="list-info">Chipset: Apple A11</span>
                <span class="list-info">Ram: 3Gb</span>
                <span class="list-info">Rom: 64Gb</span>
                <span class="list-info">Khe sim: 1</span>
                <span class="list-info">Pin: 2500mah</span>
                <span class="list-info">OS: IOS 13</span>
            </div>
        </div>
        <div class="col-2s">
            <div class="mobile-phone">
                <img src="DiDongZin/imagePhone/s20-hong.png" alt="galaxys20">
                <h2 class="name">Samsung Galaxy S20 8Gb/256Gb Mới Chính Hãng</h2>
                <span class="price">19.490.000 VND</span>
            </div>
            <div class="hidden-info">
                <h2 class="name">Samsung Galaxy S20 8Gb/256Gb Mới Chính Hãng</h2>
                <span class="price">19.490.000 VND</span>
                <span class="list-info">Màn hình: 6.5 inch 1231x555</span>
                <span class="list-info">Chipset: Apple A11</span>
                <span class="list-info">Ram: 3Gb</span>
                <span class="list-info">Rom: 64Gb</span>
                <span class="list-info">Khe sim: 1</span>
                <span class="list-info">Pin: 2500mah</span>
                <span class="list-info">OS: IOS 13</span>
            </div>
        </div>
        <div class="col-2s">
            <div class="mobile-phone">
                <img src="DiDongZin/imagePhone/SAMSUNG-GALAXY-S10-300x400.png" alt="galaxys10">
                <h2 class="name">Samsung Galaxy S10 128Gb Chính Hãng</h2>
                <span class="price">13.990.000 VND</span>
            </div>
            <div class="hidden-info">
                <h2 class="name">Samsung Galaxy S10 128Gb Chính Hãng</h2>
                <span class="price">13.990.000 VND</span>
                <span class="list-info">Màn hình: 6.5 inch 1231x555</span>
                <span class="list-info">Chipset: Apple A11</span>
                <span class="list-info">Ram: 3Gb</span>
                <span class="list-info">Rom: 64Gb</span>
                <span class="list-info">Khe sim: 1</span>
                <span class="list-info">Pin: 2500mah</span>
                <span class="list-info">OS: IOS 13</span>
            </div>
        </div>
        <div class="col-2s">
            <div class="mobile-phone">
                <img src="DiDongZin/imagePhone/note-10-lite-trang.png" alt="note10lite">
                <h2 class="name">Samsung Note 10 Lite 8Gb/128Gb Chính Hãng</h2>
                <span class="price">10.190.000 VND</span>
            </div>
            <div class="hidden-info">
                <h2 class="name">Samsung Note 10 Lite 8Gb/128Gb Chính Hãng</h2>
                <span class="price">10.190.000 VND</span>
                <span class="list-info">Màn hình: 6.5 inch 1231x555</span>
                <span class="list-info">Chipset: Apple A11</span>
                <span class="list-info">Ram: 3Gb</span>
                <span class="list-info">Rom: 64Gb</span>
                <span class="list-info">Khe sim: 1</span>
                <span class="list-info">Pin: 2500mah</span>
                <span class="list-info">OS: IOS 13</span>
            </div>
        </div>
        
    </div>
    <div class="see-more">
        <button class="prm-btn">Xem Thêm</button>
    </div>
    <!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-->
     <h2 class="title">BÁN CHẠY</h2>
     <div class="top-sale row">
         <div class="col-2s">
             <div class="mobile-phone">
                 <img src="DiDongZin/imagePhone/iphone11-black-1.png" alt="iphone11">
                 <h2 class="name">iPhone 11 64GB Mới Chính Hãng</h2>
                 <span class="price">19.190.000 VND</span>
             </div>
             <div class="hidden-info">
                 <h2 class="name">iPhone 11 64GB Mới Chính Hãng</h2>
                 <span class="price">19.190.000 VND</span>
                 <span class="list-info">Màn hình: 6.5 inch 1231x555</span>
                 <span class="list-info">Chipset: Apple A11</span>
                 <span class="list-info">Ram: 3Gb</span>
                 <span class="list-info">Rom: 64Gb</span>
                 <span class="list-info">Khe sim: 1</span>
                 <span class="list-info">Pin: 2500mah</span>
                 <span class="list-info">OS: IOS 13</span>
             </div>
         </div>
         <div class="col-2s">
             <div class="mobile-phone">
                 <img src="DiDongZin/imagePhone/iphoneX-space-gray-300x400.png" alt="iphoneX">
                 <h2 class="name">iPhoneX 64Gb Mới Chính Hãng</h2>
                 <span class="price">11.190.000 VND</span>
             </div>
             <div class="hidden-info">
                 <h2 class="name">iPhoneX 64Gb Mới Chính Hãng</h2>
                 <span class="price">11.190.000 VND</span>
                 <span class="list-info">Màn hình: 6.5 inch 1231x555</span>
                 <span class="list-info">Chipset: Apple A11</span>
                 <span class="list-info">Ram: 3Gb</span>
                 <span class="list-info">Rom: 64Gb</span>
                 <span class="list-info">Khe sim: 1</span>
                 <span class="list-info">Pin: 2500mah</span>
                 <span class="list-info">OS: IOS 13</span>
             </div>
         </div>
         <div class="col-2s">
             <div class="mobile-phone">
                 <img src="DiDongZin/imagePhone/s20-hong.png" alt="galaxys20">
                 <h2 class="name">Samsung Galaxy S20 8Gb/256Gb Mới Chính Hãng</h2>
                 <span class="price">19.490.000 VND</span>
             </div>
             <div class="hidden-info">
                 <h2 class="name">Samsung Galaxy S20 8Gb/256Gb Mới Chính Hãng</h2>
                 <span class="price">19.490.000 VND</span>
                 <span class="list-info">Màn hình: 6.5 inch 1231x555</span>
                 <span class="list-info">Chipset: Apple A11</span>
                 <span class="list-info">Ram: 3Gb</span>
                 <span class="list-info">Rom: 64Gb</span>
                 <span class="list-info">Khe sim: 1</span>
                 <span class="list-info">Pin: 2500mah</span>
                 <span class="list-info">OS: IOS 13</span>
             </div>
         </div>
         <div class="col-2s">
             <div class="mobile-phone">
                 <img src="DiDongZin/imagePhone/SAMSUNG-GALAXY-S10-300x400.png" alt="galaxys10">
                 <h2 class="name">Samsung Galaxy S10 128Gb Chính Hãng</h2>
                 <span class="price">13.990.000 VND</span>
             </div>
             <div class="hidden-info">
                 <h2 class="name">Samsung Galaxy S10 128Gb Chính Hãng</h2>
                 <span class="price">13.990.000 VND</span>
                 <span class="list-info">Màn hình: 6.5 inch 1231x555</span>
                 <span class="list-info">Chipset: Apple A11</span>
                 <span class="list-info">Ram: 3Gb</span>
                 <span class="list-info">Rom: 64Gb</span>
                 <span class="list-info">Khe sim: 1</span>
                 <span class="list-info">Pin: 2500mah</span>
                 <span class="list-info">OS: IOS 13</span>
             </div>
         </div>
         <div class="col-2s">
             <div class="mobile-phone">
                 <img src="DiDongZin/imagePhone/note-10-lite-trang.png" alt="note10lite">
                 <h2 class="name">Samsung Note 10 Lite 8Gb/128Gb Chính Hãng</h2>
                 <span class="price">10.190.000 VND</span>
             </div>
             <div class="hidden-info">
                 <h2 class="name">Samsung Note 10 Lite 8Gb/128Gb Chính Hãng</h2>
                 <span class="price">10.190.000 VND</span>
                 <span class="list-info">Màn hình: 6.5 inch 1231x555</span>
                 <span class="list-info">Chipset: Apple A11</span>
                 <span class="list-info">Ram: 3Gb</span>
                 <span class="list-info">Rom: 64Gb</span>
                 <span class="list-info">Khe sim: 1</span>
                 <span class="list-info">Pin: 2500mah</span>
                 <span class="list-info">OS: IOS 13</span>
             </div>
         </div>
         <div class="col-2s">
             <div class="mobile-phone">
                 <img src="DiDongZin/imagePhone/galaxy-a70-xanh.png" alt="galaxya70">
                 <h2 class="name">Samsung Galaxy A70 Mới Chính Hãng</h2>
                 <span class="price">8.190.000 VND</span>
             </div>
             <div class="hidden-info">
                 <h2 class="name">Samsung Galaxy A70 Mới Chính Hãng</h2>
                 <span class="price">8.190.000 VND</span>
                 <span class="list-info">Màn hình: 6.5 inch 1231x555</span>
                 <span class="list-info">Chipset: Apple A11</span>
                 <span class="list-info">Ram: 3Gb</span>
                 <span class="list-info">Rom: 64Gb</span>
                 <span class="list-info">Khe sim: 1</span>
                 <span class="list-info">Pin: 2500mah</span>
                 <span class="list-info">OS: IOS 13</span>
             </div>
         </div>

     </div>
     <div class="see-more">
         <button class="prm-btn">Xem Thêm</button>
     </div>
      <!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-->
      <h2   class="title">GIẢM GIÁ MẠNH</h2>
      <div class="top-sale row">
          <div class="col-2s">
              <div class="mobile-phone">
                  <img src="DiDongZin/imagePhone/galaxy-a70-xanh.png" alt="galaxya70">
                  <h2 class="name">Samsung Galaxy A70 Mới Chính Hãng</h2>
                  <span class="price">8.190.000 VND</span>
              </div>
              <div class="hidden-info">
                  <h2 class="name">Samsung Galaxy A70 Mới Chính Hãng</h2>
                  <span class="price">8.190.000 VND</span>
                  <span class="list-info">Màn hình: 6.5 inch 1231x555</span>
                  <span class="list-info">Chipset: Apple A11</span>
                  <span class="list-info">Ram: 3Gb</span>
                  <span class="list-info">Rom: 64Gb</span>
                  <span class="list-info">Khe sim: 1</span>
                  <span class="list-info">Pin: 2500mah</span>
                  <span class="list-info">OS: IOS 13</span>
              </div>
          </div>
          
          <div class="col-2s">
              <div class="mobile-phone">
                  <img src="DiDongZin/imagePhone/iphoneX-space-gray-300x400.png" alt="iphoneX">
                  <h2 class="name">iPhoneX 64Gb Mới Chính Hãng</h2>
                  <span class="price">11.190.000 VND</span>
              </div>
              <div class="hidden-info">
                  <h2 class="name">iPhoneX 64Gb Mới Chính Hãng</h2>
                  <span class="price">11.190.000 VND</span>
                  <span class="list-info">Màn hình: 6.5 inch 1231x555</span>
                  <span class="list-info">Chipset: Apple A11</span>
                  <span class="list-info">Ram: 3Gb</span>
                  <span class="list-info">Rom: 64Gb</span>
                  <span class="list-info">Khe sim: 1</span>
                  <span class="list-info">Pin: 2500mah</span>
                  <span class="list-info">OS: IOS 13</span>
              </div>
          </div>
          <div class="col-2s">
              <div class="mobile-phone">
                  <img src="DiDongZin/imagePhone/s20-hong.png" alt="galaxys20">
                  <h2 class="name">Samsung Galaxy S20 8Gb/256Gb Mới Chính Hãng</h2>
                  <span class="price">19.490.000 VND</span>
              </div>
              <div class="hidden-info">
                  <h2 class="name">Samsung Galaxy S20 8Gb/256Gb Mới Chính Hãng</h2>
                  <span class="price">19.490.000 VND</span>
                  <span class="list-info">Màn hình: 6.5 inch 1231x555</span>
                  <span class="list-info">Chipset: Apple A11</span>
                  <span class="list-info">Ram: 3Gb</span>
                  <span class="list-info">Rom: 64Gb</span>
                  <span class="list-info">Khe sim: 1</span>
                  <span class="list-info">Pin: 2500mah</span>
                  <span class="list-info">OS: IOS 13</span>
              </div>
          </div>
          <div class="col-2s">
              <div class="mobile-phone">
                  <img src="DiDongZin/imagePhone/iphone11-black-1.png" alt="iphone11">
                  <h2 class="name">iPhone 11 64GB Mới Chính Hãng</h2>
                  <span class="price">19.190.000 VND</span>
              </div>
              <div class="hidden-info">
                  <h2 class="name">iPhone 11 64GB Mới Chính Hãng</h2>
                  <span class="price">19.190.000 VND</span>
                  <span class="list-info">Màn hình: 6.5 inch 1231x555</span>
                  <span class="list-info">Chipset: Apple A11</span>
                  <span class="list-info">Ram: 3Gb</span>
                  <span class="list-info">Rom: 64Gb</span>
                  <span class="list-info">Khe sim: 1</span>
                  <span class="list-info">Pin: 2500mah</span>
                  <span class="list-info">OS: IOS 13</span>
              </div>
          </div>
          <div class="col-2s">
              <div class="mobile-phone">
                  <img src="DiDongZin/imagePhone/SAMSUNG-GALAXY-S10-300x400.png" alt="galaxys10">
                  <h2 class="name">Samsung Galaxy S10 128Gb Chính Hãng</h2>
                  <span class="price">13.990.000 VND</span>
              </div>
              <div class="hidden-info">
                  <h2 class="name">Samsung Galaxy S10 128Gb Chính Hãng</h2>
                  <span class="price">13.990.000 VND</span>
                  <span class="list-info">Màn hình: 6.5 inch 1231x555</span>
                  <span class="list-info">Chipset: Apple A11</span>
                  <span class="list-info">Ram: 3Gb</span>
                  <span class="list-info">Rom: 64Gb</span>
                  <span class="list-info">Khe sim: 1</span>
                  <span class="list-info">Pin: 2500mah</span>
                  <span class="list-info">OS: IOS 13</span>
              </div>
          </div>
          <div class="col-2s">
              <div class="mobile-phone">
                  <img src="DiDongZin/imagePhone/note-10-lite-trang.png" alt="note10lite">
                  <h2 class="name">Samsung Note 10 Lite 8Gb/128Gb Chính Hãng</h2>
                  <span class="price">10.190.000 VND</span>
              </div>
              <div class="hidden-info">
                  <h2 class="name">Samsung Note 10 Lite 8Gb/128Gb Chính Hãng</h2>
                  <span class="price">10.190.000 VND</span>
                  <span class="list-info">Màn hình: 6.5 inch 1231x555</span>
                  <span class="list-info">Chipset: Apple A11</span>
                  <span class="list-info">Ram: 3Gb</span>
                  <span class="list-info">Rom: 64Gb</span>
                  <span class="list-info">Khe sim: 1</span>
                  <span class="list-info">Pin: 2500mah</span>
                  <span class="list-info">OS: IOS 13</span>
              </div>
          </div>
          
      </div>
      <div class="see-more">
          <button class="prm-btn">Xem Thêm</button>
      </div>
</div>

@endsection