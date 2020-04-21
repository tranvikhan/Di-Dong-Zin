<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\DienThoaiDiDong;
use App\HangDienThoaiDiDong;
use App\KhuyenMai;
use App\GiaBan;
use App\ChiTietGioHang;
use App\GioHang;

class DienThoaiController extends Controller
{
    public function getDanhSach()
    {
        $dienthoai = DienThoaiDiDong::all();
        $hangDT = HangDienThoaiDiDong::all();
        return view('admin.DienThoai.DanhSach', ['dienthoai'=>$dienthoai, 'hangDT'=>$hangDT]);
    }

    public function getThem()
    {
        $hangDT = HangDienThoaiDiDong::all();
        return view('admin.DienThoai.Them', ['hangDT'=>$hangDT]);
    }

    public function postThem(Request $request)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $today = date('Y-m-d');

        //MÃ ĐIỆN THOẠI SẼ ĐƯỢC TẠO
        $maDienThoai = DienThoaiDiDong::all()->max('Ma_dien_thoai') + 1;

        $this->validate($request, 
            [
                'kichThuoc'=>'max:50',
                'chipset'=>'max:50',
                'loaiManHinh'=>'max:50',
                'kichThuocManHinh'=>'max:50',
                'doPhanGiaiManHinh'=>'max:50',
                'wifi'=>'max:50',
                'bluetooth'=>'max:50',
                'nfc'=>'max:50',
                'heDieuHanh'=>'max:50',
                'phienBanHeDieuHanh'=>'max:50',
                'quayVideo'=>'max:100',
                'camBien'=>'max:100',
                'kheSim'=>'max:100',
                'kheTheNho'=>'max:100',
                'tenDienThoai'=>'required|max:100',
                'hangDienThoai'=>'required',
                'moTa'=>'max:2000',
                'giaBan'=>'required',
                'anhSanPham'=>'required|mimes:png,jpg,jpeg'
            ], 
            [
                'kichThuoc.max'=>'Kích thước phải được nhập theo dài x rộng x dày, không cần nhập đơn vị, không được nhập dấu cách (để nhập hai phẩy năm=>2.5, đơn vị là mm)',
                
                'chipset.max'=>'Chipset chỉ được tối đa 50 ký tự',
                
                'loaiManHinh.max'=>'Loại màn hình chỉ được tối đa 50 ký tự',
                
                'kichThuocManHinh.max'=>'Kích thước màn hình chỉ được tối đa 50 ký tự',
                
                'doPhanGiaiManHinh.max'=>'Độ phân giải màn hình chỉ được tối đa 50 ký tự',
                
                'wifi.max'=>'Wifi chỉ được tối đa 50 ký tự',
                
                'bluetooth.max'=>'Bluetooth chỉ được tối đa 50 ký tự',
                
                'nfc.max'=>'NFC chỉ được tối đa 50 ký tự',

                'heDieuHanh.max'=>'Hệ điều hành chỉ được tối đa 50 ký tự',
                
                'phienBanHeDieuHanh.max'=>'Phiên bản hệ điều hành chỉ được tối đa 50 ký tự',
                
                'quayVideo.max'=>'Quay Video chỉ được tối đa 100 ký tự',
                
                'camBien.max'=>'Cảm biến chỉ được tối đa 100 ký tự',
                
                'kheSim.max'=>'Khe sim chỉ được tối đa 100 ký tự',
                
                'kheTheNho.max'=>'Khe thẻ nhớ chỉ được tối đa 100 ký tự',
                
                'tenDienThoai.required'=>'Tên điện thoại không được trống',
                'tenDienThoai.max'=>'Tên điện thoại chỉ được tối đa 100 ký tự',
                
                'hangDienThoai.required'=>'Hãng điện thoại bắt buộc phải chọn',
                
                'moTa.max'=>'Mô tả chỉ được tối đa 2000 ký tự',
                
                'giaBan.required'=>'Giá bán không được trống',
                
                'anhSanPham.required'=>'Hình ảnh phải được chọn',
                'anhSanPham.mimes'=>'Hình ảnh sản phẩm phải thuộc định dạng sau: png, jpg, jpeg'
            ]);
        
