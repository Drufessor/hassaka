<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id', // Tambahkan ini untuk relasi role
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke Role
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relasi ke Project sebagai Owner
     */
    public function ownedProjects(): HasMany
    {
        return $this->hasMany(Project::class, 'owner_id');
    }

    /**
     * Relasi ke Project sebagai Marketing
     */
    public function managedProjects(): HasMany
    {
        return $this->hasMany(Project::class, 'marketing_id');
    }

    /**
     * Relasi ke Project sebagai Creator
     */
    public function createdProjects(): HasMany
    {
        return $this->hasMany(Project::class, 'created_by');
    }

    /**
     * Cek apakah user adalah admin
     */
    public function isAdmin(): bool
    {
        return $this->role->name === 'admin';
    }

    /**
     * Cek apakah user adalah owner
     */
    public function isOwner(): bool
    {
        return $this->role->name === 'owner';
    }

    /**
     * Cek apakah user adalah marketing
     */
    public function isMarketing(): bool
    {
        return $this->role->name === 'marketing';
    }

    /**
     * Cek apakah user adalah teknisi
     */
    public function isTeknisi(): bool
    {
        return $this->role->name === 'teknisi';
    }

    /**
     * Cek apakah user adalah finance
     */
    public function isFinance(): bool
    {
        return $this->role->name === 'finance';
    }

    /**
     * Check if user has a specific role or any of the given roles
     * 
     * @param string|array $roles Role name or array of role names
     * @return bool
     */
    public function hasRole(string|array $roles): bool
    {
        if (is_string($roles)) {
            return $this->role->name === $roles;
        }

        return in_array($this->role->name, $roles);
    }

    /**
     * Check if user has any of the given roles
     * 
     * @param array $roles Array of role names
     * @return bool
     */
    public function hasAnyRole(array $roles): bool
    {
        return $this->hasRole($roles);
    }

    /**
     * Scope untuk mendapatkan hanya admin
     */
    public function scopeAdmins($query)
    {
        return $query->whereHas('role', function($q) {
            $q->where('name', 'admin');
        });
    }

    /**
     * Scope untuk mendapatkan hanya owner
     */
    public function scopeOwners($query)
    {
        return $query->whereHas('role', function($q) {
            $q->where('name', 'owner');
        });
    }

    /**
     * Scope untuk mendapatkan hanya marketing
     */
    public function scopeMarketing($query)
    {
        return $query->whereHas('role', function($q) {
            $q->where('name', 'marketing');
        });
    }

    /**
     * Scope untuk mendapatkan hanya teknisi
     */
    public function scopeTeknisi($query)
    {
        return $query->whereHas('role', function($q) {
            $q->where('name', 'teknisi');
        });
    }

    /**
     * Scope untuk mendapatkan hanya finance
     */
    public function scopeFinance($query)
    {
        return $query->whereHas('role', function($q) {
            $q->where('name', 'finance');
        });
    }
}
