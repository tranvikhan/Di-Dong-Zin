@extends('admin.layout.index')

@section('content')

<!-- NOI DUNG CHINH ..................................................................................-->
<div class="content">
    <div id="dienthoai" class="tabcontent" >
        <h2>QUẢN LÝ ĐIỆN THOẠI</h2>
        <button onclick="loadPage('admin/dienthoai/them')" class="btnThemdienthoai">
            <img src="DiDongZin/assets/img/plus_math_30px.png">Thêm điện thoại
        </button>
        <div class="action-bar row">
            <div class="g-tacvu col-2">
                <select>
                    <option>Tác vụ</option>
                    <option>Chỉnh sửa</option>
                    <option>Xóa</option>
                </select>
                <button>Áp dụng</button>
            </div>
            <div class="g-chonloc col-7">
                <select>
                    <option>Hãng điện thoại</option>
                    <option>Apple</option>
                    <option>Samsung</option>
                    <option>Xiaomi</option>
                    <option>Hawaii</option>
                    <option>Nokia</option>
                    <option>Realme</option>
                    <option>Vsmart</option>
                </select>
                <select>
                    <option>Mức giá</option>
                    <option>Dưới 2 triệu</option>
                    <option>2 triệu - 5 triệu</option>
                    <option>5 triệu-10 triệu</option>
                    <option>10 triệu-15 triệu</option>
                    <option>Trên 15 triệu</option>
                </select>
                <select>
                    <option>Sắp xếp theo</option>
                    <option>Giá cao</option>
                    <option>Giá thấp</option>
                </select>
                <button>Lọc sản phẩm</button>

            </div>
            <div class="g-timkiem col-3">
                <input type="text" placeholder="Nhập tên hoặc mã điện thoại">
                <button>Tìm kiếm</button>
            </div>
        </div>
        <table>
            <tr>
                <th>
                    <label class="mycheckbox">
                        <input type="checkbox" id="checkAll">
                        <span class="checkmark"></span>
                    </label>
                </th>
                <th>
                    Ảnh
                </th>
                <th>
                    Tên
                </th>
                <th>
                    Mã
                </th>
                <th>
                    Giá
                </th>
                <th>
                    Giá khuyến mãi
                </th>
                <th>
                    Hãng
                </th>
                
            </tr>
            @foreach ($dienthoai as $dt)
                @if ($dt->Dang_ban == 1)
                    <tr>
                        <td>
                            <label class="mycheckbox">
                                <input type="checkbox" name="check_phone[]">
                                <span class="checkmark"></span>
                            </label>
                        </td>
                        <td>
                            <img src="DiDongZin/imagePhone/{{ $dt->Hinh_anh }}">
                        </td>
                        <td>
                            {{ $dt->Ten_dien_thoai }}
                            <div class="mini-action">
                                <a href="#">Xem</a>
                                <a onclick="loadPage('admin/dienthoai/sua/{{ $dt->Ma_dien_thoai }}')">Chỉnh sửa</a>
                                <a href="admin/dienthoai/xoa/{{ $dt->Ma_dien_thoai }}" onclick="return XoaDienThoai('{{ $dt->Ten_dien_thoai }}')">Xóa</a>
                            </div>
                        </td>
                        <td>
                            {{ $dt->Ma_dien_thoai }}
                        </td>
                        <td>
                            {{ $dt->ToGiaBan->last()->Gia }}
                        </td>
                        <td>
                            <?php
                                //Lấy ngày hiện tại
                                date_default_timezone_set('Asia/Ho_Chi_Minh');
                                $today = date('Y-m-d');

                                //Lấy giá điện thoại
                                $gia = $dt->ToGiaBan->last()->Gia;

                                //Lấy ra ngày bắt đầu và ngày kết thúc khuyến mãi
                                $startDay = 0;
                                $endDay = 0;    //Ngày khuyến mãi kết thúc
                                $percent = 0;   //Phần tram khuyến mãi của chương trình này
                                $khuyenMai = $dt->ToKhuyenMai->last();
                                if($khuyenMai !== null)
                                {
                                    $startDay = $khuyenMai->Tu_ngay;
                                    $endDay = $khuyenMai->Den_ngay;
                                    $percent = $khuyenMai->Phan_tram_khuyen_mai;
                                }
                            ?>
                            @if ($startDay<=$today && $today <= $endDay)
                                {{ $gia*(1-($percent/100)) }}
                            @else
                                {{ "--" }}
                            @endif
                        </td>
                        <td>
                            {{ $dt->ToHangDienThoaiDiDong->Ten_hang }}
                        </td>
                        
                    </tr>    
                @endif
                    
            @endforeach
        </table>
        @if (session('thongbao'))
            <?php
                echo '<script>alert("'. session('thongbao') .'")</script>';
            ?>
        @endif
    </div>
</div>

@endsection

{{-- SECTION 'SCRIPT' ................................................ --}}

@section('script')
    <script src="DiDongZin/assets/js/_dienthoai.js"></script>
    <script>
        window.onload = function()
        {
            document.getElementById('dienThoaiMenu').classList.add('active');
        }

        function XoaDienThoai(ten)
        {
            if(confirm('Bạn sẽ xóa điện thoại '+ten+' cùng các thông tin liên quan ?') == true)
            {
                return confirm('Bạn sẽ xóa điện thoại này. Bạn chắc chứ ?');
            }
            return false;
        }
    </script>    
@endsection