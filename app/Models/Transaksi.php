<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'layanan',
        'lokasi',
        'latitude',
        'longitude',
        'berat',
        'bukti_foto',
        'status',
        'estimasi_koin',
    ];
}
