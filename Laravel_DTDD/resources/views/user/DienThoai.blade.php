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
                {{-- input:hidden: dùng để chạy ajax cho thêm bình luận --}}
                <input type="hidden" id="idDienThoai" value="{{ $dienThoai->Ma_dien_thoai }}">

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

            {{-- Lưu Mã tài khoản khi người dùng đăng nhập, khi chưa đăng nhập thì Ma_tai_khoan=0 --}}
            <input type="hidden" id="idTaiKhoan"
                @if (Auth::check())
                    value="{{ Auth::user()->Ma_tai_khoan }}"
                @else
                    value="0"
                @endif
            >
            {{-- Lưu họ tên và tên ảnh đại diện: để khi thêm bình luận thì sẽ lấy dữ liệu này để hiển thị ra ngoài --}}
            @if (Auth::check())
                <input type="hidden" id="hoTenTaiKhoan" value="{{ Auth::user()->Ho_va_ten_lot }} {{ Auth::user()->Ten }}">
                <input type="hidden" id="tenAnhDaiDien" value="{{ Auth::user()->URL_Avatar }}">
            @endif


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
                    {{-- input này chứa mã bình luận max: dùng khi tạo bình luận cha mới --}}
                <input type="hidden" id="max_idParentCmt" 
                    <?php
                        $max = App\BinhLuan::all()->max('Ma_binh_luan');
                    ?>
                    value="{{ $max }}"
                >
                <div id="all-cmt">
                    @foreach($dsBinhLuanCha as $blCha)
                        <div class="docker" id="parent-cmt{{ $blCha->Ma_binh_luan }}">
                            <div class="comment">
                                <img src="DiDongZin/avatar/{{ $blCha->ToTaiKhoan->URL_Avatar }}" alt="avatar">
                                <div>
                                    <span class="name-cmt">{{ $blCha->ToTaiKhoan->Ho_va_ten_lot }} {{ $blCha->ToTaiKhoan->Ten }}</span>
                                    <span class="time-cmt">{{ $blCha->Thoi_gian_binh_luan }}</span>
                                    
                                    <p class="content-cmt" id="content-cmt{{ $blCha->Ma_binh_luan }}">
                                        {{ $blCha->Noi_dung }}
                                    </p>
                                    <div class="action-g" id="action-cmt{{ $blCha->Ma_binh_luan }}">
                                        <button class="reply-cmt" onclick="reply_cmt({{ $blCha->Ma_binh_luan }})"><img
                                            src="DiDongZin/assets/img/left_2_30px.png">Trả lời</button>
                                        
                                        {{-- Hai nút Chỉnh sửa và Xóa: chỉ khi chính bản thân tài khoản mới thực hiện được --}}
                                        @if ( Auth::check() && Auth::user()->Ma_tai_khoan == $blCha->Ma_tai_khoan )
                                            <button class="edit-cmt" onclick="edit_cmt({{ $blCha->Ma_binh_luan }})"><img
                                                src="DiDongZin/assets/img/design_30px.png">Chỉnh sửa</button>
                                            <button class="del-cmt" onclick="delete_cmt({{ $blCha->Ma_binh_luan }})"><img 
                                                src="DiDongZin/assets/img/trash_can_30px.png">Xóa</button>    
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- HIỆN BÌNH LUẬN CON CỦA BÌNH LUẬN CHA PHÍA TRÊN --}}
                            @foreach ($dsBinhLuanCon as $blCon)
                                @if ($blCon->Ma_binh_luan_cha == $blCha->Ma_binh_luan)
                                    <div class="docker" id="child-cmt{{ $blCon->Ma_binh_luan }}">
                                        <div class="comment tl-cmt">
                                            <img src="DiDongZin/avatar/{{ $blCon->ToTaiKhoan->URL_Avatar }}" alt="avatar">
                                            <div>
                                                <span class="name-cmt">{{ $blCon->ToTaiKhoan->Ho_va_ten_lot }} {{ $blCon->ToTaiKhoan->Ten }}</span>
                                                <span class="time-cmt">{{ $blCon->Thoi_gian_binh_luan }}</span>
                                                <p class="content-cmt" id="content-childCmt{{ $blCon->Ma_binh_luan }}">
                                                    {{ $blCon->Noi_dung }}
                                                </p>

                                                {{-- Hai nút Chỉnh sửa và Xóa: chỉ khi chính bản thân tài khoản mới thực hiện được --}}
                                                @if ( Auth::check() && Auth::user()->Ma_tai_khoan == $blCon->Ma_tai_khoan )
                                                    <div class="action-g" id="action-childCmt{{ $blCon->Ma_binh_luan }}">
                                                        <button class="edit-cmt" onclick="edit_childCmt({{ $blCon->Ma_binh_luan }})"><img 
                                                            src="DiDongZin/assets/img/design_30px.png">Chỉnh sửa</button>
                                                        <button class="del-cmt" onclick="delete_childCmt({{ $blCon->Ma_binh_luan }})"><img
                                                            src="DiDongZin/assets/img/trash_can_30px.png">Xóa</button>
                                                    </div>    
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            
                            {{-- div này thuộc bình luận cha: dùng để xuất hiện những bình luận con của bình luận cha --}}
                            <div id="child-cmt-frame{{ $blCha->Ma_binh_luan }}"></div>
                            
                            {{-- Khung nhập phần trả lời của bình luận cha --}}
                            <div class="comment tl-cmt" id="reply-cmt-frame{{ $blCha->Ma_binh_luan }}"></div>
                        </div>
                    @endforeach
                </div>

                <div class="pagination">
                    {!! $dsBinhLuanCha->links() !!}
                </div>
                
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

    //----------- THAO TÁC VỚI BÌNH LUẬN CHA ----------------------------------
    // ------ THÊM MỚI BÌNH LUẬN CHA ------
    function add_cmt()
    {        
        if( KiemTraDangNhap() )
        {
            noiDung = document.getElementById('noiDungCmtMoi').value;
            id_maxCmt = document.getElementById('max_idParentCmt').value * 1;
            id_maxCmt += 1;

            // Lưu lại mã bình luận max hiện tại
            document.getElementById('max_idParentCmt').value = id_maxCmt;

            //Lấy thời gian hiện tại
            day = new Date();
            now = day.getFullYear()+'-'+(day.getMonth()+1)+'-'+day.getDate()+' '+day.getHours()+':'+day.getMinutes()+':'+day.getSeconds();

            // Lấy tên người dùng và tên ảnh đại diện
            hoTen = document.getElementById('hoTenTaiKhoan').value;
            anhDaiDien = document.getElementById('tenAnhDaiDien').value;

            // Tạo comment cha mới
            str =   '<div class="docker" id="parent-cmt'+ id_maxCmt +'">'
                        +'<div class="comment">'
                            +'<img src="DiDongZin/avatar/'+ anhDaiDien +'" alt="avatar">'
                            +'<div>'
                                +'<span class="name-cmt">'+ hoTen +'</span>'
                                +'<span class="time-cmt">'+ now +'</span>'
                                +'<p class="content-cmt" id="content-cmt'+ id_maxCmt +'">'+ noiDung +'</p>'
                                
                                +'<div class="action-g" id="action-cmt'+ id_maxCmt +'">'
                                    +'<button class="reply-cmt" onclick="reply_cmt('+ id_maxCmt +')"><img '
                                        +' src="DiDongZin/assets/img/left_2_30px.png">Trả lời</button>'
                                    +'<button class="edit-cmt" onclick="edit_cmt('+ id_maxCmt +')"><img '
                                        +' src="DiDongZin/assets/img/design_30px.png">Chỉnh sửa</button>'
                                    +'<button class="del-cmt" onclick="delete_cmt('+ id_maxCmt +')"><img src="DiDongZin/assets/img/trash_can_30px.png">Xóa</button>'
                                +'</div>'
                            +'</div>'
                        +'</div>'

                        // div này: dùng để xuất hiện những bình luận con của bình luận cha
                        +'<div id="child-cmt-frame'+ id_maxCmt +'"></div>'
                        
                        // Khung nhập phần trả lời của bình luận cha
                        +'<div class="comment tl-cmt" id="reply-cmt-frame'+ id_maxCmt +'"></div>'
                    +'</div>';
            allCmt_frame = document.getElementById('all-cmt');
            $(str).prependTo(allCmt_frame);

            // Làm rỗng khung nhập binh luận
            document.getElementById('noiDungCmtMoi').value = '';

            // Thêm bình luận cha, nên Ma_binh_luan_cha=0
            ThemBinhLuan('0', noiDung);
        }        
    }

    // ----- ACTION VỚI BÌNH LUẬN CHA
    // MỞ HỘP THOẠI TRẢ LỜI
    function reply_cmt(idParentCmt)
    {
        if( KiemTraDangNhap() )
        {
            anhDaiDien = document.getElementById('tenAnhDaiDien').value;

            // Hiển thị nơi nhập liệu cho câu trả lời
            str =   '<img src="DiDongZin/avatar/'+ anhDaiDien +'">'
                    +'<div class="new-comment">'
                        +'<textarea rows="2" cols="48" id="content-reply'+ idParentCmt +'"'
                            +'placeholder="Mời bạn nhập nội dung trả lời nhận xét trên tại đây!"></textarea>'
                        +'<button onclick="btnGui_reply('+ idParentCmt +')">Gửi</button>'
                        +'<button onclick="btnHuy_reply('+ idParentCmt +')" class="cancle">Hủy</button>'
                    +'</div>';
            document.getElementById('reply-cmt-frame'+idParentCmt).innerHTML = str;
        }        
    }

    // NHẤN NÚT GỬI, TẠO BÌNH LUẬN CON MỚI
    function btnGui_reply(idParentCmt)
    {
        noiDung = document.getElementById('content-reply'+idParentCmt).value;

        id_maxCmt = document.getElementById('max_idParentCmt').value * 1;
        id_maxCmt += 1;

        // Gán lại giá trị Mã bình luận max
        document.getElementById('max_idParentCmt').value = id_maxCmt;

        //Lấy thời gian hiện tại
        day = new Date();
        now = day.getFullYear()+'-'+(day.getMonth()+1)+'-'+day.getDate()+' '+day.getHours()+':'+day.getMinutes()+':'+day.getSeconds();

        // Lấy tên người dùng và tên ảnh đại diện
        hoTen = document.getElementById('hoTenTaiKhoan').value;
        anhDaiDien = document.getElementById('tenAnhDaiDien').value;

        // Tạo bình luận con mới
        str =   '<div class="docker" id="child-cmt'+ id_maxCmt +'">'
                    +'<div class="comment tl-cmt">'
                        +'<img src="DiDongZin/avatar/'+ anhDaiDien +'" alt="avatar">'
                        +'<div>'
                            +'<span class="name-cmt">'+ hoTen +'</span>'
                            +'<span class="time-cmt">'+ now +'</span>'
                            +'<p class="content-cmt" id="content-childCmt'+ id_maxCmt +'">'+ noiDung +'</p>'
                            +'<div class="action-g" id="action-childCmt'+ id_maxCmt +'">'
                                +'<button class="edit-cmt" onclick="edit_childCmt('+ id_maxCmt +')"><img '
                                    +' src="DiDongZin/assets/img/design_30px.png">Chỉnh sửa</button>'
                                +'<button class="del-cmt" onclick="delete_childCmt('+ id_maxCmt +')"><img '
                                    +' src="DiDongZin/assets/img/trash_can_30px.png">Xóa</button>'
                            +'</div>'
                        +'</div>'
                    +'</div>'
                +'</div>';
        child_cmt_frame = document.getElementById('child-cmt-frame'+idParentCmt);
        $(str).appendTo(child_cmt_frame);
        
        // Đóng khung trả lời lại
        btnHuy_reply(idParentCmt);

        // Thêm bình luận con
        ThemBinhLuan(idParentCmt, noiDung);        
    }

    // NHẤN NÚT HỦY KHI ĐÃ MỞ HỘP THOẠI TRẢ LỜI
    function btnHuy_reply(idParentCmt)
    {
        document.getElementById('reply-cmt-frame'+idParentCmt).innerHTML = '';
    }

    // MỞ HỘP THOẠI CHỈNH SỬA
    function edit_cmt(idCmt)
    {
        noiDung = document.getElementById("content-cmt"+idCmt).innerHTML;
        noiDung = noiDung.trim();
        updateFrame = "<div class='new-comment'>"
                        +"<textarea rows='2' cols='48' placeholder='Chỉnh sửa nội dung' id='content-update"+ idCmt +"'>"+ noiDung +"</textarea>"
                        +"<input type='hidden' id='content-update-temp"+ idCmt +"' value='"+ noiDung +"'>"
                        +"<button onclick='save_cmt("+ idCmt +")'>Lưu</button>"
                        +"<button class='cancle' onclick='cancel_cmt("+ idCmt +")'>Hủy</button>"
                    +"</div>";
        document.getElementById("content-cmt"+idCmt).innerHTML = updateFrame;
        document.getElementById("action-cmt"+idCmt).innerHTML = '';
    }

    // NHẤN NÚT GỬI KHI ĐÃ MỞ HỘP THOẠI CHỈNH SỬA
    function save_cmt(idCmt)
    {
        noiDung = document.getElementById('content-update'+idCmt).value;
        document.getElementById("content-cmt"+idCmt).innerHTML = noiDung;

        // Hiện thị lại các action đối với bình luận
        str = '<button class="reply-cmt" onclick="reply_cmt('+ idCmt +')"><img'
                    +' src="DiDongZin/assets/img/left_2_30px.png">Trả lời</button>'
                +'<button class="edit-cmt" onclick="edit_cmt('+ idCmt +')"><img'
                    +' src="DiDongZin/assets/img/design_30px.png">Chỉnh sửa</button>'
                +'<button class="del-cmt" onclick="delete_cmt('+ idCmt +')"><img'
                    +' src="DiDongZin/assets/img/trash_can_30px.png">Xóa</button>';
        document.getElementById("action-cmt"+idCmt).innerHTML = str;

        // Cập nhật bình luận cha
        CapNhatBinhLuan('sua', idCmt, noiDung);
    }

    // NHẤN NÚT HỦY KHI ĐÃ MỞ HỘP THOẠI CHỈNH SỬA
    function cancel_cmt(idCmt)
    {
        noiDung = document.getElementById('content-update-temp'+idCmt).value;
        document.getElementById("content-cmt"+idCmt).innerHTML = noiDung;

        // Hiện thị lại các action đối với bình luận
        str = '<button class="reply-cmt" onclick="reply_cmt('+ idCmt +')"><img'
                    +' src="DiDongZin/assets/img/left_2_30px.png">Trả lời</button>'
                +'<button class="edit-cmt" onclick="edit_cmt('+ idCmt +')"><img'
                    +' src="DiDongZin/assets/img/design_30px.png">Chỉnh sửa</button>'
                +'<button class="del-cmt" onclick="delete_cmt('+ idCmt +')"><img'
                    +' src="DiDongZin/assets/img/trash_can_30px.png">Xóa</button>';
        document.getElementById("action-cmt"+idCmt).innerHTML = str;
    }

    // XÓA BÌNH LUẬN CHA
    function delete_cmt(idCmt)
    {
        if(confirm("Bạn sẽ xóa bình luận này?"))
        {
            document.getElementById('parent-cmt'+idCmt).hidden = true;

            // Xóa bình luận cha, khi xóa không quan tâm đến noiDung, nên gán tạm noiDung=0
            CapNhatBinhLuan('xoa', idCmt, '0');
        }
    }

    //----------- THAO TÁC VỚI BÌNH LUẬN CON ----------------------------------
    function edit_childCmt(idChildCmt)
    {
        noiDung = document.getElementById("content-childCmt"+idChildCmt).innerHTML;
        noiDung = noiDung.trim();
        updateFrame = "<div class='new-comment'>"
                        +"<textarea rows='2' cols='48' placeholder='Chỉnh sửa nội dung' id='content-update"+ idChildCmt +"'>"+ noiDung +"</textarea>"
                        +"<input type='hidden' id='content-temp"+ idChildCmt +"' value='"+ noiDung +"'>"
                        +"<button onclick='btnLuu_childCmt("+ idChildCmt +")'>Lưu</button>"
                        +"<button class='cancle' onclick='btnHuy_childCmt("+ idChildCmt +")'>Hủy</button>"
                    +"</div>";
        document.getElementById("content-childCmt"+idChildCmt).innerHTML = updateFrame;
        document.getElementById("action-childCmt"+idChildCmt).innerHTML = '';
    }

    function btnLuu_childCmt(idChildCmt)
    {
        noiDung = document.getElementById('content-update'+idChildCmt).value;
        noiDung = noiDung.trim();
        document.getElementById('content-childCmt'+idChildCmt).innerHTML = noiDung;

        //Hiển thị lại các action cho bình luận con
        str =   '<button class="edit-cmt" onclick="edit_childCmt('+ idChildCmt +')"><img'
                    +' src="DiDongZin/assets/img/design_30px.png">Chỉnh sửa</button>'
                +'<button class="del-cmt" onclick="delete_childCmt('+ idChildCmt +')"><img'
                    +' src="DiDongZin/assets/img/trash_can_30px.png">Xóa</button>';
        document.getElementById('action-childCmt'+idChildCmt).innerHTML = str;

        // Cập nhật bình luận con
        CapNhatBinhLuan('sua', idChildCmt, noiDung);
    }

    function btnHuy_childCmt(idChildCmt)
    {
        noiDungCu = document.getElementById('content-temp'+idChildCmt).value;
        document.getElementById('content-childCmt'+idChildCmt).innerHTML = noiDungCu;

        //Hiển thị lại các action cho bình luận con
        str =   '<button class="edit-cmt" onclick="edit_childCmt('+ idChildCmt +')"><img'
                    +' src="DiDongZin/assets/img/design_30px.png">Chỉnh sửa</button>'
                +'<button class="del-cmt" onclick="delete_childCmt('+ idChildCmt +')"><img'
                    +' src="DiDongZin/assets/img/trash_can_30px.png">Xóa</button>';
        document.getElementById('action-childCmt'+idChildCmt).innerHTML = str;
    }

    function delete_childCmt(idChildCmt)
    {
        if(confirm('Bạn sẽ xóa bình luận này?'))
        {
            document.getElementById('child-cmt'+idChildCmt).hidden = true;

            // Xóa bình luận con, khi xóa không quan tâm đến noiDung, nên gán tạm noiDung=0
            CapNhatBinhLuan('xoa', idChildCmt, '0');
        }
    }

    // Kiểm tra người dùng đã đăng nhập hay chưa
    function KiemTraDangNhap()
    {
        idTaiKhoan = document.getElementById('idTaiKhoan').value;
        if(idTaiKhoan == '0')
        {
            alert('Bạn cần phải đăng nhập để có thể tham gia bình luận');
            return false;
        }
        else
        {
            return true;
        }
    }

    // 2 function gọi Ajax cập nhật bình luận
    function ThemBinhLuan(Ma_binh_luan_cha, Noi_dung)
    {
        Ma_dien_thoai = document.getElementById('idDienThoai').value;

        $.get('ThemBinhLuan/'+ Ma_binh_luan_cha +'/'+ Noi_dung +'/'+ Ma_dien_thoai, function(data){
            // Không thay đổi gì trên giao diện khi chạy Ajax Thêm bình luận
        });
    }

    function CapNhatBinhLuan(loai, Ma_binh_luan, Noi_dung)
    {
        $.get('CapNhatBinhLuan/'+ loai +'/'+ Ma_binh_luan +'/'+ Noi_dung, function(data){
            // Không thay đổi gì trên giao diện khi chạy Ajax Cập nhật bình luận
        });
    }
</script>

@endsection