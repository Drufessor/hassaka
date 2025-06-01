<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insight extends Model
{
    use HasFactory;

    protected $fillable = [
        'platform',
        'post_id',
        'likes',
        'comments',
        'shares',
        'views',
        'saves',
        'reach',
        'engagement',
        'date'
    ];

    protected $casts = [
        'date' => 'date'
    ];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['platform'] ?? false, fn($query, $platform) =>
            $query->where('platform', $platform)
        );

        $query->when($filters['start_date'] ?? false, fn($query, $startDate) =>
            $query->where('date', '>=', $startDate)
        );

        $query->when($filters['end_date'] ?? false, fn($query, $endDate) =>
            $query->where('date', '<=', $endDate)
        );
    }
}