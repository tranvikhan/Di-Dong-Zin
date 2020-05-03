@extends('user.layout.index')

@section('content')

<div class="container page-body">
    <div class="row">
        
        @include('user.layout.menu_QuanLy')

        <div class="col-10 user-tab-content">
            <h3 class="title">Tài khoản</h3>
            <div class="row user-thongtin">
                <form method="POST" action="taikhoan/CapNhatThongTinDangNhap" >
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
                    
                    <div class="col-12">
                        <table>
                            <tr>
                                <th>
                                    Mã tài khoản
                                </th>
                                <td>
                                    <input type="text" readonly value="{{ Auth::user()->Ma_tai_khoan }}" name="id">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Tên đăng nhập
                                </th>
                                <td>
                                    <input type="text" readonly value="{{ Auth::user()->Username }}" name="username">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Mật khẩu hiện tại
                                </th>
                                <td>
                                    <input type="password" name="password">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Mật khẩu mới
                                </th>
                                <td>
                                    <input type="password" name="newPassword">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Nhập lại mật khẩu mới
                                </th>
                                <td>
                                    <input type="password" name="reNewPassword">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="submit" value="Cập nhật">
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
            document.getElementById('taiKhoanMenu').classList.add('active');
        }
    </script>
@endsection