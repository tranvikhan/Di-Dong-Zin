<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DonHangController extends Controller
{
    function ShowView()
    {
        return view('admin.DonHang');
    }
}
