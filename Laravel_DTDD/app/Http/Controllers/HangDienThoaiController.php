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
}
