@extends('admin.layout.index')

@section('content')
<?php
    //Hiển thị giá theo 1 định dạng khác
    function ShowPrice($price)
    {
        $price = $price."";
        $strPrice = "";
        while(strlen($price) >= 3)
        {
            $temp = substr($price, strlen($price)-3, strlen($price));
            if($strPrice == "") {
                $strPrice .= $temp;
            }else {
                $strPrice = $temp .'.'. $strPrice;    
            }
            $price = substr($price, 0, strlen($price)-3);
        }
        if(strlen($price) != 0)
        {
            $strPrice = $price .'.'. $strPrice;
        }

        return $strPrice;
    }
?>

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
                <select name="hangDT" id="hangDT">
                    <option value="">Hãng điện thoại</option>
                    @foreach ($hangDT as $hang)
                        <option value="{{ $hang->Ma_hang_dien_thoai }}">{{ $hang->Ten_hang }}</option>    
                    @endforeach
                </select>
                <select id="mucGia">
                    <option value="">Mức giá</option>
                    <option value="duoi2">Dưới 2 triệu</option>
                    <option value="2Den5">2 triệu - 5 triệu</option>
                    <option value="5Den10">5 triệu-10 triệu</option>
                    <option value="10Den15">10 triệu-15 triệu</option>
                    <option value="tren15">Trên 15 triệu</option>
                </select>
                <select id="sapXep">
                    <option value="">Sắp xếp theo</option>
                    <option value="giaCao">Giá cao</option>
                    <option value="giaThap">Giá thấp</option>
                </select>
                <button id="LocSanPham">Lọc sản phẩm</button>

            </div>
            <div class="g-timkiem col-3">
                <input type="text" placeholder="Nhập tên hoặc mã điện thoại" id="timKiem">
                <button id="btnTimKiem">Tìm kiếm</button>
            </div>
        </div>
        <div id="table">
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
                        Số lượng
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
                                {{ $dt->So_luong }}
                            </td>
                            <td>
                                {{ ShowPrice( $dt->ToGiaBan->last()->Gia ).' VND' }}
                            </td>
                            <td>
                                <?php
                                    //Lấy ngày hiện tại
                                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                                    $today = date('Y-m-d');

                                    //Lấy giá điện thoại
                                    $gia = $dt->ToGiaBan->last()->Gia;

                                    //Lấy ra ngày bắt đầu và ngày kết thúc khuyến mãi
                                    $hasKM = false;
                                    $startDay = 0;
                                    $endDay = 0;    //Ngày khuyến mãi kết thúc
                                    $percent = 0;   //Phần trăm khuyến mãi của chương trình này
                                    $khuyenMai = $dt->ToKhuyenMai->last();
                                    if($khuyenMai !== null)
                                    {
                                        $startDay = $khuyenMai->Tu_ngay;
                                        $endDay = $khuyenMai->Den_ngay;
                                        if( $startDay<=$today && $today <= $endDay )
                                        {
                                            $hasKM = true;
                                            $percent = $khuyenMai->Phan_tram_khuyen_mai;
                                        }                                        
                                    }
                                ?>
                                @if ( $hasKM )
                                    {{ ShowPrice( $gia*(1-($percent/100)) ).' VND' }}
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
        </div>
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

        $(document).ready(function(){
            $("#LocSanPham").click(function(){
                hangDT = document.getElementById("hangDT").value;
                mucGia = document.getElementById("mucGia").value;
                sapXep = document.getElementById("sapXep").value;

                if( hangDT!="" || mucGia!="" || sapXep!="" )
                {
                    if(hangDT == "")
                    {
                        hangDT = "khongChon";
                    }
                    if(mucGia == "")
                    {
                        mucGia = "khongChon";
                    }
                    if(sapXep == "")
                    {
                        sapXep = "khongChon";
                    }

                    $.get("admin/dienthoai/LocDienThoaiAjax/"+hangDT+"/"+mucGia+"/"+sapXep, function($data){
                        $("#table").html($data);
                    });
                }
                else
                {
                    alert('Bạn phải chọn một trong các điều kiện lọc sản phẩm');
                    location.reload();
                }

                //Khung tìm kiếm trở về rỗng
                document.getElementById("timKiem").value = "";
            });
        });

        $(document).ready(function(){
            $("#btnTimKiem").click(function(){
                noiDung = $("#timKiem").val();

                if(noiDung == "")
                {
                    alert("Bạn phải nhập từ khóa ngẫu nhiên để tìm kiếm");
                }
                else
                {
                    $.get("admin/dienthoai/TimKiemDienThoaiAjax/"+noiDung, function($data){
                    $("#table").html($data);
                    });
                }      
                
                //Khung lọc sản phẩm trở về rỗng
                document.getElementById("hangDT").value = "";
                document.getElementById("mucGia").value = "";
                document.getElementById("sapXep").value = "";
            });
        });
    </script>    
@endsection