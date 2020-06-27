@extends('user.layout.index')

@section('content')

<div class="container page-body">
    <div class="row">
        
        @include('user.layout.menu_QuanLy')

        <div class="col-10 user-tab-content">
            <h3 class="title">Thông tin thành viên</h3>
            <div class="row user-thongtin">
                <form method="POST" action="taikhoan/CapNhatThongTin" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    
                    @if (count($errors) > 0)
                        <?php $loi = "" ?>
                        @foreach ($errors->all() as $err)
                            <?php
                                if($loi == ""){
                                    $loi .= $err;
                                }else{
                                    $loi .= '\\n'. $err;
                                }
                            ?>
                        @endforeach
                        <?php echo '<script>alert("'. $loi .'")</script>' ?>
                    @endif

                    @if (session('thongBaoCapNhat'))
                        <?php echo '<script>alert("'. session('thongBaoCapNhat') .'")</script>' ?>
                    @endif

                    <div class="col-4">
                        <img 
                            @if (Auth::user()->URL_Avatar == null)
                                src="DiDongZin/avatar/plus_150px.png"
                            @else
                                src="DiDongZin/avatar/{{ Auth::user()->URL_Avatar }}"    
                            @endif
                        id="img_avatar">
                        <input type="file" name="avatar" id="input_avatar">
                        <p>Ảnh đại diện</p>
                    </div>
                    <div class="col-8">
                        <table>
                            <tr>
                                <th>
                                    Họ và tên
                                </th>
                                <td>
                                    <input type="text" name="fullname" value="{{ Auth::user()->Ho_va_ten_lot }} {{ Auth::user()->Ten }}">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Giới tính
                                </th>
                                <td>
                                    <label class="myRadio">Nam
                                        <input type="radio" name="sex" value="1" checked>
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="myRadio">Nữ
                                        <input type="radio" name="sex" value="0" 
                                            @if (Auth::user()->Gioi_tinh == 0)
                                                checked
                                            @endif
                                        >
                                        <span class="checkmark"></span>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Ngày sinh
                                </th>
                                <td>
                                    <input type="date" name="dateOfBirth" value="{{ Auth::user()->Ngay_sinh }}">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Số điện thoại
                                </th>
                                <td>
                                    <input type="tel" name="phonenumber" value="{{ Auth::user()->So_dien_thoai }}" id="sdt">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Địa chỉ
                                </th>
                                <td>
                                    <input type="text" name="address" value="{{ Auth::user()->Dia_chi }}">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="submit" value="Cập nhật" onclick="return KiemTraSDT()">
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    <script src="DiDongZin/assets/js/user_manage.js"></script>
    <script>
        window.onload = function(){
            document.getElementById('thongTinMenu').classList.add('active');
        }

        function KiemTraSDT()
        {
            sdt = document.getElementById('sdt').value;

            // Cắt tất cả khoảng trắng
            sdt = sdt.replace(/ /g, '');

            // Tạo regexr cho 2 trường hợp sdt có và không có dấu +
            reg1 = /^\+\d{11,12}$/;
            reg2 = /^\d{10,11}$/;
            if(reg1.test(sdt) || reg2.test(sdt)){
                return true;
            }
            else{
                alert("Số điện thoại không đúng, vui lòng xem lại");
                return false;
            }
        }
    </script>
@endsection