        if($request->apDungKM == 'on')
        {
            $this->validate($request, 
                [
                    'phanTramGiamGia'=>'required',
                    'quaTang'=>'required|max:400',
                    'tuNgay'=>'required|after_or_equal:'. $today,
                    'denNgay'=>'required|after_or_equal:tuNgay'
                ], 
                [
                    'phanTramGiamGia.required'=>'Phần trăm giảm giá không được trống',
                
                    'quaTang.required'=>'Quà tặng không được trống',
                    'quaTang.max'=>'Quà tặng chỉ được tối đa 50 ký tự',
                    
                    'tuNgay.required'=>'Ngày bắt đầu khuyến mãi không được trống',
                    'tuNgay.after_or_equal'=>'Ngày bắt đầu khuyến mãi phải từ ngày hôm nay trở về sau',
                
                    'denNgay.required'=>'Ngày kết thúc khuyến mãi không được trống',
                    'denNgay.after_or_equal'=>'Ngày kết thúc khuyến mãi phải sau ngày bắt đầu khuyến mãi',
                ]);
        }
        
        //DI CHUYỂN FILE
        $file = $request->file('anhSanPham');
        $ten = $file->getClientOriginalName();
        $ten = Str::random(4) .'_'. $ten;
        while(file_exists('DiDongZin/imagePhone/'.$ten))
        {
            $ten = Str::random(4) .'_'. $ten;
        }
        $file->move('DiDongZin/imagePhone', $ten);
        
        //TẠO ĐIỆN THOẠI
        $dienThoai = new DienThoaiDiDong;
        $dienThoai->Ma_dien_thoai = $maDienThoai;
        $dienThoai->Dang_ban = 1;
        $dienThoai->Ten_dien_thoai = $request->tenDienThoai;
        $dienThoai->Hinh_anh = $ten;
        $dienThoai->Mo_ta = $request->moTa;
        $dienThoai->Kich_thuoc = $request->kichThuoc;
        $dienThoai->Trong_luong = $request->trongLuong;
        $dienThoai->RAM = $request->ram;
        $dienThoai->ROM = $request->rom;
        $dienThoai->Kich_thuoc_man_hinh = $request->kichThuocManHinh;
        $dienThoai->Chipset = $request->chipset;
        $dienThoai->Loai_man_hinh = $request->loaiManHinh;
        $dienThoai->Do_phan_giai_man_hinh = $request->doPhanGiaiManHinh;
        $dienThoai->Camera_sau = $request->cameraSau;
        $dienThoai->Camera_truoc = $request->cameraTruoc;
        $dienThoai->Wifi = $request->wifi;
        $dienThoai->Bluetooth = $request->bluetooth;
        $dienThoai->NFC = $request->nfc;
        $dienThoai->Pin = $request->pin;
        $dienThoai->OS = $request->heDieuHanh;
        $dienThoai->Phien_ban_OS = $request->phienBanHeDieuHanh;
        $dienThoai->Quay_video = $request->quayVideo;
        $dienThoai->Cam_bien = $request->camBien;
        $dienThoai->Khe_sim = $request->kheSim;
        $dienThoai->Khe_the_nho = $request->kheTheNho;
        $dienThoai->Ma_hang_dien_thoai = $request->hangDienThoai;
        $dienThoai->save();

        //TẠO KHUYẾN MÃI
        if($request->apDungKM == 'on')
        {
            $khuyenMai = new KhuyenMai;
            $khuyenMai->Tu_ngay = $request->tuNgay;
            $khuyenMai->Den_ngay = $request->denNgay;
            $khuyenMai->Phan_tram_khuyen_mai = $request->phanTramGiamGia;
            $khuyenMai->Noi_dung = $request->quaTang;
            $khuyenMai->Ma_dien_thoai = $maDienThoai;
            $khuyenMai->save();
        }

