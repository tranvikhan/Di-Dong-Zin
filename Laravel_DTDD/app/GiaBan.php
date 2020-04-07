<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiaBan extends Model
{
    protected $table = 'Gia_ban';

    protected $primaryKey = "Ma_gia_ban";

    public $timestamps = false;

    public function ToDienThoaiDiDong()
    {
        return $this->belongsTo('App\DienThoaiDiDong', 'Ma_dien_thoai', 'Ma_dien_thoai');
    }
}
