<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;;

use App\TaiKhoan;
use App\DienThoaiDiDong;
use App\BinhLuan;
use App\GioHang;
use App\ChiTietGioHang;
use App\HoaDon;

class UserController extends Controller
{
    function getTrangChu()
    {
        $soLuongDT = DienThoaiDiDong::where('Dang_ban', '=', 1)->count();
        $dsDienThoai;

        //Danh sách điện thoại ---------------------------------------------------------
        if($soLuongDT >= 12)
        {
            $dsDienThoai = DienThoaiDiDong::where('Dang_ban', '=', 1)->orderBy('Ma_dien_thoai', 'desc')->take(12)->get();
        }
        else
        {
            $dsDienThoai = DienThoaiDiDong::where('Dang_ban', '=', 1)->orderBy('Ma_dien_thoai', 'desc')->get();
        }       
        
        //Danh sách điện thoại bán chạy --------------------------------------------------
        $dsMaDT = array();
        $dsSoLuongBan = array();
        $count = 0;

        $dienThoai = DienThoaiDiDong::where('Dang_ban', '=', 1)->get();
        foreach ($dienThoai as $dt) {
            $dsMaDT[$count] = $dt->Ma_dien_thoai;
            $dsSoLuongBan[$count] = $dt->ToChiTietGioHang->count();
            $count++;
        }
        for ($i=0; $i < count($dsMaDT)-1; $i++) { 
            for ($j=$i+1; $j < count($dsMaDT); $j++) { 
                if($dsSoLuongBan[$i] < $dsSoLuongBan[$j])
                {
                    //SWAP $dsSoLuongBan
                    $temp = $dsSoLuongBan[$i];
                    $dsSoLuongBan[$i] = $dsSoLuongBan[$j];
                    $dsSoLuongBan[$j] = $temp;

                    //SWAP $dsMaDT
                    $temp = $dsMaDT[$i];
                    $dsMaDT[$i] = $dsMaDT[$j];
                    $dsMaDT[$j] = $temp;
                }
            }
        }
        $soLuongToiThieu;
        if(count($dsMaDT) < 6){
            $soLuongToiThieu = count($dsMaDT);
        }
        else{
            $soLuongToiThieu = 6;
        }
            
        $dsMaBanChay = array();
        for ($i=0; $i < $soLuongToiThieu; $i++) { 
            $dsMaBanChay[$i] = $dsMaDT[$i];
        }

        //Danh sách điện thoại giảm giá mạnh -------------------------------------------------
        $dsMaDT = array();
        $dsSoLuongKM = array();
        $count = 0;

            //Lấy ngày hôm nay
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $today = date('Y-m-d');

        $dienThoai = DienThoaiDiDong::where('Dang_ban', '=', 1)->get();
        foreach ($dienThoai as $dt) {
            $hasKM = false;
            $km =$dt->ToKhuyenMai->last();
            if($km !== null)
            {
                if( $km->Tu_ngay<=$today && $today<=$km->Den_ngay )
                {
                    $hasKM = true;
                }
            }
            
            if( $hasKM )
            {
                $dsMaDT[$count] = $dt->Ma_dien_thoai;
                $dsSoLuongKM[$count] = $km->Phan_tram_khuyen_mai;
                $count++;
            }
        }
        for ($i=0; $i < count($dsMaDT)-1; $i++) { 
            for ($j=$i+1; $j < count($dsMaDT); $j++) { 
                if($dsSoLuongKM[$i] < $dsSoLuongKM[$j])
                {
                    //SWAP $dsSoLuongKM
                    $temp = $dsSoLuongKM[$i];
                    $dsSoLuongKM[$i] = $dsSoLuongKM[$j];
                    $dsSoLuongKM[$j] = $temp;

                    //SWAP $dsMaDT
                    $temp = $dsMaDT[$i];
                    $dsMaDT[$i] = $dsMaDT[$j];
                    $dsMaDT[$j] = $temp;
                }
            }
        }
        $soLuongToiThieu;
        if(count($dsMaDT) < 6){
            $soLuongToiThieu = count($dsMaDT);
        }
        else{
            $soLuongToiThieu = 6;
        }
            
        $dsMaGiamGia = array();
        for ($i=0; $i < $soLuongToiThieu; $i++) { 
            $dsMaGiamGia[$i] = $dsMaDT[$i];
        }

        return view('user.content', ['dsDienThoai'=>$dsDienThoai, 'dsMaBanChay'=>$dsMaBanChay, 'dsMaGiamGia'=>$dsMaGiamGia]);
    }
    
