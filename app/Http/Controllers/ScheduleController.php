<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\AuditLog;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with('user')->latest()->get();
        return view('schedules.index', compact('schedules'));
    }

    public function create()
    {
        return view('schedules.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:pending,approved,completed'
        ]);

        $validated['created_by'] = auth()->id();
        $schedule = Schedule::create($validated);

        return redirect()->route('schedules.index')
            ->with('success', 'Schedule created successfully.');
    }

    public function show(Schedule $schedule)
    {
        // Audit log will be automatically created by the Auditable trait
        return view('schedules.show', compact('schedule'));
    }

    public function edit(Schedule $schedule)
    {
        return view('schedules.edit', compact('schedule'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:pending,approved,completed'
        ]);

        $schedule->update($validated);

        return redirect()->route('schedules.show', $schedule)
            ->with('success', 'Schedule updated successfully.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('schedules.index')
            ->with('success', 'Schedule deleted successfully.');
    }
} 