<?php

namespace App\Services;

use App\Models\Document;
use App\Models\DocumentAccess;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class DocumentEncryptionService
{
    /**
     * Generate a new encryption key for a document
     */
    public function generateEncryptionKey(): string
    {
        return bin2hex(random_bytes(32));
    }

    /**
     * Encrypt document content with the given key
     */
    public function encryptContent(string $content, string $key): string
    {
        return Crypt::encryptString($content);
    }

    /**
     * Decrypt document content with the given key
     */
    public function decryptContent(string $encryptedContent, string $key): string
    {
        return Crypt::decryptString($encryptedContent);
    }

    /**
     * Share document access with another user
     */
    public function shareDocument(Document $document, User $user, string $permissionLevel = 'view'): DocumentAccess
    {
        return DocumentAccess::create([
            'document_id' => $document->id,
            'user_id' => $user->id,
            'permission_level' => $permissionLevel,
        ]);
    }

    /**
     * Check if user has access to document
     */
    public function hasAccess(Document $document, User $user): bool
    {
        return $document->documentAccess()
            ->where('user_id', $user->id)
            ->exists();
    }

    /**
     * Get document access level for user
     */
    public function getAccessLevel(Document $document, User $user): ?string
    {
        $access = $document->documentAccess()
            ->where('user_id', $user->id)
            ->first();
            
        return $access ? $access->permission_level : null;
    }
} 