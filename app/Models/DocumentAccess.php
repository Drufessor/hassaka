<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentAccess extends Model
{
    use HasFactory;

    protected $table = 'document_access';

    protected $fillable = [
        'document_id',
        'user_id',
        'status',
        'permission_level'
    ];

    protected $casts = [
        'can_edit' => 'boolean',
        'can_delete' => 'boolean',
        'access_expires_at' => 'datetime'
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function grantor()
    {
        return $this->belongsTo(User::class, 'granted_by');
    }
} 