<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockFg extends Model
{
    use HasFactory;

    protected $table = 'stock_fg';

    protected $fillable = [
        'kode_part',
        'qty_fg'
    ];

    protected $casts = [
        'qty_fg' => 'integer'
    ];

    // Relationships
    public function masterData()
    {
        return $this->belongsTo(MasterData::class, 'kode_part', 'kode_part');
    }

    // Scopes
    public function scopeLowStock($query, $threshold = 10)
    {
        return $query->where('qty_fg', '<=', $threshold);
    }

    // Methods
    public function addStock($quantity)
    {
        $this->increment('qty_fg', $quantity);
        return $this;
    }

    public function reduceStock($quantity)
    {
        if ($this->qty_fg >= $quantity) {
            $this->decrement('qty_fg', $quantity);
            return true;
        }
        return false;
    }

    // Accessors
    public function getStockStatusAttribute()
    {
        if ($this->qty_fg <= 10) {
            return '<span class="badge badge-danger">Low Stock</span>';
        } elseif ($this->qty_fg <= 50) {
            return '<span class="badge badge-warning">Medium Stock</span>';
        } else {
            return '<span class="badge badge-success">High Stock</span>';
        }
    }
}

