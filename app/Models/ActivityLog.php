<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $table = 'activity_log';

    protected $fillable = [
        'user_id',
        'action',
        'table_name',
        'item_affected',
        'old_values',
        'new_values',
        'timestamp'
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'timestamp' => 'datetime'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeToday($query)
    {
        return $query->whereDate('timestamp', today());
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    public function scopeByTable($query, $tableName)
    {
        return $query->where('table_name', $tableName);
    }

    // Static method to log activity
    public static function logActivity($userId, $action, $tableName, $itemAffected, $oldValues = null, $newValues = null)
    {
        return self::create([
            'user_id' => $userId,
            'action' => $action,
            'table_name' => $tableName,
            'item_affected' => $itemAffected,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'timestamp' => now()
        ]);
    }
}

