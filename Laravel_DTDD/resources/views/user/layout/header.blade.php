<div class="container nav-top">
    <!-- Rounded switch -->
    <label class="switch">
        <input type="checkbox" id="switch1">
        <span class="slider round"></span>
    </label>
    <img id="show_company" src="DiDongZin/assets/img/menu_100px.png" alt="menu" onclick="show_company()">
    <div class="row">
        
        <div class="col-4" onclick="loadPage('TrangChu')">
            <img src="DiDongZin/assets/img/logo-min.png" alt="logo" />
            <h2 class="animated infinite pulse">DIDONGZIN</h2>
        </div>
        <div class="search-bar col-4">
            <input id ="text_search"type="text" placeholder="Tìm sản phẩm" onkeyup="search_phone(this.value)"/>
            <img src="DiDongZin/assets/img/search_30px.png" alt="icon-search">
            <div id="search-results">
                <div class="phone-results">
                    <img src="DiDongZin/imagePhone/iphone11-black-1.png" alt="iphone 11"/>
                    <h2 class="name">iPhone11 64Gb Mới Chính Hãng</h2>
                    <span class="price">19.190.000 VND</span>
                </div>
                <div class="phone-results">
                    <img src="DiDongZin/imagePhone/iphoneX-space-gray-300x400.png" alt="iphone X" />
                    <h2 class="name">iPhoneX 64Gb Mới Chính Hãng</h2>
                    <span class="price">11.190.000 VND</span>
                </div>
            </div>
        </div>
        <div class="col-4 right-nav-bar">
            <a id="cart-btn">
                <img src="DiDongZin/assets/img/shopping_cart_100px.png" alt="cart" />
                <span class="badge">3</span>
                <p>Giỏ hàng</p>
                <div id="cart">
                    <div class="phone-results">
                        <img src="DiDongZin/imagePhone/iphone11-black-1.png" alt="iphone 11" />
                        <h2 class="name">iPhone11 64Gb Mới Chính Hãng</h2>
                        <span class="price">19.190.000 VND</span>
                        <span class="count">X 1</span>
                    </div>
                    <div class="phone-results">
                        <img src="DiDongZin/imagePhone/iphoneX-space-gray-300x400.png" alt="iphone X" />
                        <h2 class="name">iPhoneX 64Gb Mới Chính Hãng</h2>
                        <span class="price">11.190.000 VND</span>
                        <span class="count">X 2</span>
                    </div>
                </div>
            </a>
            <a id="myBtn">
                @if (Auth::check())
            <img src="DiDongZin/avatar/{{ Auth::user()->URL_Avatar }}" alt="user" />
                    <p>{{ Auth::user()->Ho_va_ten_lot }} {{ Auth::user()->Ten }}</p>
                    <div class="user-menu">
                        <img src="DiDongZin/avatar/{{ Auth::user()->URL_Avatar }}" alt="user" />
                        <img src="DiDongZin/assets/img/camera_50px.png" alt="update-avatar" id="update_avatar">
                        <h2>{{ Auth::user()->Ho_va_ten_lot }} {{ Auth::user()->Ten }}</h2>
                        <p>{{ Auth::user()->Username }}</p>
                        <button onclick="loadPage('taikhoan/ThongTinCaNhan')">Quản lý tài khoản</button>
                        <button onclick="DangXuat()">Đăng Xuất</button>
                    </div>
                @else
                    <img src="DiDongZin/assets/img/male_user_100px.png" alt="user" />
                    <p>Đăng nhập</p>
                @endif
            </a>
        </div>
    </div>

</div>
<div id="company">
    <img src="DiDongZin/assets/img/back_30px.png" alt="back" onclick="hide_company()">
    <a href="#">APPLE</a>
    <a href="#">SAMSUNG</a>
    <a href="#">XIAOMI</a>
    <a href="#">HAWAII</a>
    <a href="#">NOKIA</a>
    <a href="#">REALME</a>
    <a href="#">VSMART</a>
</div>

@section('script')
    <script>
        function DangXuat()
        {
            window.location.href = "logout";
        }    
    </script>   
@endsection