<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

class Document extends Model
{
    use HasFactory, Auditable;

    // app/Models/Document.php
    protected $fillable = [
        'title',
        'filename',
        'user_id',
        'encryption_key'
    ];

    protected $hidden = [
        'encryption_key'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function accessRequests()
    {
        return $this->hasMany(DocumentAccessRequest::class);
    }

    public function documentAccess()
    {
        return $this->hasMany(DocumentAccess::class);
    }

    public function encryptFile($content)
    {
        $key = bin2hex(random_bytes(32));
        $this->encryption_key = $key;
        return Crypt::encryptString($content);
    }

    public function decryptFile($encryptedContent)
    {
        return Crypt::decryptString($encryptedContent);
    }

    public function hasAccess($userId)
    {
        if ($this->user_id === $userId) {
            return true;
        }

        return $this->documentAccess()
            ->where('user_id', $userId)
            ->where('status', 'granted')
            ->exists();
    }

    public function canEdit($userId)
    {
        if ($this->user_id === $userId) {
            return true;
        }

        return $this->documentAccess()
            ->where('user_id', $userId)
            ->where('status', 'granted')
            ->where('permission_level', 'edit')
            ->exists();
    }

    public function canDelete($userId)
    {
        if ($this->user_id === $userId) {
            return true;
        }

        return $this->documentAccess()
            ->where('user_id', $userId)
            ->where('status', 'granted')
            ->where('permission_level', 'delete')
            ->exists();
    }

    public function hasAccessRequest($userId)
    {
        return $this->accessRequests()
            ->where('user_id', $userId)
            ->whereIn('status', ['pending', 'granted'])
            ->exists();
    }
}
