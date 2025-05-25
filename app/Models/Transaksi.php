<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';

    protected $fillable = [
        'user_id',
        'layanan',
        'alamat',
        'lokasi',
        'latitude',
        'longitude',
        'berat',
        'tanggal',
        'estimasi_koin',
        'bukti_foto',
        'status',
        'lokasi_antar',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor untuk status dalam bahasa Indonesia
    public function getStatusIndonesiaAttribute()
    {
        $statuses = [
            'pending' => 'Belum di Validasi',
            'processing' => 'Sedang Diproses',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan'
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    // Accessor untuk tanggal format Indonesia
    public function getTanggalFormatAttribute()
    {
        return $this->tanggal ? Carbon::parse($this->tanggal)->format('d M Y') : '-';
    }
}