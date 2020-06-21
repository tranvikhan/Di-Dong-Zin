<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HangDienThoaiDiDong extends Model
{
    protected $table = "hang_dien_thoai_di_dong";

    protected $primaryKey = "Ma_hang_dien_thoai";

    public $timestamps = false;

    public function ToDienThoaiDiDong()
    {
        return $this->hasMany('App\DienThoaiDiDong', 'Ma_hang_dien_thoai', 'Ma_hang_dien_thoai');
    }
}
