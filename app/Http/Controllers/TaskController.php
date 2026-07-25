<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\QueryException;

class TaskController extends Controller
{
    public function create(Project $project)
    {
        $this->authorize('view', $project);

        return view('tasks.create', compact('project'));
    }

    public function store(TaskRequest $request, Project $project)
    {
        $this->authorize('view', $project);
        try {
            $data = $request->validated();
            if ($data['status'] === 'done') {
                $data['completed_at'] = now();
            }
            $project->tasks()->create($data);

            return redirect()->route('projects.show', $project)->with($data['status'] === 'done' ? 'completed' : 'success', $data['status'] === 'done' ? 'Task completed — brilliant work!' : 'Task added to the board.');
        } catch (QueryException $e) {
            report($e);

            return back()->withInput()->with('error', 'We could not save that task. Please try again.');
        }
    }

    public function show(Project $project, Task $task)
    {
        $this->guardNested($project, $task);

        return view('tasks.show', compact('project', 'task'));
    }

    public function edit(Project $project, Task $task)
    {
        $this->guardNested($project, $task);

        return view('tasks.edit', compact('project', 'task'));
    }

    public function update(TaskRequest $request, Project $project, Task $task)
    {
        $this->guardNested($project, $task);
        try {
            $data = $request->validated();
            $justCompleted = $task->status !== 'done' && $data['status'] === 'done';
            $data['completed_at'] = $data['status'] === 'done' ? ($task->completed_at ?? now()) : null;
            $task->update($data);

            return redirect()->route('projects.show', $project)->with($justCompleted ? 'completed' : 'success', $justCompleted ? 'Task completed — brilliant work!' : 'Task updated.');
        } catch (QueryException $e) {
            report($e);

            return back()->withInput()->with('error', 'We could not update that task. Please try again.');
        }
    }

    public function destroy(Project $project, Task $task)
    {
        $this->guardNested($project, $task);
        try {
            $task->delete();

            return redirect()->route('projects.show', $project)->with('success', 'Task removed.');
        } catch (QueryException $e) {
            report($e);

            return back()->with('error', 'The task could not be deleted.');
        }
    }

    private function guardNested(Project $project, Task $task): void
    {
        $this->authorize('view', $project);
        abort_unless($task->project_id === $project->id, 404);
        $this->authorize('view', $task);
    }
}
