<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InjectionDataInput extends Model
{
    use HasFactory;

    protected $table = 'injection_data_input';

    protected $fillable = [
        'kode_part',
        'qty_hasil',
        'tanggal_input',
        'operator_id'
    ];

    protected $casts = [
        'tanggal_input' => 'date',
        'qty_hasil' => 'integer'
    ];

    // Relationships
    public function masterData()
    {
        return $this->belongsTo(MasterData::class, 'kode_part', 'kode_part');
    }

    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }

    // Scopes
    public function scopeToday($query)
    {
        return $query->whereDate('tanggal_input', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('tanggal_input', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('tanggal_input', now()->month)
                    ->whereYear('tanggal_input', now()->year);
    }
}

