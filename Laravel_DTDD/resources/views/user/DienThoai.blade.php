@extends('user.layout.index')

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

<div class="container page-body">
    <div class="row">
            <div class="col-6 dt-anh">
                <img src="DiDongZin/imagePhone/{{ $dienThoai->Hinh_anh }}" style="height:480px">
            </div>
            <div class="col-6 dt-thongtin">
            <h2 class="name">{{ $dienThoai->Ten_dien_thoai }}</h2>
                <h3 class="company">Hãng: {{ $dienThoai->ToHangDienThoaiDiDong->Ten_hang }}</h2>
                
                {{-- Kiểm tra điện thoại có khuyến mãi không? ------}}
                <?php
                    //Lấy khuyến mãi cuối cùng
                    $km = $dienThoai->ToKhuyenMai->last();
                    $hasKM = false;
                    $phanTramKM;
                    if($km !== null)
                    {
                        //Lấy ngày hiện tại
                        date_default_timezone_set('Asia/Ho_Chi_Minh');
                        $today = date('Y-m-d');

                        if($km->Tu_ngay<=$today && $today<=$km->Den_ngay)
                        {
                            $hasKM = true;
                            $phanTramKM = $km->Phan_tram_khuyen_mai;
                        }
                    }
                ?>
                @if ( $hasKM )
                    <span class="price1">{{ ShowPrice($dienThoai->ToGiaBan->last()->Gia) }} VND</span>
                    <span class="price2">{{ ShowPrice($dienThoai->ToGiaBan->last()->Gia * (1 - ($phanTramKM/100))) }} VND</span>
                    <div>
                        <h4>Khuyến mãi:</h4>
                        <ul>
                            <li>
                                {{ $km->Noi_dung }}
                            </li>
                        </ul>
                    </div>
                @else
                    <span class="price2">{{ ShowPrice($dienThoai->ToGiaBan->last()->Gia) }} VND</span>
                @endif
                
                <button class="btn-lag" onclick="ThemVaoGioHang({{ $dienThoai->Ma_dien_thoai }})"><img src="DiDongZin/assets/img/plus_math_50px.png">Thêm vào giỏ hàng</button>
            </div>
            <div class="col-8 dt-thongtinct">
                <h2 class="title">Thông tin sản phẩm</h2>
                <p class="mota">
                    {{ $dienThoai->Mo_ta }}
                </p><br>
                <h2 class="title">Nhận xét</h2>
                <div class="new-comment">
                    <textarea rows="2" cols="48" placeholder="Mời bạn nhập nội dung nhận xét tại đây!" id="noiDungCmtMoi"></textarea>
                    <button onclick="add_cmt()"><img src="DiDongZin/assets/img/comments_50px.png">Gửi</button>
                </div>
                
                {{-- IN BÌNH LUẬN --------------------------------}}
                @foreach($dsBinhLuan as $bl)
                    {{-- HIỆN BÌNH LUẬN CHA: bình luận có mã_bình_luận_cha != null, nên bình luận này là bình luận con --}}
                    @if ($bl->Ma_binh_luan_cha == null)
                        <div class="docker" id="cmt-001">
                            <div class="comment">
                                <img src="DiDongZin/avatar/{{ $bl->ToTaiKhoan->URL_Avatar }}" alt="avatar">
                                <div>
                                    <span class="name-cmt">{{ $bl->ToTaiKhoan->Ho_va_ten_lot }} {{ $bl->ToTaiKhoan->Ten }}</span>
                                    <span class="time-cmt">{{ $bl->Thoi_gian_binh_luan }}</span>
                                    <p class="content-cmt">
                                        {{ $bl->Noi_dung }}
                                    </p>
                                    <div class="action-g">
                                    <button class="reply-cmt" onclick="reply_cmt('cmt-reply-001')"><img
                                            src="DiDongZin/assets/img/left_2_30px.png">Trả lời</button>
                                        <button class="edit-cmt" onclick="edit_cmt('cmt-edit-001')"><img
                                                src="DiDongZin/assets/img/design_30px.png">Chỉnh sửa</button>
                                        <button class="del-cmt" onclick="del_cmt('cmt-001')"><img src="DiDongZin/assets/img/trash_can_30px.png">Xóa</button>
                                    </div>
                                </div>
                            </div>
                            <div class="comment tl-cmt reply-comment-tool" id="cmt-reply-001">
                                <img src="DiDongZin/avatar/avatar-cartoon-superman-png_244033.jpg">
                                <div class="new-comment">
                                    <textarea rows="2" cols="48"
                                        placeholder="Mời bạn nhập nội dung trả lời nhận xét trên tại đây!"></textarea>
                                    <button onclick="new_cmt('cmt-reply-001','cmt-001')">Gửi</button>
                                    <button onclick="reply_cmt('cmt-reply-001')" class="cancle">Hủy</button>
                                </div>
                            </div>
                            <div class="comment tl-cmt edit-comment-tool" id="cmt-edit-001">
                                <img src="DiDongZin/avatar/avatar-cartoon-superman-png_244033.jpg">
                                <div class="new-comment">
                                    <textarea rows="2" cols="48" placeholder="Chỉnh sửa nội dung"></textarea>
                                    <button onclick="change_cmt('cmt-edit-001','cmt-001')">Lưu</button>
                                    <button class="cancle" onclick="edit_cmt('cmt-edit-001')">Hủy</button>
                                </div>
                            </div>
                        </div>

                        {{-- HIỆN BÌNH LUẬN CON CỦA BÌNH LUẬN CHA PHÍA TRÊN --}}
                        @foreach ($dsBinhLuan as $blCon)
                            @if ($blCon->Ma_binh_luan_cha == $bl->Ma_binh_luan)
                                <div class="docker" id="cmt-003">
                                    <div class="comment tl-cmt">
                                        <img src="DiDongZin/avatar/{{ $blCon->ToTaiKhoan->URL_Avatar }}" alt="avatar">
                                        <div>
                                            <span class="name-cmt">{{ $blCon->ToTaiKhoan->Ho_va_ten_lot }} {{ $blCon->ToTaiKhoan->Ten }}</span>
                                            <span class="time-cmt">{{ $blCon->Thoi_gian_binh_luan }}</span>
                                            <p class="content-cmt">
                                                {{ $blCon->Noi_dung }}
                                            </p>
                                            <div class="action-g">
                                                <button class="edit-cmt" onclick="edit_cmt('cmt-edit-003')"><img src="DiDongZin/assets/img/design_30px.png">Chỉnh sửa</button>
                                                <button class="del-cmt" onclick="del_cmt('cmt-003')"><img
                                                        src="DiDongZin/assets/img/trash_can_30px.png">Xóa</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="comment tl-cmt edit-comment-tool" id="cmt-edit-003">
                                        <img src="DiDongZin/avatar/avatar-cartoon-superman-png_244033.jpg">
                                        <div class="new-comment">
                                            <textarea rows="2" cols="48" placeholder="Chỉnh sửa nội dung"></textarea>
                                            <button onclick="change_cmt('cmt-edit-003','cmt-003')">Lưu</button>
                                            <button class="cancle" onclick="edit_cmt('cmt-edit-003')">Hủy</button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach    
                    @endif
                @endforeach

                <div class="pagination">
                    {!! $dsBinhLuan->links() !!}
                </div>
                
                {{-- <div class="pagination">
                    <a href="#">&laquo;</a>
                    <a href="#" class="active">1</a>
                    <a  href="#">2</a>
                    <a href="#">3</a>
                    <a href="#">4</a>
                    <a href="#">5</a>
                    <a href="#">6</a>
                    <a href="#">7</a>
                    <a href="#">&raquo;</a>
                </div> --}}

            </div>  
            <div class="col-4 dt-cauhinh">
                <h2 class="title">Cấu hình</h2>
                <table>
                    <tr>
                        <td>Kích thước</td>
                        <td>{{ $dienThoai->Kich_thuoc }} cm</td>
                    </tr>
                    <tr>
                        <td>Trọng lượng</td>
                        <td>{{ $dienThoai->Trong_luong }}g</td>
                    </tr>
                    <tr>
                        <td>Ram</td>
                        <td>{{ $dienThoai->RAM }}GB</td>
                    </tr>
                    <tr>
                        <td>Rom</td>
                        <td>{{ $dienThoai->ROM }}GB</td>
                    </tr>
                    <tr>
                        <td>Chipset</td>
                        <td>{{ $dienThoai->Chipset }}</td>
                    </tr>
                    <tr>
                        <td>Loại màn hình</td>
                        <td>{{ $dienThoai->Loai_man_hinh }}</td>
                    </tr>
                    <tr>
                        <td>Kích thước màn hình</td>
                        <td>{{ $dienThoai->Kich_thuoc_man_hinh }}</td>
                    </tr>
                    <tr>
                        <td>Độ phân giải màn hình</td>
                        <td>{{ $dienThoai->Do_phan_giai_man_hinh }}</td>
                    </tr>
                    <tr>
                        <td>Camera sau</td>
                        <td>{{ $dienThoai->Camera_sau }} Mpx</td>
                    </tr>
                    <tr>
                        <td>Camera trước</td>
                        <td>{{ $dienThoai->Camera_truoc }} Mpx</td>
                    </tr>
                    <tr>
                        <td>Wifi</td>
                        <td>{{ $dienThoai->Wifi }}</td>
                    </tr>
                    <tr>
                        <td>Bluetooth</td>
                        <td>{{ $dienThoai->Bluetooth }}</td>
                    </tr>
                    <tr>
                        <td>NFC</td>
                        <td>{{ $dienThoai->NFC }}</td>
                    </tr>
                    <tr>
                        <td>Hệ điều hành</td>
                        <td>{{ $dienThoai->OS }}</td>
                    </tr>
                    <tr>
                        <td>Phiên bản hệ điều hành</td>
                        <td>{{ $dienThoai->Phien_ban_OS }}</td>
                    </tr>
                    <tr>
                        <td>Quay video</td>
                        <td>{{ $dienThoai->Quay_video }}</td>
                    </tr>
                    <tr>
                        <td>Cảm biến</td>
                        <td>{{ $dienThoai->Cam_bien }}</td>
                    </tr>
                    <tr>
                        <td>Khe sim</td>
                        <td>{{ $dienThoai->Khe_sim }}</td>
                    </tr>
                    <tr>
                        <td>Khe thẻ nhớ</td>
                        <td>{{ $dienThoai->Khe_the_nho }}</td>
                    </tr>
                </table>
            </div>
    </div>
</div>

 @endsection

 @section('script')
    <script src="DiDongZin/assets/js/phone.js"></script>
    <script>
        function ThemVaoGioHang(maDT)
        {
            window.location.href = 'ThemVaoGioHang/'+maDT;
        }
    </script>

 @endsection