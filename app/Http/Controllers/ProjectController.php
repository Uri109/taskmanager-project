<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = $request->user()->projects()->withCount([
            'tasks', 'tasks as completed_tasks_count' => fn ($q) => $q->where('status', 'done'),
        ])->latest()->get();

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(ProjectRequest $request)
    {
        try {
            $project = $request->user()->projects()->create($request->validated());

            return redirect()->route('projects.show', $project)->with('success', 'Project created. Time to make it happen.');
        } catch (QueryException $e) {
            report($e);

            return back()->withInput()->with('error', 'We could not save that project. Please try again.');
        }
    }

    public function show(Request $request, Project $project)
    {
        $this->authorize('view', $project);
        $status = $request->query('status', 'all');
        if (! in_array($status, ['all', 'todo', 'in_progress', 'done'], true)) {
            $status = 'all';
        }
        $tasks = $project->tasks()->when($status !== 'all', fn ($q) => $q->where('status', $status))->latest()->get();
        $counts = $project->tasks()->selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');

        return view('projects.show', compact('project', 'tasks', 'status', 'counts'));
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.edit', compact('project'));
    }

    public function update(ProjectRequest $request, Project $project)
    {
        $this->authorize('update', $project);
        try {
            $project->update($request->validated());

            return redirect()->route('projects.show', $project)->with('success', 'Project details updated.');
        } catch (QueryException $e) {
            report($e);

            return back()->withInput()->with('error', 'We could not update that project. Please try again.');
        }
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        try {
            $project->delete();

            return redirect()->route('projects.index')->with('success', 'Project deleted.');
        } catch (QueryException $e) {
            report($e);

            return back()->with('error', 'The project could not be deleted.');
        }
    }
}
