<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class laptop extends Model
{
    protected $primaryKey = 'id_laptop';
    public $timestamps = false;
    protected $fillable = [
        'kode_laptop',
        'brand',
        'model',
        'spesifikasi',
        'harga_sewa',
        'status',
    ];

    public function penyewaan()
    {
        return $this->hasMany(Penyewaan::class);
    }
}