    function postDangNhap(Request $request)
    {
        $uid = $request->username;
        $pass = $request->password;

        if(Auth::attempt(['Username'=>$uid, 'password'=>$pass]))
        {
            //Nếu biến count đã tồn tại rồi (đã chọn thêm vào giỏ hàng trước khi đăng nhập)
            if( session()->has('count') )
            {
                // KIỂM TRA CÓ TỒN TẠI GIỎ HÀNG KHÔNG
                $hasGioHang = false;
                $maTK = Auth::user()->Ma_tai_khoan;
                $gioHang = TaiKhoan::find($maTK)->ToGioHang->last();
                if($gioHang !== null)
                {
                    if($gioHang->Da_thanh_toan == 0)
                    {
                        $hasGioHang = true;
                    }
                }
                //Nếu chưa tồn tại giỏ hàng, thì tạo giỏ hàng mới
                if( !$hasGioHang )
                {
                    $gioHang = new GioHang;
                    $gioHang->Ma_gio_hang = GioHang::all()->max('Ma_gio_hang') + 1;
                    $gioHang->Da_thanh_toan = 0;
                    $gioHang->Ma_tai_khoan = $maTK;

                    $gioHang->save();
                }

                //Lấy giỏ hàng ra dùng
                $gioHang = TaiKhoan::find($maTK)->ToGioHang->last();

                $count = session()->get('count');
                // Gọi những điện thoại trước đó ra để thêm vào giỏ hàng
                for ($i=0; $i < $count; $i++) { 
                    $maDT = session()->get('dt'.$i);
                    $soLuongDT = session()->get('sl'.$i);

                    //Kiểm tra chiTiet này đã có trong giỏ hàng chưa, nếu có rồi thì bỏ qua
                    $countChiTiet = ChiTietGioHang::where([
                                    ['Ma_dien_thoai', '=', $maDT],
                                    ['Ma_gio_hang', '=', $gioHang->Ma_gio_hang]
                                ])->count();
                    if($countChiTiet == 0)
                    {
                        //Lưu chi tiết giỏ hàng mới (của những điện thoại đã thêm vào khi chưa đăng nhập)
                        $chiTiet = new ChiTietGioHang;
                        $chiTiet->Ma_dien_thoai = $maDT;
                        $chiTiet->Ma_gio_hang = $gioHang->Ma_gio_hang;
                        $chiTiet->Ma_gia_ban = DienThoaiDiDong::find($maDT)->ToGiaBan->last()->Ma_gia_ban;
                        $chiTiet->So_luong = $soLuongDT;

                        $chiTiet->save();
                    }                                            
                }
                // Sau khi đã xử lý những session lưu mã điện thoại xong, ta xóa những session này
                for ($i=0; $i < $count; $i++) { 
                    session()->forget('dt'.$i);
                    session()->forget('sl'.$i);
                }
                session()->forget('count');
            }          
            return redirect('TrangChu');
        }
        else
        {
            return redirect('TrangChu')->with('thongBaoDangNhap', 'Đăng nhập thất bại');
        }
    }

