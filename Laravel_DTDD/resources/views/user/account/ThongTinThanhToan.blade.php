@extends('user.layout.index')

@section('content')

<div class="container page-body">
    <div class="row">
        
        @include('user.layout.menu_QuanLy')

        <div class="col-10 user-tab-content">
            <h3 class="title">Thông tin thanh toán</h3>
            <div class="row user-thongtin">
                <form method="POST" action="#" >
                    <div class="col-12">
                        <table>
                            <tr class="hint-thanhtoan">
                                <th>
                                    Tên tài khoản ngân hàng
                                </th>
                                <td>
                                    <input type="text" placeholder="Trần Vi Khan" name="tenChuThe">
                                </td>
                            </tr>
                            <tr class="hint-thanhtoan">
                                <th>
                                    Số thẻ
                                </th>
                                <td>
                                    <input type="text" placeholder="000-000-000-000" name="soThe">
                                </td>
                            </tr>
                            <tr class="hint-thanhtoan">
                                <th>
                                    CVV/CVV2
                                </th>
                                <td>
                                    <input type="text" placeholder="" name="CVV">
                                </td>
                            </tr>
                            <tr class="hint-thanhtoan">
                                <th>
                                    Ngày hết hạn
                                </th>
                                <td>
                                    <select name="thangHetHan">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                        <option>6</option>
                                        <option>7</option>
                                        <option>8</option>
                                        <option>9</option>
                                        <option>10</option>
                                        <option>11</option>
                                        <option>12</option>
                                    </select>
                                    <select name="namHetHan">
                                        <option>2020</option>
                                        <option>2021</option>
                                        <option>2022</option>
                                        <option>2023</option>
                                        <option>2024</option>
                                    </select>
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
            document.getElementById('thanhToanMenu').classList.add('active');
        }
    </script>
@endsection