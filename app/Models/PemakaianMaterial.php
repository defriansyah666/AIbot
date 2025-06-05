<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemakaianMaterial extends Model
{
    use HasFactory;

    protected $table = 'pemakaian_material';

    protected $fillable = [
        'kode_part',
        'material',
        'jumlah_pakai',
        'tanggal'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah_pakai' => 'integer'
    ];

    // Relationships
    public function masterData()
    {
        return $this->belongsTo(MasterData::class, 'kode_part', 'kode_part');
    }

    // Scopes
    public function scopeToday($query)
    {
        return $query->whereDate('tanggal', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('tanggal', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('tanggal', now()->month)
                    ->whereYear('tanggal', now()->year);
    }
}

