<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChiTietGioHang extends Model
{
    protected $table = 'Chi_tiet_gio_hang';

    public $timestamps = false;

    public function ToDienThoaiDiDong()
    {
        return $this->belongsTo('App\DienThoaiDiDong', 'Ma_dien_thoai', 'Ma_dien_thoai');
    }

    public function ToGioHang()
    {
        return $this->belongsTo('App\GioHang', 'Ma_gio_hang', 'Ma_gio_hang');
    }
}
