<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiaVon extends Model
{
    protected $table = 'Gia_von';

    protected $primaryKey = 'Ma_gia_von';

    public $timestamps = false;

    public function ToGiaBan()
    {
        return $this->hasMany('App\GiaBan', 'Ma_gia_von', 'Ma_gia_von');
    }

    public function ToDienThoaiDiDong()
    {
        return $this->belongsTo('App\DienThoaiDiDong', 'Ma_dien_thoai', 'Ma_dien_thoai');
    }
}
