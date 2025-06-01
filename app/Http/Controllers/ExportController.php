<?php

namespace App\Http\Controllers;

use App\Exports\InsightsExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function showExportForm()
    {
        return view('insights.export');
    }

    public function export(Request $request)
    {
        $filters = $request->only(['platform', 'start_date', 'end_date']);

        return Excel::download(
            new InsightsExport($filters),
            'insights_report_' . now()->format('Ymd_His') . '.xlsx'
        );
    }
}
