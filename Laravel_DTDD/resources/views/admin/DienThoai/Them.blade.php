@extends('admin.layout.index')

@section('content')

<!-- NOI DUNG CHINH ..................................................................................-->
<div class="content">
    <div id="themdienthoai" class="tabcontent nhaplieu">
        <h2>THÊM ĐIỆN THOẠI</h2>
        <form action="#" method="POST">
            <div class="row">
                <div class="col-7">
                    <table>
                        <tr>
                            <th colspan="2">
                                Thông số kỹ thuật:
                            </th>
                        </tr>
                        <tr>
                            <td>Kích thước</td>
                            <td><input type="text" placeholder=" --x--x-- cm"></td>
                        </tr>
                        <tr>
                            <td>Trọng lượng</td>
                            <td><input type="text" placeholder=" --g"></td>
                        </tr>
                        <tr>
                            <td>Ram</td>
                            <td><input type="text" placeholder=" --GB"></td>
                        </tr>
                        <tr>
                            <td>Rom</td>
                            <td><input type="text" placeholder=" --GB"></td>
                        </tr>
                        <tr>
                            <td>Chipset</td>
                            <td><input type="text" placeholder=" "></td>
                        </tr>
                        <tr>
                            <td>Loại màn hình</td>
                            <td><input type="text" placeholder=" "></td>
                        </tr>
                        <tr>
                            <td>Kích thước màn hình</td>
                            <td><input type="text" placeholder=" "></td>
                        </tr>
                        <tr>
                            <td>Độ phân giải màn hình</td>
                            <td><input type="text" placeholder=" "></td>
                        </tr>
                        <tr>
                            <td>Camera sau</td>
                            <td><input type="text" placeholder=" "></td>
                        </tr>
                        <tr>
                            <td>Camera trước</td>
                            <td><input type="text" placeholder=" "></td>
                        </tr>
                        <tr>
                            <td>Wifi</td>
                            <td><input type="text" placeholder=" "></td>
                        </tr>
                        <tr>
                            <td>Bluetooth</td>
                            <td><input type="text" placeholder=" "></td>
                        </tr>
                        <tr>
                            <td>NFC</td>
                            <td><input type="text" placeholder=" "></td>
                        </tr>
                        <tr>
                            <td>Hệ điều hành</td>
                            <td><input type="text" placeholder=" "></td>
                        </tr>
                        <tr>
                            <td>Phiên bản hệ điều hành</td>
                            <td><input type="text" placeholder=" "></td>
                        </tr>
                        <tr>
                            <td>Quay video</td>
                            <td><input type="text" placeholder=" "></td>
                        </tr>
                        <tr>
                            <td>Cảm biến</td>
                            <td><input type="text" placeholder=" "></td>
                        </tr>
                        <tr>
                            <td>Khe sim</td>
                            <td><input type="text" placeholder=" "></td>
                        </tr>
                        <tr>
                            <td>Khe thẻ nhớ</td>
                            <td><input type="text" placeholder=" "></td>
                        </tr>
                    </table>
                </div>
                <div class="col-5">
                    <table>
                        <tr>
                            <th colspan="2">Tên điện thoại:</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="text" placeholder="">
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2">Hãng điện thoại:</th>
                        </tr>
                        <tr>
                            <td colspan="2">
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
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2">Mô tả:</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <textarea rows="4" cols="40"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2">Giá điện thoại:</th>
                        </tr>
                        <tr>
                            <td>Giá bán:</td>
                            <td>
                                <input type="text" placeholder="VNĐ">
                            </td>
                        </tr>
                        <tr>
                            <th > Khuyến mãi:</th>
                            <td>
                                <label class="mycheckbox">
                                    <input type="checkbox" id="apDungKM" checked>
                                    <span class="checkmark"></span>
                                </label>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>% Giảm giá:</td>
                            <td>
                                <input type="text" placeholder="2%" id="phanTramGiam">
                            </td>
                        </tr>
                        <tr>
                            <td>Quà tặng:</td>
                            <td>
                                <textarea rows="3" cols="40" id="quaTang"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Từ ngày:</td>
                            <td><input type="date" id="ngayBatDau"></td>
                        </tr>
                        <tr>
                            <td>Đến ngày:</td>
                            <td><input type="date" id="ngayKetThuc"></td>
                        </tr>
                        <tr>
                            <th colspan="2">Ảnh sản phẩm:</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <img src="DiDongZin/assets/img/undraw_photo_4yb9.svg" id="ImageReview">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="file" id="inputImage">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="reset" value="Hủy" onclick="openTab(event, 'dienthoai')">
                            </td>
                            <td>
                                <input type="submit" value="Lưu">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </form>
    </div>
    <script src="DiDongZin/assets/js/_themdienthoai.js"></script>
</div>

@endsection