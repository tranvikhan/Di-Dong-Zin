<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HoaDon extends Model
{
    protected $table = 'Hoa_don';

    protected $primaryKey = 'Ma_hoa_don';

    public $timestamps = false;

    public function ToGioHang()
    {
        return $this->belongsTo('App\GioHang', 'Ma_gio_hang', 'Ma_gio_hang');
    }
}
