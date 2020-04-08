@extends('admin.layout.index')

@section('content')

<!-- NOI DUNG CHINH ..................................................................................-->
<div class="content">
    <!-- DIEN THOAI ..................................................................................-->
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
                    <option>Ngày đăng trước</option>
                    <option>Ngày đăng sau</option>
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
                    Hãng
                </th>
                <th>
                    Ngày đăng
                </th>
            </tr>
            <tr>
                <td>
                    <label class="mycheckbox">
                        <input type="checkbox" name="check_phone[]">
                        <span class="checkmark"></span>
                    </label>
                </td>
                <td>
                    <img src="DiDongZin/dttd/iphone11-black-1.png">
                </td>
                <td>
                    iPhone11 64Gb Mới Chính Hãng 1232356k4kj46+5j6k.kj
                    <div class="mini-action">
                        <a href="#">Xem</a>
                        <a onclick="loadPage('admin/dienthoai/sua/1')">Chỉnh sửa</a>
                        <a onclick="delete_item(madienthoai='0001')">Xóa</a>
                    </div>
                </td>
                <td>
                    0001
                </td>
                <td>
                    19.190.000 VND
                </td>
                <td>
                    Apple
                </td>
                <td>
                    12/3/2020 2365656
                </td>
            </tr>
            <tr>
                <td>
                    <label class="mycheckbox">
                        <input type="checkbox" name="check_phone[]">
                        <span class="checkmark"></span>
                    </label>
                </td>
                <td>
                    <img src="DiDongZin/dttd/iphoneX-space-gray-300x400.png">
                </td>
                <td>
                    iPhoneX 64Gb Mới Chính Hãng
                    <div class="mini-action">
                        <a href="#">Xem</a>
                        <a onclick="loadPage('admin/dienthoai/sua/1')">Chỉnh sửa</a>
                        <a onclick="delete_item(madienthoai='0002')">Xóa</a>
                    </div>
                </td>
                <td>
                    0002
                </td>
                <td>
                    11.190.000 VND
                </td>
                <td>
                    Apple
                </td>
                <td>
                    13/3/2020
                </td>
            </tr>
            <tr>
                <td>
                    <label class="mycheckbox">
                        <input type="checkbox" name="check_phone[]">
                        <span class="checkmark"></span>
                    </label>
                </td>
                <td>
                    <img src="DiDongZin/dttd/s20-hong.png">
                </td>
                <td>
                    Samsung Galaxy S20 8Gb/256Gb Mới Chính Hãng
                    <div class="mini-action">
                        <a href="#">Xem</a>
                        <a onclick="loadPage('admin/dienthoai/sua/1')">Chỉnh sửa</a>
                        <a onclick="delete_item(madienthoai='0003')">Xóa</a>
                    </div>
                </td>
                <td>
                    0003
                </td>
                <td>
                    19.490.000 VND
                </td>
                <td>
                    Samsung
                </td>
                <td>
                    13/3/2020
                </td>
            </tr>
        </table>
    </div>
    <script src="DiDongZin/assets/js/_dienthoai.js"></script>
</div>

@endsection