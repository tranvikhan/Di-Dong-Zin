<!-- LEFT MENU..................................................................................-->
<div id="left-menu">
    <ul>
        <li class="tablinks " id="thongKeMenu" onclick="loadPage('admin/thongke')">
            <img src="DiDongZin/assets/img/home_50px.png" alt="logo">
            <p>THỐNG KÊ</p>
        </li>
        <li class="tablinks" id="dienThoaiMenu" onclick="loadPage('admin/dienthoai/danhsach')">
            <img src="DiDongZin/assets/img/smartphone_tablet_50px.png" alt="logo">
            <p>Điện thoại</p>
        </li>
        <li class="tablinks" id="hangDienThoaiMenu" onclick="loadPage('admin/hangdienthoai/danhsach')">
            <img src="DiDongZin/assets/img/department_50px.png" alt="logo">
            <p>Hãng điện thoại</p>
        </li>
        <li class="tablinks" id="donHangMenu" onclick="loadPage('admin/donhang/danhsach')">
            <img src="DiDongZin/assets/img/purchase_order_50px.png" alt="logo">
            <p>Đơn hàng</p>
            <span class="sodonmoi">{{ $sodonhang }}</span>
        </li>
        <li class="tablinks" id="hoaDonMenu" onclick="loadPage('admin/hoadon/danhsach')">
            <img src="DiDongZin/assets/img/receipt_50px.png" alt="logo">
            <p>Hóa đơn</p>
        </li>
        <li class="tablinks" id="thanhVienMenu" onclick="loadPage('admin/thanhvien/danhsach')">
            <img src="DiDongZin/assets/img/member_50px.png" alt="logo">
            <p>Thành viên</p>
        </li>
        <li class="tablinks" id="trangMenu" onclick="loadPage('admin/trang')">
            <img src="DiDongZin/assets/img/page_50px.png" alt="logo">
            <p>Trang</p>
        </li>
        <li class="tablinks" id="caiDatMenu" onclick="loadPage('admin/caidat')">
            <img src="DiDongZin/assets/img/settings_50px.png" alt="logo" id="ic-caidat">
            <p>Cài đặt</p>
        </li>
        <li class="tablinks" id="dangXuatMenu">
            <img src="DiDongZin/assets/img/login_rounded_50px.png" alt="logo">
            <p>Đăng xuất</p>
        </li>
    </ul>
</div>
{{-- ........  class="active" để xác định đối tượng <li> đang hoạt động ...............--}}