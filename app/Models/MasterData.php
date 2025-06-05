<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterData extends Model
{
    use HasFactory;

    protected $table = 'master_data';
    protected $primaryKey = 'kode_part';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_part',
        'nama_part',
        'proses',
        'status'
    ];

    protected $casts = [
        'status' => 'string'
    ];

    // Relationships
    public function injectionData()
    {
        return $this->hasMany(InjectionDataInput::class, 'kode_part', 'kode_part');
    }

    public function assemblingData()
    {
        return $this->hasMany(AssemblingDataInput::class, 'kode_part', 'kode_part');
    }

    public function deliveryData()
    {
        return $this->hasMany(DeliveryDataInput::class, 'kode_part', 'kode_part');
    }

    public function stockWip()
    {
        return $this->hasOne(StockWip::class, 'kode_part', 'kode_part');
    }

    public function stockFg()
    {
        return $this->hasOne(StockFg::class, 'kode_part', 'kode_part');
    }

    public function pemakaianMaterial()
    {
        return $this->hasMany(PemakaianMaterial::class, 'kode_part', 'kode_part');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        return $this->status === 'active' 
            ? '<span class="badge badge-success">Active</span>'
            : '<span class="badge badge-danger">Inactive</span>';
    }
}

