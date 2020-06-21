<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiaBan extends Model
{
    protected $table = 'Gia_ban';

    protected $primaryKey = "Ma_gia_ban";

    public $timestamps = false;

    public function ToGiaVon()
    {
        return $this->belongsTo('App\GiaVon', 'Ma_gia_von', 'Ma_gia_von');
    }

    public function ToChiTietGioHang()
    {
        return $this->hasMany('App\ChiTietGioHang', 'Ma_gia_ban', 'Ma_gia_ban');
    }
}
