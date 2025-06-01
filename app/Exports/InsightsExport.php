<?php

namespace App\Exports;

use App\Models\Insight;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class InsightsExport implements FromQuery, WithHeadings, WithMapping
{
    public function __construct(protected array $filters = []) {}

    public function query()
    {
        return Insight::filter($this->filters)
            ->orderBy('date', 'desc');
    }

    public function headings(): array
    {
        return [
            'Platform',
            'Post ID',
            'Tanggal',
            'Likes',
            'Comments',
            'Shares',
            'Views',
            'Saves',
            'Reach',
            'Engagement'
        ];
    }

    public function map($insight): array
    {
        return [
            strtoupper($insight->platform),
            $insight->post_id,
            $insight->date->format('Y-m-d'),
            $insight->likes,
            $insight->comments,
            $insight->shares,
            $insight->views,
            $insight->saves,
            $insight->reach,
            $insight->engagement,
        ];
    }
} 