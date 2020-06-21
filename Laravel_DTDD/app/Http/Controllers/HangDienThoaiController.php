<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HangDienThoaiDiDong;

class HangDienThoaiController extends Controller
{
    public function getDanhSach()
    {
        $hangDT = HangDienThoaiDiDong::all();
        return view('admin.HangDienThoai', ['hangDT'=>$hangDT]);
    }

    public function postThem(Request $request)
    {
        $this->validate($request, 
            [
                'tenThem'=>'required|max:40',
                'quocGiaThem'=>'required|max:40'
            ], 
            [
                'tenThem.required'=>'Tên hãng điện thoại không được trống',
                'tenThem.max'=>'Tên hãng có chiều dài tối đa là 40 ký tự',
                'quocGiaThem.required'=>'Tên quốc gia không được trống',
                'quocGiaThem.max'=>'Tên quốc gia có chiều dài tối đa là 40 ký tự'
            ]);
        $hangDT = new HangDienThoaiDiDong;
        $hangDT->Ma_hang_dien_thoai = HangDienThoaiDiDong::all()->max('Ma_hang_dien_thoai') + 1;
        $hangDT->Ten_hang = $request->tenThem;
        $hangDT->Quoc_gia = $request->quocGiaThem;

        $hangDT->save();
        return redirect('admin/hangdienthoai/danhsach')->with('thongbaoThem', 'Thêm hãng điện thoại thành công');
    }

    public function postSua(Request $request)
    {
        $this->validate($request, 
            [
                'tenSua'=>'required|max:40',
                'quocGiaSua'=>'required|max:40'
            ], 
            [
                'tenSua.required'=>'Tên hãng điện thoại không được trống',
                'tenSua.max'=>'Tên hãng có chiều dài tối đa là 40 ký tự',
                'quocGiaSua.required'=>'Tên quốc gia không được trống',
                'quocGiaSua.max'=>'Tên quốc gia có chiều dài tối đa là 40 ký tự'
            ]);
        $id = $request->idSua;
        $hangDT = HangDienThoaiDiDong::find($id);
        $hangDT->Ten_hang = $request->tenSua;
        $hangDT->Quoc_gia = $request->quocGiaSua;

        $hangDT->save();
        return redirect('admin/hangdienthoai/danhsach')->with('thongbaoSua', 'Chỉnh sửa hãng điện thoại thành công');
    }

    public function getXoa($id)
    {
        $hangDT = HangDienThoaiDiDong::find($id)->delete();

        return redirect('admin/hangdienthoai/danhsach')->with('thongbaoXoa', 'Xóa hãng điện thoại thành công');
    }
}
