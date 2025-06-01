<?php

namespace App\Services;

use Google_Client;
use Google_Service_Docs;
use Google_Service_Drive;

class GoogleDocsService
{
    public $client;
    protected $docsService;
    protected $driveService;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setAuthConfig(base_path('client_secret_1091652537380-7lm5vngpea7mopkikpubldaakrq07hgm.apps.googleusercontent.com.json'));
        $this->client->addScope(Google_Service_Docs::DOCUMENTS);
        $this->client->addScope(Google_Service_Drive::DRIVE);
        $this->client->setRedirectUri('http://localhost:8000/auth/google/callback');
        
        $this->docsService = new Google_Service_Docs($this->client);
        $this->driveService = new Google_Service_Drive($this->client);
    }

    public function getAuthUrl()
    {
        return $this->client->createAuthUrl();
    }

    public function setAccessToken($token)
    {
        $this->client->setAccessToken($token);
    }

    public function createDocument($title)
    {
        $document = new \Google_Service_Docs_Document([
            'title' => $title
        ]);

        $document = $this->docsService->documents->create($document);
        return $document->documentId;
    }

    public function updateDocument($documentId, $content)
    {
        $requests = [
            new \Google_Service_Docs_Request([
                'insertText' => [
                    'location' => [
                        'index' => 1
                    ],
                    'text' => $content
                ]
            ])
        ];

        $batchUpdateRequest = new \Google_Service_Docs_BatchUpdateDocumentRequest([
            'requests' => $requests
        ]);

        return $this->docsService->documents->batchUpdate($documentId, $batchUpdateRequest);
    }

    public function getDocument($documentId)
    {
        return $this->docsService->documents->get($documentId);
    }
} 