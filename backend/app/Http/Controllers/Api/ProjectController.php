<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('projects.view');
        $query = Project::query()
        ->with(['supervisor:id,username,email,avatar'])
        ->withCount('tasks');

    // doar proiectele mele? /api/projects?only_mine=1
    if ($request->boolean('only_mine')) {
        $query->where('user_id', $request->user()->id);
    }

    // filtrare după status /api/projects?status=active
    if ($status = $request->query('status')) {
        $query->where('status', $status);
    }

    $projects = $query
        ->latest('id')
        ->paginate($request->integer('per_page', 15));

    return ProjectResource::collection($projects);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        Gate::authorize('projects.manage'); 
        $data = $request->validated();

        $project = new Project($data);
        $project->user_id = $request->user()->id; // <- setat din auth
        $project->save();

        $project->load(['supervisor:id,username,email']);

        return (new ProjectResource($project))
        ->response()
        ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Gate::authorize('projects.view');
        $project = Project::with(['supervisor:id,username,email,avatar'])->findOrFail($id);
        return new ProjectResource($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, string $id)
    {
        Gate::authorize('projects.manage');
        $project = Project::findOrFail($id);
        $project->update($request->validated());
        $project->load(['supervisor:id,username,email,avatar','tasks']);

        return new ProjectResource($project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('projects.manage');
        $project = Project::findOrFail($id);
        $project->delete();

        return response()->noContent();
    }
}
