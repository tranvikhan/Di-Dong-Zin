@extends('admin.layout.index')

@section('content')

<!-- NOI DUNG CHINH ..................................................................................-->
<div class="content">
    <div id="thanhvien" class="tabcontent">
        <h2>QUẢN LÝ THÀNH VIÊN</h2>
        <input type="text" placeholder="Nhập mã hoặc tên thành viên" id="timKiem">
        <button class="btnThemdienthoai" id="btnTimKiem"><img src="DiDongZin/assets/img/search_30_ligghtpx.png">Tìm thành viên</button>
        <div class="row" id="noiDung">
            @foreach ($thanhVien as $tv)
                <div class="col-4 col-4s cart-thanhvien">
                    <div class="row">
                        <img src="DiDongZin/avatar/{{ $tv->URL_Avatar }}" alt="avatar" class="col-5"> 
                        <img src="DiDongZin/assets/img/slider_50px.png" alt="setting" class="sua_thanhvien" 
                            onclick="XemThanhVien('{{ $tv->URL_Avatar }}', '{{ $tv->Ma_tai_khoan }}', '{{ $tv->Tai_khoan_admin }}', '{{ $tv->Username }}', '{{ $tv->Ho_va_ten_lot }} {{ $tv->Ten }}', '{{ $tv->Gioi_tinh }}', '{{ $tv->Ngay_sinh }}', '{{ $tv->So_dien_thoai }}', '{{ $tv->Dia_chi }}')">
                        
                        <div class="col-7">
                            <h3>{{ $tv->Ho_va_ten_lot }} {{ $tv->Ten }}</h3>
                            <p>MS: {{ $tv->Ma_tai_khoan }}</p>
                        </div>
                    </div>
                </div>    
            @endforeach
        </div>
    </div>
</div>

<div id="myModal2" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <img src="DiDongZin/avatar/avatar-cartoon-superman-png_244033.jpg" alt="avatar" id="form-userAvatar">
        <form action="admin/thanhvien/SuaThanhVien" method="post">
            {{ csrf_field() }}

            @if (session('thongbao'))
                <?php
                    echo '<script>alert("'. session('thongbao') .'")</script>'
                ?>
            @endif
            <table>
                <tr>
                    <th>Mã tài khoản:</th>
                    <td id="form-userId" name="userID"></td>
                    <input type="hidden" name="inputUserID" id="inputUserID">
                </tr>
                <tr>
                    <th>Loại tài khoản:</th>
                    <td>
                        <select name="loaitaikhoan" id="form-userType">
                            <option value="1">Admin</option>
                            <option value="0">Thành Viên</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Tên đăng nhập:</th>
                    <td id="form-username"></td>
                </tr>
                <tr>
                    <th>Họ và tên:</th>
                    <td id="form-userFullName"></td>
                </tr>
                <tr>
                    <th>Giới tính:</th>
                    <td id="form-userSex"></td>
                </tr>
                <tr>
                    <th>Ngày sinh:</th>
                    <td id="form-userDate"></td>
                </tr>
                <tr>
                    <th>Số điện thoại:</th>
                    <td id="form-userPhone"></td>
                </tr>
                <tr>
                    <th>Địa chỉ:</th>
                    <td id="form-userAddress"></td>
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
    <script>
        window.onload = function(){
            document.getElementById('thanhVienMenu').classList.add('active');
        }

        function XemThanhVien(avatar, id, loaiDangNhap, tenDangNhap, hoTen, gioiTinh, ngaySinh, sdt, diaChi) {
            modal.style.display = "block";
            document.getElementById("form-userAvatar").src = 'DiDongZin/avatar/'+ avatar;
            document.getElementById("form-userId").innerHTML = id;
            document.getElementById("inputUserID").value = id;
            document.getElementById("form-userType").value = loaiDangNhap;
            document.getElementById("form-username").innerHTML = tenDangNhap;
            document.getElementById("form-userFullName").innerHTML = hoTen;
            if(gioiTinh == 1)
            {
                document.getElementById("form-userSex").innerHTML = "Nam";
            }
            else
            {
                document.getElementById("form-userSex").innerHTML = "Nữ";
            }
            document.getElementById("form-userDate").innerHTML = ngaySinh;
            document.getElementById("form-userPhone").innerHTML = sdt;
            document.getElementById("form-userAddress").innerHTML = diaChi;
        }

        $(document).ready(function(){
            $("#btnTimKiem").click(function(){
                noiDung = document.getElementById("timKiem").value;

                $.get('admin/thanhvien/TimThanhVienAjax/'+ noiDung, function($data){
                    if( $data == '0')
                    {
                        alert('Không tìm thấy thành viên với từ khóa: '+noiDung);
                    }
                    else
                    {
                        $('#noiDung').html($data);
                    }                    
                });
            });
        });
    </script>
@endsection