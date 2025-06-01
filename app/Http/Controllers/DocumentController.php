<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentAccess;
use App\Models\DocumentAccessRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::with(['user', 'documentAccess' => function($query) {
            $query->where('user_id', Auth::id());
        }])->get();
        
        return view('databank.index', compact('documents'));
    }

    public function showUploadForm()
    {
        return view('databank.upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'document' => 'required|file|mimes:doc,docx|max:10240',
        ]);

        $file = $request->file('document');
        $filename = time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
        
        $path = $file->storeAs('documents', $filename);
        
        $document = Document::create([
            'title' => $request->title,
            'filename' => $filename,
            'user_id' => Auth::id(),
            'encryption_key' => Str::random(32)
        ]);

        return redirect()->route('databank')->with('success', 'Dokumen berhasil diupload.');
    }

    public function getFile($filename)
    {
        $document = Document::where('filename', $filename)->firstOrFail();
        
        if (!$document->hasAccess(Auth::id())) {
            return back()->with('error', 'Anda tidak memiliki akses ke dokumen ini.');
        }

        if (!Storage::exists('documents/' . $filename)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return Storage::download('documents/' . $filename);
    }

    public function edit(Document $document)
    {
        if (!$document->canEdit(Auth::id())) {
            return back()->with('error', 'Anda tidak memiliki izin untuk mengedit dokumen ini.');
        }

        // Generate a public URL for the document
        $documentUrl = Storage::url('documents/' . $document->filename);
        $fullUrl = url($documentUrl);
        
        // Redirect directly to Google Docs for editing
        $googleDocsUrl = 'https://docs.google.com/document/d/create?usp=upload_embed&url=' . urlencode($fullUrl);
        
        return redirect($googleDocsUrl);
    }

    public function destroy(Document $document)
    {
        if (!$document->canDelete(Auth::id())) {
            return back()->with('error', 'Anda tidak memiliki izin untuk menghapus dokumen ini.');
        }

        Storage::delete('documents/' . $document->filename);
        $document->delete();

        return redirect()->route('databank')->with('success', 'Dokumen berhasil dihapus.');
    }

    public function showAccessRequests()
    {
        $requests = DocumentAccessRequest::with(['document', 'user'])
            ->whereHas('document', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->where('status', 'pending')
            ->get();

        return view('databank.access-requests', compact('requests'));
    }

    public function requestAccess(Document $document)
    {
        if ($document->user_id === Auth::id()) {
            return back()->with('error', 'Anda adalah pemilik dokumen ini.');
        }

        if ($document->hasAccess(Auth::id())) {
            return back()->with('error', 'Anda sudah memiliki akses ke dokumen ini.');
        }

        if ($document->hasAccessRequest(Auth::id())) {
            return back()->with('error', 'Anda sudah memiliki permintaan akses yang pending.');
        }

        DocumentAccessRequest::create([
            'document_id' => $document->id,
            'user_id' => Auth::id(),
            'status' => 'pending'
        ]);

        return back()->with('success', 'Permintaan akses telah dikirim.');
    }

    public function grantAccess(DocumentAccessRequest $request)
    {
        if ($request->document->user_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak memiliki izin untuk memberikan akses.');
        }

        DocumentAccess::create([
            'document_id' => $request->document_id,
            'user_id' => $request->user_id,
            'status' => 'granted',
            'permission_level' => 'view'
        ]);

        $request->update(['status' => 'granted']);

        return back()->with('success', 'Akses telah diberikan.');
    }

    public function rejectAccess(DocumentAccessRequest $request)
    {
        if ($request->document->user_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak memiliki izin untuk menolak akses.');
        }

        $request->update(['status' => 'rejected']);

        return back()->with('success', 'Permintaan akses telah ditolak.');
    }

    public function history(Document $document)
    {
        if (!$document->hasAccess(Auth::id())) {
            return back()->with('error', 'Anda tidak memiliki akses ke dokumen ini.');
        }

        $auditLogs = $document->auditLogs()
            ->with('user')
            ->latest()
            ->paginate(15);

        return view('audit-logs.document-history', compact('document', 'auditLogs'));
    }
}
