<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class WopiController extends Controller
{
    public function show($filename)
    {
        $document = Document::where('filename', $filename)->firstOrFail();
        
        if (!$document->canEdit(Auth::id())) {
            abort(403, 'You do not have permission to edit this document.');
        }

        $path = storage_path('app/public/documents/' . $filename);

        if (!file_exists($path)) {
            abort(404, 'File not found');
        }

        return response()->file($path, [
            'Content-Type' => mime_content_type($path),
            'X-WOPI-ItemVersion' => filemtime($path),
            'X-WOPI-Lock' => '',
            'X-WOPI-LockExpiration' => '',
            'X-WOPI-ItemId' => $document->id,
            'X-WOPI-ItemName' => $document->title,
            'X-WOPI-ItemUrl' => route('wopi.show', $filename),
            'X-WOPI-ItemVersion' => $document->updated_at->timestamp,
            'X-WOPI-ItemSize' => filesize($path),
            'X-WOPI-ItemLastModifiedTime' => $document->updated_at->toRfc3339String(),
        ]);
    }
}
