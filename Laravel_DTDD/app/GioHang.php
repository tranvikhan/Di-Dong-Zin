<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GioHang extends Model
{
    protected $table = 'Gio_hang';

    protected $primaryKey = 'Ma_gio_hang';

    public $timestamps = false;

    public function ToTaiKhoan()
    {
        return $this->belongsTo('App\TaiKhoan', 'Ma_tai_khoan', 'Ma_tai_khoan');
    }

    public function ToChiTietGioHang()
    {
        return $this->hasMany('App\ChiTietGioHang', 'Ma_gio_hang', 'Ma_gio_hang');
    }

    public function ToHoaDon()
    {
        return $this->hasOne('App\HoaDon', 'Ma_gio_hang', 'Ma_gio_hang');
    }
}
