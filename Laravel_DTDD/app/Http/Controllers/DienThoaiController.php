<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DienThoaiDiDong;

class DienThoaiController extends Controller
{
    public function getDanhSach()
    {
        $dienthoai = DienThoaiDiDong::all();
        return view('admin.DienThoai.DanhSach', ['dienthoai'=>$dienthoai]);
    }

    public function getThem()
    {
        return view('admin.DienThoai.Them');
    }

    public function getSua()
    {
        return view('admin.DienThoai.Sua');
    }
}
