<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class penyewa extends Model
{
    protected $primaryKey = 'id_penyewa';
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'telp',
        'email',
        'alamat'
    ];

    public function penyewaan()
    {
        return $this->hasMany(Penyewaan::class, 'id_penyewa');
    }
}
