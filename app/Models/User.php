<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relationships
    public function injectionData()
    {
        return $this->hasMany(InjectionDataInput::class, 'operator_id');
    }

    public function assemblingData()
    {
        return $this->hasMany(AssemblingDataInput::class, 'operator_id');
    }

    public function deliveryData()
    {
        return $this->hasMany(DeliveryDataInput::class, 'operator_id');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    // Scopes
    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    // Accessors
    public function getRoleBadgeAttribute()
    {
        $badges = [
            'admin' => '<span class="badge badge-danger">Admin</span>',
            'supervisor' => '<span class="badge badge-warning">Supervisor</span>',
            'operator' => '<span class="badge badge-info">Operator</span>',
        ];

        return $badges[$this->role] ?? '<span class="badge badge-secondary">Unknown</span>';
    }

    // Methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isSupervisor()
    {
        return $this->role === 'supervisor';
    }

    public function isOperator()
    {
        return $this->role === 'operator';
    }
}
