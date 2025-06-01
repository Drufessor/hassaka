<?php

namespace Database\Seeders;

use App\Models\Insight;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class InsightSeeder extends Seeder
{
    public function run(): void
    {
        $platforms = ['tiktok', 'instagram'];
        $startDate = Carbon::now()->subMonths(3);
        $endDate = Carbon::now();

        // Generate data for each platform
        foreach ($platforms as $platform) {
            // Generate 10 posts for each platform
            for ($i = 0; $i < 10; $i++) {
                $date = Carbon::createFromTimestamp(
                    rand($startDate->timestamp, $endDate->timestamp)
                );

                Insight::create([
                    'platform' => $platform,
                    'post_id' => $platform . '_' . str_pad($i + 1, 8, '0', STR_PAD_LEFT),
                    'likes' => rand(100, 10000),
                    'comments' => rand(10, 1000),
                    'shares' => rand(5, 500),
                    'views' => rand(1000, 100000),
                    'saves' => rand(50, 2000),
                    'reach' => rand(5000, 50000),
                    'engagement' => rand(100, 5000),
                    'date' => $date,
                ]);
            }
        }
    }
} 