    function postDangKy(Request $request)
    {
        if(is_numeric($request->hoVaTenLot))
        {
            return redirect('TrangChu')->with('loiDangKy', 'Họ và tên lót không được là số');
        }

        if(is_numeric($request->ten))
        {
            return redirect('TrangChu')->with('loiDangKy', 'Tên không được là số');
        }

        $this->validate($request, 
            [
                'hoVaTenLot'=>'required|max:50',
                'ten'=>'required|max:20',
                'username2'=>'required|unique:Tai_khoan,Username',
                'password2'=>'required',
                're_password2'=>'same:password2'
            ], 
            [
                'hoVaTenLot.required'=>'Họ và tên lót bắt buộc phải nhập',
                'hoVaTenLot.max'=>'Họ và tên lót tối đa 50 ký tự',
                'ten.required'=>'Tên bắt buộc phải nhập',
                'ten.max'=>'Tên tối đa 50 ký tự',
                'username2.required'=>'Tên đăng nhập bắt buộc phải nhập',
                'username2.unique'=>'Tên đăng nhập đã bị trùng',
                'password2.required'=>'Mật khẩu bắt buộc phải nhập',
                're_password2.same'=>'Mật khẩu nhập lại không chính xác'
            ]);
        $user = new TaiKhoan;
        $user->Ma_tai_khoan = TaiKhoan::all()->max('Ma_tai_khoan') + 1;
        $user->Username = $request->username2;
        $user->password = bcrypt($request->password2);
        $user->Ho_va_ten_lot = $request->hoVaTenLot;
        $user->Ten = $request->ten;
        $user->Tai_khoan_admin = 0;
        
        $user->save();
        return redirect('TrangChu')->with('thongBaoDangKy', 'Bạn đã đăng ký thành công tài khoản, bạn có thể đăng nhập vào hệ thống');
    }

    function getDangXuat()
    {
        if(Auth::check())
        {
            Auth::logout();
            return redirect('TrangChu')->with('dangXuat', 'Đăng xuất thành công');
        }
        else
            return redirect('TrangChu');
    }


    // ===========================================================================================
    // ---------------- CÁC TRANG QUẢN LÝ TÀI KHOẢN ----------------------------------------------
    // ===========================================================================================
        // THÔNG TIN CÁ NHÂN
    function getThongTinCaNhan()
    {
        return view('user.account.ThongTin', ['fileCSS'=>'taiKhoan']);
    }

    function postCapNhatThongTin(Request $request)
    {
        $this->validate($request, 
            [
                'fullname'=>'required',
                'avatar'=>'image|mimes:png,jpg,jpeg'
            ], 
            [
                'fullname.required'=>'Họ và tên không được trống',
                'avatar.image'=>'Ảnh đại diện phải là hình ảnh',
                'avatar.mimes'=>'Ảnh đại diện thuộc 1 trong các định dạng png, jpg, jpeg'
            ]);
        $hoTen = $request->fullname;
        $viTri = strrpos($hoTen, ' ');
        $ten = '';
        $hoVaTenLot = '';
            // Họ tên phải bao gồm họ tên lót và tên
        if($viTri != '')
        {
            $ten = substr($hoTen, $viTri + 1, strlen($hoTen));
            $hoVaTenLot = substr($hoTen, 0, $viTri);
        }
        else
        {
            return redirect('taikhoan/ThongTinCaNhan')->with('thongBaoCapNhat', 'Họ tên phải bao gồm họ tên lót và tên');
        }
        
        $id = Auth::user()->Ma_tai_khoan;
        $user = TaiKhoan::find($id);

        // Gán tên mới và di chuyển file ảnh đại diện
        if($request->avatar != "")
        {
            $file = $request->file('avatar');
            $tenHinh = $file->getClientOriginalName();
            $tenHinh = Str::random(4) .'_'. $tenHinh;
            while( file_exists('DiDongZin/avatar/'.$tenHinh))
            {
                $tenHinh = Str::random(4) .'_'. $tenHinh;
            }
            $file->move('DiDongZin/avatar', $tenHinh);

            $user->URL_Avatar = $tenHinh;
        }
        
        $user->Ho_va_ten_lot = $hoVaTenLot;
        $user->Ten = $ten;
        $user->Ngay_sinh = $request->dateOfBirth;
        $user->Gioi_tinh = $request->sex;
        $user->Dia_chi = $request->address;
        $user->So_dien_thoai = $request->phonenumber;

        $user->save();
        return redirect('taikhoan/ThongTinCaNhan')->with('thongBaoCapNhat', 'Cập nhật thông tin thành công');
    }
        // THÔNG TIN ĐĂNG NHẬP
    function getCapNhatTaiKhoan()
    {
        return view('user.account.ThongTinDangNhap', ['fileCSS'=>'taiKhoan']);
    }

