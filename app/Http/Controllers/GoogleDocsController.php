<?php

namespace App\Http\Controllers;

use App\Services\GoogleDocsService;
use Illuminate\Http\Request;

class GoogleDocsController extends Controller
{
    protected $googleDocsService;

    public function __construct(GoogleDocsService $googleDocsService)
    {
        $this->googleDocsService = $googleDocsService;
    }

    public function redirect()
    {
        return redirect($this->googleDocsService->getAuthUrl());
    }

    public function callback(Request $request)
    {
        if ($request->has('code')) {
            $token = $this->googleDocsService->client->fetchAccessTokenWithAuthCode($request->code);
            $this->googleDocsService->setAccessToken($token);
            
            // Store the token in session or database
            session(['google_access_token' => $token]);
            
            return redirect()->route('google.docs.create');
        }
        
        return redirect()->route('google.docs.redirect');
    }

    public function createDocument(Request $request)
    {
        $title = $request->input('title', 'New Document');
        $content = $request->input('content', '');
        
        $documentId = $this->googleDocsService->createDocument($title);
        
        if ($content) {
            $this->googleDocsService->updateDocument($documentId, $content);
        }
        
        return response()->json([
            'success' => true,
            'document_id' => $documentId
        ]);
    }

    public function getDocument($documentId)
    {
        $document = $this->googleDocsService->getDocument($documentId);
        return response()->json($document);
    }

    public function updateDocument(Request $request, $documentId)
    {
        $content = $request->input('content');
        $result = $this->googleDocsService->updateDocument($documentId, $content);
        
        return response()->json([
            'success' => true,
            'result' => $result
        ]);
    }
} 