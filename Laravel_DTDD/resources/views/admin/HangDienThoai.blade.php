@extends('admin.layout.index')

@section('content')

<!-- NOI DUNG CHINH ..................................................................................-->
<div class="content">
    <div id="hangdienthoai" class="tabcontent">
        <h2>QUẢN LÝ HÃNG ĐIỆN THOẠI</h2>
        <div class="row">
            
            @foreach ($hangDT as $row)
                <div class="col-2 col-2s hangdt">
                    <div class="hangdt-show">
                        <h2>{{ $row->Ten_hang }}</h2>
                    </div>
                    <div class="hangdt-hide">
                        <p>Mã hãng: {{ $row->Ma_hang_dien_thoai }}</p>
                        <p>Tên hãng: {{ $row->Ten_hang }}</p>
                        <p>Quốc gia: {{ $row->Quoc_gia }}</p>
                        <p>Số sản phẩm: {{ $row->ToDienThoaiDiDong->count() }}</p>
                        <img src="DiDongZin/assets/img/maintenance_30px.png">
                        <a onclick="SuaHang('{{ $row->Ma_hang_dien_thoai }}')">Sửa</a>
                        <img src="DiDongZin/assets/img/minus_30px.png">
                        <a href="#">Xóa</a>
                    </div>
                </div>
            @endforeach

            <div class="col-2 col-2s hangdt" id="btn-themhangdt">
                <img src="DiDongZin/assets/img/plus_30px.png">
                <div class="hangdt-show">
                    <h2>Thêm mới</h2>
                </div>
            </div>
            <div class="col-4 hangdt" id="themhangdt">
                <div class="hangDtMoi">
                    <span class="close" onclick="closeThemHang()">&times;</span>
                    <form method="POST" action="#">
                        <table>
                            <tr>
                                <th>Tên hãng:</th>
                                <td><input type="text"></td>
                            </tr>
                            <tr>
                                <th>Quốc gia:</th>
                                <td><input type="text"></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="submit" value="Thêm">
                                </td>
                            </tr>

                        </table>
                    </form>
                </div>
            </div>
            <div class="col-4 hangdt" id="suahangdt">
                <div class="hangDtMoi">
                    <span class="close" onclick="closeSuaHang()">&times;</span>
                    <form method="POST" action="#">
                        <table>
                            <tr>
                                <th>Mã hãng:</th>
                                <td><input id="IdHangDt" type="text" disabled></td>
                            </tr>
                            <tr>
                                <th>Tên hãng:</th>
                                <td><input type="text"></td>
                            </tr>
                            <tr>
                                <th>Quốc gia:</th>
                                <td><input type="text"></td>
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
        </div>
    </div>
</div>
<script src="DiDongZin/assets/js/_hangdienthoai.js"></script>

@endsection