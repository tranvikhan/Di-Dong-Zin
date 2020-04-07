<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DienThoaiController extends Controller
{
    public function getDanhSach()
    {
        return view('admin.DienThoai.DanhSach');
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