    function postCapNhatThongTinDangNhap(Request $request)
    {
        $this->validate($request, 
            [
                'password'=>'required',
                'newPassword'=>'required',
                'reNewPassword'=>'same:newPassword'
            ], 
            [
                'password.required'=>'Mật khẩu hiện tại không được trống',
                'newPassword.required'=>'Mật khẩu mới không được trống',
                'reNewPassword.same'=>'Nhập lại mật khẩu mới không chính xác'
            ]);
        if(Auth::attempt(['Username'=>$request->username, 'password'=>$request->password]))
        {
            $ma = Auth::user()->Ma_tai_khoan;
            $user = TaiKhoan::find($ma);
            $user->password = bcrypt($request->newPassword);

            $user->save();
            return redirect('taikhoan/CapNhatTaiKhoan')->with('thongBaoCapNhat', 'Cập nhật mật khẩu thành công');
        }
        else
        {
            return redirect('taikhoan/CapNhatTaiKhoan')->with('thongBaoCapNhat', 'Mật khẩu hiện tại không đúng');
        }
    }

        // THÔNG TIN ĐƠN HÀNG
    function getDonHang()
    {
        $user = TaiKhoan::find( Auth::user()->Ma_tai_khoan );
        $dsGioHang = $user->ToGioHang;
        $dsMaDaHoanThanh = array();
        $dsMaChuaHoanThanh = array();
        
        foreach ($dsGioHang as $gioHang) {
            if($gioHang->Da_thanh_toan == 1)
            {
                $hoaDon = $gioHang->ToHoaDon;
                if($hoaDon->Trang_thai == 1)
                {
                    $count = count($dsMaDaHoanThanh);
                    $dsMaDaHoanThanh[$count] = $hoaDon->Ma_hoa_don;
                }
                else if($hoaDon->Trang_thai == 0)
                {
                    $count = count($dsMaChuaHoanThanh);
                    $dsMaChuaHoanThanh[$count] = $hoaDon->Ma_hoa_don;
                }
            }
        }

        return view('user.account.DonHang', ['fileCSS'=>'taiKhoan_donHang', 'dsMaDaHoanThanh'=>$dsMaDaHoanThanh, 'dsMaChuaHoanThanh'=>$dsMaChuaHoanThanh]);
    }

    function getHuyDonHang($id)
    {
        $hoaDon = HoaDon::find($id);
        $gioHang = $hoaDon->ToGioHang;

        // Xóa chi tiết giỏ hàng có liên quan
        DB::table('Chi_tiet_gio_hang')->where('Ma_gio_hang', '=', $gioHang->Ma_gio_hang)->delete();

        // Xóa hóa đơn, và giỏ hàng
        $hoaDon->delete();
        $gioHang->delete();
        
        return redirect('taikhoan/DonHang')->with('thongBaoHuy', 'Bạn đã hủy đơn hàng thành công');
    }

    function getChiTietDonHang($id)
    {
        $hoaDon = HoaDon::find($id);
        return view('user.account.ChiTietDonHang', ['fileCSS'=>'taiKhoan_donHang', 'hoaDon'=>$hoaDon]);
    }

        // CÀI ĐẶT
    function getCaiDat()
    {
        return view('user.account.CaiDat', ['fileCSS'=>'taiKhoan']);
    }


