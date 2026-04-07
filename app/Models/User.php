<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasName
{
    use HasFactory, Notifiable, HasRoles;
    protected $guard_name = 'web';

    protected $fillable = [
        'username',
        'email',
        'password',
        'full_name',
        'nick_name',
        'telephone',
        'avatar',
        'ip',
        'last_login',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'last_login' => 'datetime',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
       return $this->is_active;
    }

    public function getFilamentName(): string
    {
        return (string) ($this->full_name ?? $this->username ?? 'User');
    }
}