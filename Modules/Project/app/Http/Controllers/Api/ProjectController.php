<?php

namespace Modules\Project\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Project\Http\Requests\CreateProjectRequest;
use Modules\Project\Http\Requests\UpdateProjectRequest;
use Modules\Project\Models\Project;
use Modules\Project\Services\ProjectService;
use Modules\Project\Transformers\ProjectResource;

class ProjectController extends Controller
{
    protected ProjectService $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index(): JsonResponse
    {
        $projects = $this->projectService->getAllProjects();
        return ProjectResource::collection($projects)->response()->setStatusCode(200);
    }

    public function store(CreateProjectRequest $request): JsonResponse
    {
        $project = $this->projectService->createProject($request->validated());
        return (new ProjectResource($project))->response()->setStatusCode(201);
    }

    public function show(Project $project): JsonResponse
    {
        $this->authorize('view', $project);
        return (new ProjectResource($project))->response()->setStatusCode(200);
    }

    public function update(UpdateProjectRequest $request, Project $project): JsonResponse
    {
        $updatedProject = $this->projectService->updateProject($project, $request->validated());
        return (new ProjectResource($updatedProject))->response()->setStatusCode(200);
    }

    public function destroy(Project $project): JsonResponse
    {
        $this->authorize('delete', $project);
        $this->projectService->deleteProject($project);
        return response()->json(null, 204);
    }
}
