<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BinhLuan extends Model
{
    protected $table = 'Binh_luan';

    protected $primaryKey = 'Ma_binh_luan';

    public $timestamps = false;

    public function ToTaiKhoan()
    {
        return $this->belongsTo('App\TaiKhoan', 'Ma_tai_khoan', 'Ma_tai_khoan');
    }
}
