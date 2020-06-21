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
                        <a onclick="SuaHang('{{ $row->Ma_hang_dien_thoai }}', '{{ $row->Ten_hang }}', '{{ $row->Quoc_gia }}')">Sửa</a>
                        
                        <img src="DiDongZin/assets/img/minus_30px.png">
                        <a onclick="return XoaHang('{{ $row->Ten_hang }}', '{{ $row->ToDienThoaiDiDong->count() }}')" href="admin/hangdienthoai/xoa/{{ $row->Ma_hang_dien_thoai }}">Xóa</a>
                    </div>
                </div>
            @endforeach

            {{-- START -- BẮT LỖI ĐƯỢC GỬI VỀ TỪ CONTROLLER ............................................--}}
            <?php  $str = ""; ?>
            @if (count($errors)>0)
                @foreach ($errors->all() as $err)
                    <?php
                        ($str == "") ? $str .= $err : $str .= '\\n'.$err;
                    ?>
                @endforeach
                <?php
                    echo '<script>alert("' . $str . '")</script>';
                ?>
            @endif
            {{-- END -- BẮT LỖI ĐƯỢC GỬI VỀ TỪ CONTROLLER ............................................--}}

            <div class="col-2 col-2s hangdt" id="btn-themhangdt">
                <img src="DiDongZin/assets/img/plus_30px.png">
                <div class="hangdt-show">
                    <h2>Thêm mới</h2>
                </div>
            </div>
            <div class="col-4 hangdt" id="themhangdt">
                <div class="hangDtMoi">
                    <span class="close" onclick="closeThemHang()">&times;</span>
                    <form method="POST" action="admin/hangdienthoai/them">
                        {{ csrf_field() }}

                        @if (session('thongbaoThem'))
                            <?php
                                echo '<script>alert("'. session('thongbaoThem') .'");</script>';
                            ?>
                        @endif
                        @if (session('thongbaoXoa'))
                            <?php
                                echo '<script>alert("'. session('thongbaoXoa') .'");</script>';
                            ?>
                        @endif

                        <table>
                            <tr>
                                <th>Tên hãng:</th>
                                <td><input type="text" name="tenThem"></td>
                            </tr>
                            <tr>
                                <th>Quốc gia:</th>
                                <td><input type="text" name="quocGiaThem"></td>
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
                    <form method="POST" action="admin/hangdienthoai/sua">
                        {{ csrf_field() }}

                        @if (session('thongbaoSua'))
                            <?php
                                echo '<script>alert("'. session('thongbaoSua') .'");</script>';
                            ?>
                        @endif

                        <table>
                            <tr>
                                <th>Mã hãng:</th>
                                <td><input id="IdHangDt" name="idSua" type="text" readonly></td>
                            </tr>
                            <tr>
                                <th>Tên hãng:</th>
                                <td><input id="TenHangDT" name="tenSua" type="text"></td>
                            </tr>
                            <tr>
                                <th>Quốc gia:</th>
                                <td><input id="QuocGiaHangDT" name="quocGiaSua" type="text"></td>
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
@endsection

{{-- SECTION 'SCRIPT' ................................................ --}}

@section('script')
    <script src="DiDongZin/assets/js/_hangdienthoai.js"></script>
    <script>
        window.onload = function()
        {
            document.getElementById('hangDienThoaiMenu').classList.add('active');
        }
    </script>    
@endsection