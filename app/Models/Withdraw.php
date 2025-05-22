<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'koin_ditukar',
        'nominal',
        'status',
    ];

    /**
     * Get the user that owns the withdraw.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Format nominal to rupiah
     * 
     * @return string
     */
    public function getNominalRupiahAttribute()
    {
        return 'Rp ' . number_format($this->nominal, 0, ',', '.');
    }
    
    /**
     * Get status badge
     * 
     * @return string
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => '<span class="badge bg-warning">Menunggu</span>',
            'sukses' => '<span class="badge bg-success">Sukses</span>',
            'gagal' => '<span class="badge bg-danger">Gagal</span>',
        ];
        
        return $badges[$this->status] ?? '<span class="badge bg-secondary">Unknown</span>';
    }
}