<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockWip extends Model
{
    use HasFactory;

    protected $table = 'stock_wip';

    protected $fillable = [
        'kode_part',
        'qty_wip'
    ];

    protected $casts = [
        'qty_wip' => 'integer'
    ];

    // Relationships
    public function masterData()
    {
        return $this->belongsTo(MasterData::class, 'kode_part', 'kode_part');
    }

    // Scopes
    public function scopeLowStock($query, $threshold = 10)
    {
        return $query->where('qty_wip', '<=', $threshold);
    }

    // Methods
    public function addStock($quantity)
    {
        $this->increment('qty_wip', $quantity);
        return $this;
    }

    public function reduceStock($quantity)
    {
        if ($this->qty_wip >= $quantity) {
            $this->decrement('qty_wip', $quantity);
            return true;
        }
        return false;
    }

    // Accessors
    public function getStockStatusAttribute()
    {
        if ($this->qty_wip <= 10) {
            return '<span class="badge badge-danger">Low Stock</span>';
        } elseif ($this->qty_wip <= 50) {
            return '<span class="badge badge-warning">Medium Stock</span>';
        } else {
            return '<span class="badge badge-success">High Stock</span>';
        }
    }
}

