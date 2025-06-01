<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\AuditLog;
use App\Models\User;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Project::class, 'project');
    }

    /**
     * Display a listing of projects.
     */
    public function index()
    {
        $projects = auth()->user()->isAdmin()
            ? Project::with(['owner', 'marketing'])->latest()->paginate(10)
            : Project::viewableBy(auth()->user())
                ->with(['owner', 'marketing'])
                ->latest()
                ->paginate(10);

        return view('project.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project.
     */
    public function create()
    {
        $marketings = User::whereHas('role', function($query) {
            $query->where('name', 'marketing');
        })->get();

        return view('project.create', compact('marketings'));
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();
        $data['owner_id'] = auth()->id();
        $data['created_by'] = auth()->id();

        $project = Project::create($data);

        return redirect()->route('project.index')
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project)
    {
        return view('project.show', compact('project'));
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project)
    {
        $marketings = User::whereHas('role', function($query) {
            $query->where('name', 'marketing');
        })->get();

        return view('project.edit', compact('project', 'marketings'));
    }

    /**
     * Update the specified project in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $this->authorize('update', $project);
        $project->update($request->validated());

        return redirect()->route('project.index')
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        $project->delete();

        return redirect()->route('project.index')
            ->with('success', 'Project deleted successfully.');
    }
}
