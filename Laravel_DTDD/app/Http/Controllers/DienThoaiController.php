<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DienThoaiDiDong;
use App\HangDienThoaiDiDong;

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
        return view('admin.DienThoai.Them');
    }

    public function getSua()
    {
        return view('admin.DienThoai.Sua');
    }
}
