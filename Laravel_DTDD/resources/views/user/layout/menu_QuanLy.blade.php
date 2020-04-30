<div class="col-2 user-tab-menu">
    <div>
        <a href="taikhoan/ThongTinCaNhan" class="" id="thongTinMenu">
            <img src="DiDongZin/assets/img/male_user_50px.png">
            <span>Thông tin</span>
        </a>
        <a href="taikhoan/CapNhatTaiKhoan" class="" id="taiKhoanMenu">
            <img src="DiDongZin/assets/img/privacy_50px.png">
            <span>Tài khoản</span>
        </a>
        <a href="taikhoan/DonHang" class="" id="donHangMenu">
            <img src="DiDongZin/assets/img/purchase_order_50px.png">
            <span>Đơn hàng</span>
        </a>
        <a href="taikhoan/CaiDat" class="" id="caiDatMenu">
            <img src="DiDongZin/assets/img/settings_50px.png">
            <span>Cài đặt</span>
        </a>
        <a href="logout">
            <img src="DiDongZin/assets/img/login_rounded_50px.png">
            <span>Đăng xuất</span>
        </a>
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