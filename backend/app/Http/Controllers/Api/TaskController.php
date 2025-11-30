<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskController extends Controller
{
    // GET /api/projects/{project}/tasks
    public function index(Project $project)
    {
        $tasks = $project->tasks()
            ->with('assignee')
            ->orderByRaw("FIELD(status, 'todo','doing','done')")
            ->orderBy('position')
            ->orderBy('id')
            ->get();

        return TaskResource::collection($tasks);
    }

    // POST /api/projects/{project}/tasks
    public function store(StoreTaskRequest $request, Project $project)
    {
        $data = $request->validated();
        $data['project_id'] = $project->id;

        // status default
        if (empty($data['status'])) {
            $data['status'] = 'todo';
        }

        $task = Task::create($data);

        return (new TaskResource($task->load('assignee')))
            ->response()
            ->setStatusCode(201);
    }

    // GET /api/tasks/{task}
    public function show(Task $task)
    {
        return new TaskResource($task->load(['project','assignee']));
    }

    // PATCH /api/tasks/{task}
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        return new TaskResource($task->fresh()->load(['project','assignee']));
    }

    // DELETE /api/tasks/{task}
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->noContent(); // 204
    }

    // GET /api/my-tasks
    public function myTasks(Request $request)
    {
        $tasks = Task::where('user_id', $request->user()->id)
            ->with('project')
            ->orderByRaw("FIELD(status, 'todo','doing','done')")
            ->orderBy('due_date')
            ->get();

        return TaskResource::collection($tasks);
    }

    // POST /api/tasks/{task}/take
    public function take(Task $task, Request $request)
    {
        // dacă e deja asignat altcuiva → eroare
        if ($task->user_id && $task->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'This task is already taken by another user.',
            ], 422);
        }

        // if it was unassigned or already yours, îl setezi pe tine
        $task->user_id = $request->user()->id;

        // opțional: dacă era todo -> doing
        if ($task->status === 'todo') {
            $task->status = 'doing';
        }

        $task->save();

        return new TaskResource($task->fresh()->load(['project','assignee']));
    }
}