        //TẠO GIÁ BÁN
        $giaBan = new GiaBan;
        $giaBan->Gia = $request->giaBan;
        $giaBan->Ngay_cap_nhat = $today;
        $giaBan->Trang_thai = 1;
        $giaBan->Ma_dien_thoai = $maDienThoai;
        $giaBan->save();

        return redirect('admin/dienthoai/them')->with('thongbao', 'Thêm điện thoại thành công');
    }

    public function getSua($id)
    {
        $hangDT = HangDienThoaiDiDong::all();
        $dienThoai = DienThoaiDiDong::find($id);
        return view('admin.DienThoai.Sua', ['hangDT'=>$hangDT, 'dienThoai'=>$dienThoai]);
    }

    public function postSua(Request $request, $id)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $today = date('Y-m-d');

        //Tìm đối tượng điện thoại
        $dienThoai = DienThoaiDiDong::find($id);

        $this->validate($request, 
            [
                'kichThuoc'=>'max:50',
                'chipset'=>'max:50',
                'loaiManHinh'=>'max:50',
                'kichThuocManHinh'=>'max:50',
                'doPhanGiaiManHinh'=>'max:50',
                'wifi'=>'max:50',
                'bluetooth'=>'max:50',
                'nfc'=>'max:50',
                'heDieuHanh'=>'max:50',
                'phienBanHeDieuHanh'=>'max:50',
                'quayVideo'=>'max:100',
                'camBien'=>'max:100',
                'kheSim'=>'max:100',
                'kheTheNho'=>'max:100',
                'tenDienThoai'=>'required|max:100',
                'hangDienThoai'=>'required',
                'moTa'=>'max:2000',
                'giaBan'=>'required',
                'anhSanPham'=>'mimes:png,jpg,jpeg'
            ], 
            [
                'kichThuoc.max'=>'Kích thước phải được nhập theo dài x rộng x dày, không cần nhập đơn vị, không được nhập dấu cách (để nhập hai phẩy năm=>2.5, đơn vị là mm)',
                
                'chipset.max'=>'Chipset chỉ được tối đa 50 ký tự',
                
                'loaiManHinh.max'=>'Loại màn hình chỉ được tối đa 50 ký tự',
                
                'kichThuocManHinh.max'=>'Kích thước màn hình chỉ được tối đa 50 ký tự',
                
                'doPhanGiaiManHinh.max'=>'Độ phân giải màn hình chỉ được tối đa 50 ký tự',
                
                'wifi.max'=>'Wifi chỉ được tối đa 50 ký tự',
                
                'bluetooth.max'=>'Bluetooth chỉ được tối đa 50 ký tự',
                
                'nfc.max'=>'NFC chỉ được tối đa 50 ký tự',

                'heDieuHanh.max'=>'Hệ điều hành chỉ được tối đa 50 ký tự',
                
                'phienBanHeDieuHanh.max'=>'Phiên bản hệ điều hành chỉ được tối đa 50 ký tự',
                
                'quayVideo.max'=>'Quay Video chỉ được tối đa 100 ký tự',
                
                'camBien.max'=>'Cảm biến chỉ được tối đa 100 ký tự',
                
                'kheSim.max'=>'Khe sim chỉ được tối đa 100 ký tự',
                
                'kheTheNho.max'=>'Khe thẻ nhớ chỉ được tối đa 100 ký tự',
                
                'tenDienThoai.required'=>'Tên điện thoại không được trống',
                'tenDienThoai.max'=>'Tên điện thoại chỉ được tối đa 100 ký tự',
                
                'hangDienThoai.required'=>'Hãng điện thoại bắt buộc phải chọn',
                
                'moTa.max'=>'Mô tả chỉ được tối đa 2000 ký tự',
                
                'giaBan.required'=>'Giá bán không được trống',
                
                'anhSanPham.mimes'=>'Hình ảnh sản phẩm phải thuộc định dạng sau: png, jpg, jpeg'
            ]);
        
        if($request->apDungKM == 'on')
        {
            $this->validate($request, 
                [
                    'phanTramGiamGia'=>'required',
                    'quaTang'=>'required|max:400',
                    'tuNgay'=>'required',
                    'denNgay'=>'required|after_or_equal:tuNgay'
                ], 
                [
                    'phanTramGiamGia.required'=>'Phần trăm giảm giá không được trống',
                
                    'quaTang.required'=>'Quà tặng không được trống',
                    'quaTang.max'=>'Quà tặng chỉ được tối đa 50 ký tự',
                    
                    'tuNgay.required'=>'Ngày bắt đầu khuyến mãi không được trống',
                
                    'denNgay.required'=>'Ngày kết thúc khuyến mãi không được trống',
                    'denNgay.after_or_equal'=>'Ngày kết thúc khuyến mãi phải sau ngày bắt đầu khuyến mãi',
                ]);

            //Xác định có khuyến mãi hiện tại mà ngày bắt đầu trước ngày hôm nay không?
            $hasKM = false;
            $khuyenMai = $dienThoai->ToKhuyenMai->last();
            if( $khuyenMai !== null)
            {
                if($khuyenMai->Tu_ngay<$today && $today<=$khuyenMai->Den_ngay)
                    $hasKM = true;
            }
            //Nếu có khuyến mãi sẽ bỏ qua điều kiện này, do ngày bắt đầu khuyến mãi có thể trước ngày hôm nay
                //Điều kiện này chỉ áp dụng cho:
                    //khuyến mãi có ngày bắt đầu sau
                    //hoặc điện thoại chưa có chương trình khuyến mãi
            if( !$hasKM )
            {
                $this->validate($request, 
                    [
                        'tuNgay'=>'after_or_equal:'.$today, 
                    ], 
                    [
                        'tuNgay.after_or_equal'=>'Ngày bắt đầu khuyến mãi phải từ ngày hôm nay trở về sau',
                    ]);
            }

            //lƯU HOẶC TẠO KHUYẾN MÃI
            if( $khuyenMai === null)
            {
                //TẠO KHUYẾN MÃI
                $KM = new KhuyenMai;
                $KM->Tu_ngay = $request->tuNgay;
                $KM->Den_ngay = $request->denNgay;
                $KM->Phan_tram_khuyen_mai = $request->phanTramGiamGia;
                $KM->Noi_dung = $request->quaTang;
                $KM->Ma_dien_thoai = $dienThoai->Ma_dien_thoai;
                $KM->save();
            }
            else
            {
                //LƯU KHUYẾN MÃI
                $khuyenMai->Tu_ngay = $request->tuNgay;
                $khuyenMai->Den_ngay = $request->denNgay;
                $khuyenMai->Phan_tram_khuyen_mai = $request->phanTramGiamGia;
                $khuyenMai->Noi_dung = $request->quaTang;
                $khuyenMai->Ma_dien_thoai = $dienThoai->Ma_dien_thoai;
                $khuyenMai->save();
            }          
        }
        
        //DI CHUYỂN FILE
        if($request->anhSanPham !== null)
        {
            $file = $request->file('anhSanPham');
            $ten = $file->getClientOriginalName();
            $ten = Str::random(4) .'_'. $ten;
            while(file_exists('DiDongZin/imagePhone/'.$ten))
            {
                $ten = Str::random(4) .'_'. $ten;
            }
            $file->move('DiDongZin/imagePhone', $ten);

            //LƯU LẠI TÊN ẢNH ĐIỆN THOẠI
            $dienThoai->Hinh_anh = $ten;
        }
        
        //LƯU ĐIỆN THOẠI
        $dienThoai->Dang_ban = 1;
        $dienThoai->Ten_dien_thoai = $request->tenDienThoai;
        $dienThoai->Mo_ta = $request->moTa;
        $dienThoai->Kich_thuoc = $request->kichThuoc;
        $dienThoai->Trong_luong = $request->trongLuong;
        $dienThoai->RAM = $request->ram;
        $dienThoai->ROM = $request->rom;
        $dienThoai->Kich_thuoc_man_hinh = $request->kichThuocManHinh;
        $dienThoai->Chipset = $request->chipset;
        $dienThoai->Loai_man_hinh = $request->loaiManHinh;
        $dienThoai->Do_phan_giai_man_hinh = $request->doPhanGiaiManHinh;
        $dienThoai->Camera_sau = $request->cameraSau;
        $dienThoai->Camera_truoc = $request->cameraTruoc;
        $dienThoai->Wifi = $request->wifi;
        $dienThoai->Bluetooth = $request->bluetooth;
        $dienThoai->NFC = $request->nfc;
        $dienThoai->Pin = $request->pin;
        $dienThoai->OS = $request->heDieuHanh;
        $dienThoai->Phien_ban_OS = $request->phienBanHeDieuHanh;
        $dienThoai->Quay_video = $request->quayVideo;
        $dienThoai->Cam_bien = $request->camBien;
        $dienThoai->Khe_sim = $request->kheSim;
        $dienThoai->Khe_the_nho = $request->kheTheNho;
        $dienThoai->Ma_hang_dien_thoai = $request->hangDienThoai;
        $dienThoai->save();

        //TẠO GIÁ BÁN
        $oldPrice = $dienThoai->ToGiaBan->last();
        if($oldPrice->Gia !== $request->giaBan)
        {
            //THAY ĐỔI GIÁ CŨ, TRẠNG THÁI = 0
            $oldPrice->Trang_thai = 0;
            $oldPrice->save();

            //TẠO GIÁ BÁN MỚI
            $giaBan = new GiaBan;
            $giaBan->Gia = $request->giaBan;
            $giaBan->Ngay_cap_nhat = $today;
            $giaBan->Trang_thai = 1;
            $giaBan->Ma_dien_thoai = $dienThoai->Ma_dien_thoai;
            $giaBan->save();
        }
        
        return redirect('admin/dienthoai/sua/'.$id)->with('thongbao', 'Chỉnh sửa điện thoại thành công');
    }

    public function getXoa($id)
    {
        $dienThoai = DienThoaiDiDong::find($id);
        
        $dsChiTiet = $dienThoai->ToChiTietGioHang;
        $hasInBill = false;

        //XÁC ĐỊNH ĐIỆN THOẠI ĐÃ CÓ TRONG HÓA ĐƠN NÀO KHÔNG
        foreach ($dsChiTiet as $item) {
            if( $item->ToGioHang->ToHoaDon !== null)
            {
                $hasInBill = true;
                break;
            }
        }

        //XÓA CÁC BÌNH LUẬN VỀ ĐIỆN THOẠI ĐÓ
        $dsBinhLuan = $dienThoai->ToBinhLuan;
        foreach ($dsBinhLuan as $bl) {
            $bl->delete();
        }

        //CÁC THAO TÁC TRONG 2 TRƯỜNG HỢP: ĐIỆN THOẠI CÓ HAY KHÔNG CÓ TRONG HÓA ĐƠN
        if( $hasInBill )
        {
            //LƯU LẠI THUỘC TÍNH Dang_ban
            $dienThoai->Dang_ban = 0;
            $dienThoai->save();
        }
        else
        {
            //XÓA DỮ LIỆU LIÊN QUAN TỚI ĐIỆN THOẠI (XÓA HOÀN TOÀN)
                //XÓA NHỮNG CHI TIẾT GIỎ HÀNG
            DB::table('Chi_tiet_gio_hang')->where('Ma_dien_thoai', '=', $id)->delete();

            //XÓA NHỮNG KHUYẾN MÃI
            $dsKM = $dienThoai->ToKhuyenMai;
            foreach ($dsKM as $item) {
                $item->delete();
            }

            //XÓA NHỮNG GIÁ BÁN
            $dsGiaBan = $dienThoai->ToGiaBan;
            foreach ($dsGiaBan as $item) {
                $item->delete();
            }

            //XÓA ĐIỆN THOẠI
            $dienThoai->delete();
        }
        return redirect('admin/dienthoai/danhsach')->with('thongbao', 'Xóa điện thoại thành công');
    }
}
