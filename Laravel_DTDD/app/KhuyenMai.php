<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KhuyenMai extends Model
{
    protected $table = 'khuyen_mai';

    protected $primaryKey = 'Ma_khuyen_mai';

    public function ToDienThoaiDiDong()
    {
        return $this->belongsTo('App\DienThoaiDiDong', 'Ma_dien_thoai', 'Ma_dien_thoai');
    }
}