    // ===========================================================================================
    // ---------------- HIỂN THỊ CHI TIẾT ĐIỆN THOẠI ---------------------------------------------
    // ===========================================================================================
    function ShowPhone($id)
    {
        $dienThoai = DienThoaiDiDong::find($id);
        $dsBinhLuan = $dienThoai->ToBinhLuan;
        return view('user.DienThoai', ['fileCSS'=>'dienThoai', 'dienThoai'=>$dienThoai, 'dsBinhLuan'=>$dsBinhLuan]);
    }


    // ===========================================================================================
    // ---------------- THANH TOÁN GIỎ HÀNG ------------------------------------------------------
    // ===========================================================================================
    function getThanhToanGioHang()
    {
        $dsMaDienThoai = array();
        $dsSoLuongTheoMa = array();
        $hasGioHang = false;
        if(Auth::check())
            // KHI ĐÃ ĐĂNG NHẬP
        {
            $maTK = Auth::user()->Ma_tai_khoan;
            $gioHang = TaiKhoan::find($maTK)->ToGioHang->last();
            if($gioHang !== null)
            {
                if($gioHang->Da_thanh_toan == 0)
                {
                    $hasGioHang = true;
                }
            }

            if( $hasGioHang )
            {
                $dsChiTietGioHang = $gioHang->ToChiTietGioHang;
                $count = 0;
                foreach ($dsChiTietGioHang as $chiTiet) {
                    $count = count($dsMaDienThoai);
                    $dsMaDienThoai[$count] = $chiTiet->Ma_dien_thoai;
                    $dsSoLuongTheoMa[$count] = $chiTiet->So_luong;
                }
            }
        }
        else
            // KHI CHƯA ĐĂNG NHẬP
        {
            //Nếu biến count đã được tạo
            if( session()->has('count') )
            {
                $soLuongDT = session()->get('count');

                // Đưa các điện thoại trong giỏ hàng vào dsMaDienThoai để hiện ra màn hình
                for ($i=0; $i < $soLuongDT; $i++) { 
                    $maDT = session()->get('dt'.$i);
                    $soLuong = session()->get('sl'.$i);

                    $count = count($dsMaDienThoai);
                    $dsMaDienThoai[$count] = $maDT;
                    $dsSoLuongTheoMa[$count] = $soLuong;
                }
            }            
        }
        return view('user.DatHang', ['fileCSS'=>'datHang', 'dsMaDienThoai'=>$dsMaDienThoai, 'dsSoLuongTheoMa'=>$dsSoLuongTheoMa]);
    }

    function getThemVaoGioHang($ma)
    {
            // ĐÃ ĐĂNG NHẬP
        if(Auth::check())
        {
            //KIỂM TRA CÓ TỒN TẠI GIỎ HÀNG KHÔNG
            $hasGioHang = false;
            $maTK = Auth::user()->Ma_tai_khoan;
            $gioHang = TaiKhoan::find($maTK)->ToGioHang->last();
            if($gioHang !== null)
            {
                if($gioHang->Da_thanh_toan == 0)
                {
                    $hasGioHang = true;
                }
            }
            if( !$hasGioHang )
            {
                $gioHang = new GioHang;
                $gioHang->Ma_gio_hang = GioHang::all()->max('Ma_gio_hang') + 1;
                $gioHang->Da_thanh_toan = 0;
                $gioHang->Ma_tai_khoan = $maTK;

                $gioHang->save();
            }

            //Lấy giỏ hàng ra dùng
            $gioHang = TaiKhoan::find($maTK)->ToGioHang->last();

            //Lấy điện thoại có mã vừa chọn ra
            $countChiTiet = ChiTietGioHang::where([
                ['Ma_dien_thoai', '=', $ma],
                ['Ma_gio_hang', '=', $gioHang->Ma_gio_hang]
            ])->count();

            //Kiểm tra điện thoại đã tồn tại trong giỏ hàng chưa
            if($countChiTiet == 0)
            {
                //Chưa tồn tại, lưu điện thoại vừa chọn vào giỏ hàng 
                $chiTiet = new ChiTietGioHang;
                $chiTiet->Ma_dien_thoai = $ma;
                $chiTiet->Ma_gio_hang = $gioHang->Ma_gio_hang;
                $chiTiet->Ma_gia_ban = DienThoaiDiDong::find($ma)->ToGiaBan->last()->Ma_gia_ban;
                $chiTiet->So_luong = 1;

                $chiTiet->save();
            }        
        }
        else
            // CHƯA ĐĂNG NHẬP
        {
            //Nếu biến count chưa được tạo
            if( !session()->has('count') )
            {
                session()->put('count', 0);
            }

            $count = session()->get('count');
            //Tạo session lưu mã, số lượng của điện thoại vừa được chọn
            session()->put('dt'.$count, $ma);
            session()->put('sl'.$count, 1);
            $count++;
            session()->put('count', $count);
        }
        return redirect('DienThoai/'. $ma .'.html');
    }

