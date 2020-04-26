@extends('user.layout.index')

@section('content')

<div class="container page-body">
    <div class="row">
        
        @include('user.layout.menu_QuanLy')

        <div class="col-10 user-tab-content">
            <h3 class="title">Tài khoản</h3>
            <div class="row user-thongtin">
                <form method="POST" action="#" >
                    <div class="col-12">
                        <table>
                            <tr>
                                <th>
                                    Mã tài khoản
                                </th>
                                <td>
                                    <input type="text" disabled="true" value="001" name="id">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Tên đăng nhập
                                </th>
                                <td>
                                    <input type="text" disabled value="tranvikhan" name="username">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Mật khẩu hiện tại
                                </th>
                                <td>
                                    <input type="password" name="Password">
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
                                    <input type="password" name="newRePassword">
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