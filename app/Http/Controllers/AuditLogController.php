<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Project;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with(['user', 'auditable'])
            ->latest();

        if ($request->has('model_type')) {
            $query->where('auditable_type', $request->model_type);
        }

        if ($request->has('event')) {
            $query->where('event', $request->event);
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $auditLogs = $query->paginate(15);

        return view('audit-logs.index', compact('auditLogs'));
    }

    public function show(AuditLog $auditLog)
    {
        return view('audit-logs.show', compact('auditLog'));
    }

    public function projectHistory(Project $project)
    {
        $auditLogs = $project->auditLogs()
            ->with('user')
            ->latest()
            ->paginate(15);

        return view('audit-logs.project-history', compact('project', 'auditLogs'));
    }
} 