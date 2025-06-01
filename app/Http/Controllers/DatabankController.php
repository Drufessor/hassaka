<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DatabankController extends Controller
{
    // ... existing code ...

    public function destroy(Document $document)
    {
        try {
            // Hapus file fisik
            if (Storage::exists($document->file_path)) {
                Storage::delete($document->file_path);
            }

            // Hapus record dari database
            $document->delete();

            return redirect()->route('databank')->with('success', 'Dokumen berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('databank')->with('error', 'Gagal menghapus dokumen: ' . $e->getMessage());
        }
    }
} 