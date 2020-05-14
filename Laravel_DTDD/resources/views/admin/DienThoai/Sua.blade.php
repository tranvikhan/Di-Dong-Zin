@extends('admin.layout.index')

@section('content')

<!-- NOI DUNG CHINH ..................................................................................-->
<div class="content">
    <div id="suadienthoai" class="tabcontent nhaplieu">
        <h2>SỬA ĐIỆN THOẠI</h2>
        <!-- SUA DIEN THOAI ..................................................................................-->
    <form action="admin/dienthoai/sua/{{ $dienThoai->Ma_dien_thoai }}" method="POST" enctype="multipart/form-data">
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
                            <td><input type="text" placeholder=" --x--x--mm" name="kichThuoc" value="{{ $dienThoai->Kich_thuoc }}"></td>
                        </tr>
                        <tr>
                            <td>Trọng lượng</td>
                            <td><input type="number" min="1" max="99999" placeholder=" --g" name="trongLuong" value="{{ $dienThoai->Trong_luong }}"></td>
                        </tr>
                        <tr>
                            <td>Ram</td>
                            <td><input type="number" min="1" max="99999" placeholder=" --GB" name="ram" value="{{ $dienThoai->RAM }}"></td>
                        </tr>
                        <tr>
                            <td>Rom</td>
                            <td><input type="number" min="1" max="99999" placeholder=" --GB" name="rom" value="{{ $dienThoai->ROM }}"></td>
                        </tr>
                        <tr>
                            <td>Chipset</td>
                            <td><input type="text" placeholder=" " name="chipset" value="{{ $dienThoai->Chipset }}"></td>
                        </tr>
                        <tr>
                            <td>Loại màn hình</td>
                            <td><input type="text" placeholder=" " name="loaiManHinh" value="{{ $dienThoai->Loai_man_hinh }}"></td>
                        </tr>
                        <tr>
                            <td>Kích thước màn hình</td>
                            <td><input type="text" placeholder=" " name="kichThuocManHinh" value="{{ $dienThoai->Kich_thuoc_man_hinh }}"></td>
                        </tr>
                        <tr>
                            <td>Độ phân giải màn hình</td>
                            <td><input type="text" placeholder=" " name="doPhanGiaiManHinh" value="{{ $dienThoai->Do_phan_giai_man_hinh }}"></td>
                        </tr>
                        <tr>
                            <td>Camera sau</td>
                            <td><input type="number" min="1" max="99999" placeholder=" --MP" name="cameraSau" value="{{ $dienThoai->Camera_sau }}"></td>
                        </tr>
                        <tr>
                            <td>Camera trước</td>
                            <td><input type="number" min="1" max="99999" placeholder=" --MP" name="cameraTruoc" value="{{ $dienThoai->Camera_truoc }}"></td>
                        </tr>
                        <tr>
                            <td>Wifi</td>
                            <td><input type="text" placeholder=" " name="wifi" value="{{ $dienThoai->Wifi }}"></td>
                        </tr>
                        <tr>
                            <td>Bluetooth</td>
                            <td><input type="text" placeholder=" " name="bluetooth" value="{{ $dienThoai->Bluetooth }}"></td>
                        </tr>
                        <tr>
                            <td>NFC</td>
                            <td><input type="text" placeholder=" " name="nfc" value="{{ $dienThoai->NFC }}"></td>
                        </tr>
                        <tr>
                            <td>Pin</td>
                            <td><input type="number" min="1" max="999999" placeholder=" --mAh" name="pin" value="{{ $dienThoai->Pin }}"></td>
                        </tr>
                        <tr>
                            <td>Hệ điều hành</td>
                            <td><input type="text" placeholder=" " name="heDieuHanh" value="{{ $dienThoai->OS }}"></td>
                        </tr>
                        <tr>
                            <td>Phiên bản hệ điều hành</td>
                            <td><input type="text" placeholder=" " name="phienBanHeDieuHanh" value="{{ $dienThoai->Phien_ban_OS }}"></td>
                        </tr>
                        <tr>
                            <td>Quay video</td>
                            <td><input type="text" placeholder=" " name="quayVideo" value="{{ $dienThoai->Quay_video }}"></td>
                        </tr>
                        <tr>
                            <td>Cảm biến</td>
                            <td><input type="text" placeholder=" " name="camBien" value="{{ $dienThoai->Cam_bien }}"></td>
                        </tr>
                        <tr>
                            <td>Khe sim</td>
                            <td><input type="text" placeholder=" " name="kheSim" value="{{ $dienThoai->Khe_sim }}"></td>
                        </tr>
                        <tr>
                            <td>Khe thẻ nhớ</td>
                            <td><input type="text" placeholder=" " name="kheTheNho" value="{{ $dienThoai->Khe_the_nho }}"></td>
                        </tr>
                    </table>
                </div>
                <div class="col-5">
                    <table>
                        <tr>
                            <th colspan="2">Mã điện thoại:</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="text" disabled id="phoneID" value="{{ $dienThoai->Ma_dien_thoai }}">
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2">Tên điện thoại:</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="text" placeholder="" name="tenDienThoai" value="{{ $dienThoai->Ten_dien_thoai }}">
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2">Hãng điện thoại:</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <select name="hangDienThoai">
                                    @foreach ($hangDT as $hang)
                                        @if ($dienThoai->ToHangDienThoaiDiDong->Ma_hang_dien_thoai == $hang->Ma_hang_dien_thoai)
                                            <option value="{{ $hang->Ma_hang_dien_thoai }}" selected>{{ $hang->Ten_hang }}</option>
                                        @else
                                            <option value="{{ $hang->Ma_hang_dien_thoai }}">{{ $hang->Ten_hang }}</option>
                                        @endif    
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2">Mô tả:</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <textarea rows="4" cols="40" name="moTa">{{ $dienThoai->Mo_ta }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2">Số lượng điện thoại thêm vào kho:</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="number" min="1" name="soLuong" placeholder="Số lượng hiện tại trong kho là {{ $dienThoai->So_luong }}">
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2">Giá điện thoại:</th>
                        </tr>
                        <tr>
                            <td>Giá bán:</td>
                            <td>
                                <input type="number" min="1" max="9999999999" placeholder="VNĐ" name="giaBan" value="{{ $dienThoai->ToGiaBan->last()->Gia }}">
                            </td>
                        </tr>
                        <tr>
                            <th > Khuyến mãi:</th>
                            <?php
                                $hasKM = false;
                                $khuyenMai = $dienThoai->ToKhuyenMai->last();
                                if($khuyenMai !== null)
                                {
                                    //Lấy ngày hiện tại
                                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                                    $today = date('Y-m-d');

                                    //Lấy ngày của chương trình khuyến mãi này
                                    $startDay = $khuyenMai->Tu_ngay;
                                    $endDay = $khuyenMai->Den_ngay;
                                    
                                    //Xác định hiện tại và tương lai có chương trình khuyến mãi không
                                    if( ($startDay<=$today && $today<=$endDay) || $today<=$startDay )
                                    {
                                        $hasKM = true;
                                    }
                                }
                            ?>
                            <td>
                                <label class="mycheckbox">
                                    <input type="checkbox" id="apDungKM" name="apDungKM"
                                        @if ($hasKM)
                                            checked
                                        @endif
                                    >
                                    <span class="checkmark"></span>
                                </label>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>% Giảm giá:</td>
                            <td>
                                <input type="number" min="0" max="100" placeholder="2%" id="phanTramGiam" name="phanTramGiamGia"
                                    @if ($hasKM)
                                        value="{{ $khuyenMai->Phan_tram_khuyen_mai }}"
                                    @else
                                        disabled
                                    @endif
                                >
                            </td>
                        </tr>
                        <tr>
                            <td>Quà tặng:</td>
                            <td>
                                <textarea rows="3" cols="40" id="quaTang" name="quaTang"
                                    @if ( !$hasKM )
                                        disabled
                                    @endif
                                >
                                    @if ($hasKM)
                                        {{ $khuyenMai->Noi_dung }}
                                    @endif
                                </textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Từ ngày:</td>
                            <td><input type="date" id="ngayBatDau" name="tuNgay"
                                @if ($hasKM)
                                    value="{{ $startDay }}"
                                @else
                                    disabled
                                @endif    
                            ></td>
                        </tr>
                        <tr>
                            <td>Đến ngày:</td>
                            <td><input type="date" id="ngayKetThuc" name="denNgay"
                                @if ($hasKM)
                                    value="{{ $endDay }}"
                                @else
                                    disabled
                                @endif    
                            ></td>
                        </tr>
                        <tr>
                            <th colspan="2">Ảnh sản phẩm:</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <img src="DiDongZin/imagePhone/{{ $dienThoai->Hinh_anh }}" id="ImageReview2">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="file" id="inputImage2" name="anhSanPham" >
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
    <script src="DiDongZin/assets/js/_suadienthoai.js"></script>
    <script>
        window.onload = function()
        {
            document.getElementById('dienThoaiMenu').classList.add('active');
        }
    </script>
@endsection