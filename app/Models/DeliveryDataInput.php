<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryDataInput extends Model
{
    use HasFactory;

    protected $table = 'delivery_data_input';

    protected $fillable = [
        'kode_part',
        'qty_delivery',
        'tanggal_delivery',
        'customer',
        'operator_id'
    ];

    protected $casts = [
        'tanggal_delivery' => 'date',
        'qty_delivery' => 'integer'
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
        return $query->whereDate('tanggal_delivery', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('tanggal_delivery', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('tanggal_delivery', now()->month)
                    ->whereYear('tanggal_delivery', now()->year);
    }
}

