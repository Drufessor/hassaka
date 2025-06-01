<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Schedule extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'status',
        'created_by'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
} 