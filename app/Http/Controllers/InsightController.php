<?php

namespace App\Http\Controllers;

use App\Models\Insight;
use App\Services\TikTokService;
use App\Services\InstagramService;
use Illuminate\Http\Request;

class InsightController extends Controller
{
    public function __construct(
        protected TikTokService $tiktokService,
        protected InstagramService $instagramService
    ) {}

    public function index(Request $request)
    {
        $insights = Insight::filter(request(['title', 'type', 'is_published']))
            ->paginate(10)
            ->withQueryString();

        return view('insights.index', [
            'insights' => $insights,
            'filters' => $request->all()
        ]);
    }

    public function fetchFromApis()
    {
        // Fetch from TikTok
        $tiktokData = $this->tiktokService->fetchInsights();
        $this->storeInsights($tiktokData, 'tiktok');

        // Fetch from Instagram
        $instagramData = $this->instagramService->fetchInsights();
        $this->storeInsights($instagramData, 'instagram');

        return back()->with('success', 'Data berhasil diperbarui dari API');
    }

    protected function storeInsights(array $data, string $platform)
    {
        foreach ($data as $item) {
            Insight::updateOrCreate(
                ['platform' => $platform, 'post_id' => $item['post_id']],
                [
                    'likes' => $item['likes'],
                    'comments' => $item['comments'],
                    'shares' => $item['shares'],
                    'views' => $item['views'] ?? 0,
                    'saves' => $item['saves'] ?? 0,
                    'reach' => $item['reach'] ?? 0,
                    'engagement' => $item['engagement'] ?? 0,
                    'date' => $item['date']
                ]
            );
        }
    }
}