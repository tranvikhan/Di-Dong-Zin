<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DienThoaiDiDong extends Model
{
    protected $table = "Dien_thoai_di_dong";

    protected $primaryKey = "Ma_dien_thoai";

    public $timestamps = false;

    public function ToHangDienThoaiDiDong()
    {
        return $this->belongsTo('App\HangDienThoaiDiDong', 'Ma_hang_dien_thoai', 'Ma_hang_dien_thoai');
    }

    public function ToBinhLuan()
    {
        return $this->hasMany('App\BinhLuan', 'Ma_dien_thoai', 'Ma_dien_thoai');
    }

    public function ToChiTietGioHang()
    {
        return $this->hasMany('App\ChiTietGioHang', 'Ma_dien_thoai', 'Ma_dien_thoai');
    }

    public function ToGiaBan()
    {
        return $this->hasMany('App\GiaBan', 'Ma_dien_thoai', 'Ma_dien_thoai');
    }

    public function ToKhuyenMai()
    {
        return $this->hasMany('App\KhuyenMai', 'Ma_dien_thoai', 'Ma_dien_thoai');
    }
}
