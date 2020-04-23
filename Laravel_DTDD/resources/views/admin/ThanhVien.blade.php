@extends('admin.layout.index')

@section('content')

<!-- NOI DUNG CHINH ..................................................................................-->
<div class="content">
    <div id="thanhvien" class="tabcontent">
        <h2>QUẢN LÝ THÀNH VIÊN</h2>
        <input type="text" placeholder="Nhập mã hoặc tên thành viên">
        <button class="btnThemdienthoai"><img src="DiDongZin/assets/img/search_30_ligghtpx.png">Tìm thành viên</button>
        <div class="row">
            <div class="col-4 col-4s cart-thanhvien">
                <div class="row">
                    <img src="DiDongZin/avatar/avatar-cartoon-superman-png_244033.jpg" alt="avatar" class="col-5"> 
                    <img src="DiDongZin/assets/img/slider_50px.png" alt="setting" class="sua_thanhvien" 
                        onclick="suathanhvien('001')">
                    
                    <div class="col-7">
                        <h3>Trần Vi Khan</h3>
                        <p>MS: 001</p>
                    </div>
                </div>
            </div>
            <div class="col-4 col-4s cart-thanhvien">
                <div class="row">
                    <img src="DiDongZin/avatar/avatar-doi-tren-facebook-1.jpg" alt="avatar" class="col-5">
                    <img src="DiDongZin/assets/img/slider_50px.png" alt="setting" class="sua_thanhvien"
                        onclick="suathanhvien('002')">
                    <div class="col-7">
                        <h3>Nguyễn Tấn Thịnh</h3>
                        <p>MS: 002</p>
                    </div>
                </div>
            </div>
            <div class="col-4 col-4s cart-thanhvien">
                <div class="row">
                    <img src="DiDongZin/avatar/fc5162103264ed63d5b5a008b0872e5b.jpg" alt="avatar" class="col-5">
                    <img src="DiDongZin/assets/img/slider_50px.png" alt="setting" class="sua_thanhvien"
                        onclick="suathanhvien('003')">
                    <div class="col-7">
                        <h3>Nguyễn Văn A</h3>
                        <p>MS: 003</p>
                    </div>
                </div>
            </div>
            <div class="col-4 col-4s cart-thanhvien">
                <div class="row">
                    <img src="DiDongZin/avatar/sieu-nhan-cuu-the-gioi.jpg" alt="avatar" class="col-5">
                    <img src="DiDongZin/assets/img/slider_50px.png" alt="setting" class="sua_thanhvien"
                        onclick="suathanhvien('004')">
                    <div class="col-7">
                        <h3>Nguyễn Trần Thị Nở</h3>
                        <p>MS: 004</p>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>
<div id="myModal2" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <img src="DiDongZin/avatar/avatar-cartoon-superman-png_244033.jpg" alt="avatar" id="form-userAvatar">
        <form action="#" method="POST">
            <table>
                <tr>
                    <th>Mã tài khoản:</th>
                    <td id="form-userId">001</td>
                </tr>
                <tr>
                    <th>Loại tài khoản:</th>
                    <td>
                        <select name="loaitaikhoan" id="form-userType">
                            <option value="Admin">Admin</option>
                            <option value="Thành Viên">Thành Viên</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Tên đăng nhập:</th>
                    <td id="form-username">tranvikhan</td>
                </tr>
                <tr>
                    <th>Họ và tên:</th>
                    <td id="form-userFullName">Trần Vi Khan</td>
                </tr>
                <tr>
                    <th>Giới tính:</th>
                    <td id="form-userSex">Nam</td>
                </tr>
                <tr>
                    <th>Ngày sinh:</th>
                    <td id="form-userDate">06/06/1999</td>
                </tr>
                <tr>
                    <th>Số điện thoại:</th>
                    <td id="form-userPhone">0974184717</td>
                </tr>
                <tr>
                    <th>Địa chỉ:</th>
                    <td id="form-userAddress">Ấp 8 xã Lương Nghĩa, huyện Long Mỹ, tỉnh Hậu Giang</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" value="Lưu">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

@endsection

@section('script')
    <script src="DiDongZin/assets/js/_thanhvien.js"></script>
@endsection