    function postTaoDonHang(Request $request)
    {
        //Thiết lập giờ tại khu vục
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        
        $this->validate($request, 
            [
                'tenKhachHang'=>'required',
                'soDT'=>'required',
                'diaChi'=>'required'
            ], 
            [
                'tenKhachHang.required'=>'Tên khách hàng không được trống',
                'soDT.required'=>'Số điện thoại không được trống',
                'diaChi.required'=>'Địa chỉ giao hàng không được trống'
            ]);

        if($request->hinhthuc == 'Thanh toán Online')
        {
            $this->validate($request, 
                [
                    'tenChuThe'=>'required',
                    'soThe'=>'required',
                    'CVV'=>'required',
                ], 
                [
                    'tenChuThe.required'=>'Tên chủ thẻ không được trống',
                    'soThe.required'=>'Số thẻ không được trống',
                    'CVV.required'=>'CVV không được trống'
                ]);
            $month = date('m');
            $year  = date('Y');
            if(($request->namHetHan < $year) || ($request->namHetHan == $year && $request->thangHetHan <= $month))
            {
                return redirect('ThanhToanGioHang')->with('thongBaoTaoDonHang', 'Thẻ của bạn phải còn hạn dùng ít nhất một tháng mới có thể thực hiện đặt hàng');
            }
        }
 
        // Kiểm tra có giỏ hàng chưa
        $user = TaiKhoan::find(Auth::user()->Ma_tai_khoan);
        
        // Lấy giỏ hàng cuối cùng
            // Nếu tồn tại giỏ hàng, Da_thanh_toan = 0, số hàng hóa trong giỏ hàng > 0
                // => Có giỏ hàng hợp lệ
        $gioHang = $user->ToGioHang->last();
        $hasBasket = false;
        if($gioHang != null)
        {
            if( ($gioHang->Da_thanh_toan == 0) && (count($gioHang->ToChiTietGioHang) > 0) )
            {
                $hasBasket = true;                
            }
        }

        if( $hasBasket )
        {
            // Lấy ngày giờ hiện tại
            $now = date('Y-m-d H:i:s');

            $hoaDon = new HoaDon;
            $hoaDon->Ma_hoa_don = HoaDon::all()->max('Ma_hoa_don') + 1;
            $hoaDon->Ma_gio_hang = $gioHang->Ma_gio_hang;
            $hoaDon->Ma_tai_khoan = Auth::user()->Ma_tai_khoan;
            $hoaDon->Ngay_tao = $now;
            $hoaDon->Hinh_thuc_thanh_toan = $request->hinhthuc;
            $hoaDon->Dia_chi_nhan_hang = $request->diaChi;
            $hoaDon->Thue_VAT = 10;
            $hoaDon->Trang_thai = 0;
            $hoaDon->save();

            // Sửa Da_thanh_toan = 1 trong giỏ hàng
            $gioHang->Da_thanh_toan = 1;
            $gioHang->save();

            // Lưu địa chỉ và số điện thoại của người dùng, nếu trong thông tin cá nhân còn trống
            if($user->Dia_chi == '' || $user->So_dien_thoai == '')
            {
                $user->Dia_chi = $request->diaChi;
                $user->So_dien_thoai = $request->soDT;
                $user->save();
            }

            return redirect('ThanhToanGioHang')->with('thongBaoTaoDonHang', 'Bạn đã tạo đơn hàng thành công');
        }
        else
        {
            return redirect('ThanhToanGioHang')->with('thongBaoTaoDonHang', 'Trong giỏ hàng của bạn không có điện thoại nào nên không thể tạo đơn hàng');
        }
    }

