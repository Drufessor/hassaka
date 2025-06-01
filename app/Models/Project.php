<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes, Auditable;

    protected $fillable = [
        'date',
        'project_name',
        'location',
        'description',
        'marketing_id',
        'owner_id',
        'created_by'
    ];

    protected $casts = [
        'date' => 'date'
    ];

    // Relasi ke owner
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // Relasi ke marketing
    public function marketing(): BelongsTo
    {
        return $this->belongsTo(User::class, 'marketing_id');
    }

    // Relasi ke creator
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Cek hak akses edit
    public function canBeEditedBy(User $user): bool
    {
        return match($user->role->name) {
            'admin' => true,
            'owner' => $this->owner_id === $user->id,
            'marketing' => $this->marketing_id === $user->id,
            default => false
        };
    }

    // Query scope untuk project yang bisa diedit
    public function scopeEditableBy(Builder $query, User $user): void
    {
        $query->when(
            $user->role->name === 'owner',
            fn($q) => $q->where('owner_id', $user->id)
        )->when(
            $user->role->name === 'marketing',
            fn($q) => $q->where('marketing_id', $user->id)
        )->when(
            $user->role->name === 'user',
            fn($q) => $q->where('id', 0) // Tidak ada akses
        );
        // Admin bisa lihat semua (tidak perlu filter)
    }

    // Query scope untuk project yang bisa dilihat
    public function scopeViewableBy(Builder $query, User $user): void
    {
        // Admin, owner, dan marketing bisa lihat semua project
        if ($user->isAdmin() || $user->isOwner() || $user->isMarketing()) {
            return;
        }
        
        // Untuk user lain, hanya bisa lihat project yang terkait dengan mereka
        $query->when(
            $user->isOwner(),
            fn($q) => $q->where('owner_id', $user->id)
        )->when(
            $user->isMarketing(),
            fn($q) => $q->where('marketing_id', $user->id)
        );
    }
}
