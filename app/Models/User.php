<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'full_name',
        'username',
        'email',
        'phone',
        'password',
        'role',
        'is_active',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'password' => 'hashed',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'Admin';
    }

    public function isManager(): bool
    {
        return $this->role === 'Manager';
    }

    public function isSupplier(): bool
    {
        return $this->role === 'Supplier';
    }

    public function isCustomer(): bool
    {
        return $this->role === 'Customer';
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
}
