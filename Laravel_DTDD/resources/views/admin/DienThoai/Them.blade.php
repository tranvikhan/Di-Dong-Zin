@extends('admin.layout.index')

@section('content')

<!-- NOI DUNG CHINH ..................................................................................-->
<div class="content">
    <div id="themdienthoai" class="tabcontent nhaplieu">
        <h2>THÊM ĐIỆN THOẠI</h2>
        <form action="admin/dienthoai/them" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}

            @if (count($errors)>0)
                <?php $str = ''; ?>
                @foreach ($errors->all() as $err)
                    <?php
                        ($str == '') ? $str .= $err : $str.= '\\n'. $err;
                    ?>
                @endforeach
                <?php
                    echo '<script>alert("'. $str .'");</script>';
                ?>
            @endif

            @if (session('loi'))
                <?php
                    echo '<script>alert("'. session('loi') .'")</script>' 
                ?>
            @endif

            @if (session('thongbao'))
                <?php
                    echo '<script>alert("'. session('thongbao') .'")</script>' 
                ?>
            @endif

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
                            <td><input type="text" placeholder=" --x--x-- mm" name="kichThuoc"></td>
                        </tr>
                        <tr>
                            <td>Trọng lượng</td>
                            <td><input type="text" placeholder=" --g" name="trongLuong"></td>
                        </tr>
                        <tr>
                            <td>Ram</td>
                            <td><input type="text" placeholder=" --GB" name="ram"></td>
                        </tr>
                        <tr>
                            <td>Rom</td>
                            <td><input type="text" placeholder=" --GB" name="rom"></td>
                        </tr>
                        <tr>
                            <td>Chipset</td>
                            <td><input type="text" placeholder=" " name="chipset"></td>
                        </tr>
                        <tr>
                            <td>Loại màn hình</td>
                            <td><input type="text" placeholder=" " name="loaiManHinh"></td>
                        </tr>
                        <tr>
                            <td>Kích thước màn hình</td>
                            <td><input type="text" placeholder=" " name="kichThuocManHinh"></td>
                        </tr>
                        <tr>
                            <td>Độ phân giải màn hình</td>
                            <td><input type="text" placeholder=" " name="doPhanGiaiManHinh"></td>
                        </tr>
                        <tr>
                            <td>Camera sau</td>
                            <td><input type="text" placeholder=" " name="cameraSau"></td>
                        </tr>
                        <tr>
                            <td>Camera trước</td>
                            <td><input type="text" placeholder=" " name="cameraTruoc"></td>
                        </tr>
                        <tr>
                            <td>Wifi</td>
                            <td><input type="text" placeholder=" " name="wifi"></td>
                        </tr>
                        <tr>
                            <td>Bluetooth</td>
                            <td><input type="text" placeholder=" " name="bluetooth"></td>
                        </tr>
                        <tr>
                            <td>NFC</td>
                            <td><input type="text" placeholder=" " name="nfc"></td>
                        </tr>
                        <tr>
                            <td>Pin</td>
                            <td><input type="text" placeholder=" " name="pin"></td>
                        </tr>
                        <tr>
                            <td>Hệ điều hành</td>
                            <td><input type="text" placeholder=" " name="heDieuHanh"></td>
                        </tr>
                        <tr>
                            <td>Phiên bản hệ điều hành</td>
                            <td><input type="text" placeholder=" " name="phienBanHeDieuHanh"></td>
                        </tr>
                        <tr>
                            <td>Quay video</td>
                            <td><input type="text" placeholder=" " name="quayVideo"></td>
                        </tr>
                        <tr>
                            <td>Cảm biến</td>
                            <td><input type="text" placeholder=" " name="camBien"></td>
                        </tr>
                        <tr>
                            <td>Khe sim</td>
                            <td><input type="text" placeholder=" " name="kheSim"></td>
                        </tr>
                        <tr>
                            <td>Khe thẻ nhớ</td>
                            <td><input type="text" placeholder=" " name="kheTheNho"></td>
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
                                <input type="text" placeholder="" name="tenDienThoai">
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2">Hãng điện thoại:</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <select name="hangDienThoai">
                                    <option value="">Hãng điện thoại</option>
                                    @foreach ($hangDT as $hang)
                                        <option value="{{ $hang->Ma_hang_dien_thoai }}">{{ $hang->Ten_hang }}</option>    
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2">Mô tả:</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <textarea rows="4" cols="40" name="moTa"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2">Giá điện thoại:</th>
                        </tr>
                        <tr>
                            <td>Giá bán:</td>
                            <td>
                                <input type="text" placeholder="VNĐ" name="giaBan">
                            </td>
                        </tr>
                        <tr>
                            <th > Khuyến mãi:</th>
                            <td>
                                <label class="mycheckbox">
                                    <input type="checkbox" id="apDungKM" name="apDungKM" checked>
                                    <span class="checkmark"></span>
                                </label>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>% Giảm giá:</td>
                            <td>
                                <input type="number" min="0" max="100" placeholder="2%" id="phanTramGiam" name="phanTramGiamGia">
                            </td>
                        </tr>
                        <tr>
                            <td>Quà tặng:</td>
                            <td>
                                <textarea rows="3" cols="40" id="quaTang" name="quaTang"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Từ ngày:</td>
                            <td><input type="date" id="ngayBatDau" name="tuNgay"></td>
                        </tr>
                        <tr>
                            <td>Đến ngày:</td>
                            <td><input type="date" id="ngayKetThuc" name="denNgay"></td>
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
                                <input type="file" id="inputImage" name="anhSanPham">
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
</div>

@endsection

{{-- ...... SECTION 'SCRIPT' ...................................--}}
@section('script')
    <script src="DiDongZin/assets/js/_themdienthoai.js" defer></script>
    <script>
        window.onload = function()
        {
            document.getElementById('dienThoaiMenu').classList.add('active');
        }
    </script>
@endsection