<?php

namespace App\Models;

use App\Models\Laptop;
use App\Models\penyewa;
use Illuminate\Database\Eloquent\Model;

class Penyewaan extends Model
{
    protected $fillable = ['kode_sewa', 'id_penyewa', 'id_laptop', 'tgl_mulai', 'tgl_selesai', 'tgl_dikembalikan', 'status', 'harga', 'denda'];
    protected $primaryKey = 'id_sewa';
    public $timestamps = false;

    public function penyewa()
    {
        return $this->belongsTo(penyewa::class, 'id_penyewa', 'id_penyewa');
    }

    public function laptop()
    {
        return $this->belongsTo(laptop::class, 'id_laptop', 'id_laptop');
    }
}