    //THỰC HIỆN AJAX VIỆC TĂNG GIẢM SỐ LƯỢNG KHI ĐÃ ĐĂNG NHẬP
    function getTangGiamSoLuongCHECKED_AJAX($loai, $maDT, $maGioHang, $soLuong)
    {
        if($loai == 'sua')
        {
            DB::table('Chi_tiet_gio_hang')->where([
                    ['Ma_dien_thoai', '=', $maDT],
                    ['Ma_gio_hang', '=', $maGioHang]
                ])->update(['So_luong'=>$soLuong]);
        }
        else if($loai == 'xoa')
        {
            DB::table('Chi_tiet_gio_hang')->where([
                ['Ma_dien_thoai', '=', $maDT],
                ['Ma_gio_hang', '=', $maGioHang]
            ])->delete();
        }
    }

    //THỰC HIỆN AJAX VIỆC TĂNG GIẢM SỐ LƯỢNG KHI CHƯA ĐĂNG NHẬP
    function getTangGiamSoLuongUNCHECK_AJAX($loai, $maDT, $soLuong)
    {
        $soLuongDT = session()->get('count');
        $viTri = 0;
        for ($i=0; $i < $soLuongDT; $i++) { 
            $id = session()->get('dt'.$i);
            if($id == $maDT)
            {
                $viTri = $i;
                break;
            }
        }

        if($loai == 'sua')
        {
            //Sửa lại số lượng ngay chính vị trí đó
            session()->put('sl'.$viTri, $soLuong);
        }
        else if($loai == 'xoa')
        {
            //Đi từ vị trí tìm thấy đến vị trí cuối cùng -1
            for ($i=$viTri; $i < $soLuongDT-1; $i++) { 
                //Lấy mã của vị trí phía sau, chồng lên mã của vị trí phía trước
                $ma = session()->get('dt'.($i+1));

                session()->put('dt'.$i, $ma);
            }
            // Xóa session chứa mã và số lượng cuối cùng, và giảm count
            $soLuongDT--;
            session()->forget('dt'.$soLuongDT);
            session()->forget('sl'.$soLuongDT);

            session()->put('count', $soLuongDT);
        }
    }


    
    // function suaPassUser()
    // {
    //     $taiKhoan = TaiKhoan::find(4);
    //     // $taiKhoan->Username = 'abc6';
    //     $taiKhoan->Password = bcrypt('123456');
    //     // $taiKhoan->Ho_va_ten_lot = 'Le Minh';
    //     // $taiKhoan->Ten = 'Hai';
    //     // $taiKhoan->Ngay_sinh = '1999-02-26';
    //     // $taiKhoan->Gioi_tinh = 1;
    //     // $taiKhoan->Dia_chi = 'Kien giang';
    //     // $taiKhoan->So_dien_thoai = '0235632569';
    //     // $taiKhoan->URL_Avatar = 'acsac.png';
    //     // $taiKhoan->Tai_khoan_admin = 1;

    //     $taiKhoan->save();
    //     echo 'Sua tai khoan thanh cong';
    // }
}
