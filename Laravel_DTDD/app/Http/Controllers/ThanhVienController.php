<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThanhVienController extends Controller
{
    function getDanhSach()
    {
        return view('admin.ThanhVien');
    }
}
