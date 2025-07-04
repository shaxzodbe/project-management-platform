<?php

namespace Modules\Task\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Task\Http\Requests\AssignTaskRequest;
use Modules\Task\Http\Requests\CreateTaskRequest;
use Modules\Task\Http\Requests\UpdateTaskStatusRequest;
use Modules\Task\Models\Task;
use Modules\Task\Services\TaskService;
use Modules\Task\Transformers\TaskResource;

class TaskController extends Controller
{
    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(): JsonResponse
    {
        $tasks = $this->taskService->getAllTasks();
        return TaskResource::collection($tasks)->response()->setStatusCode(200);
    }

    public function store(CreateTaskRequest $request): JsonResponse
    {
        $task = $this->taskService->createTask($request->validated());
        return (new TaskResource($task))->response()->setStatusCode(201);
    }

    public function show(Task $task): JsonResponse
    {
        $this->authorize('view', $task);
        return (new TaskResource($task))->response()->setStatusCode(200);
    }

    public function assign(AssignTaskRequest $request, Task $task): JsonResponse
    {
        $assignee = User::findOrFail($request->validated('assigned_to_user_id'));
        $updatedTask = $this->taskService->assignTask($task, $assignee);
        return (new TaskResource($updatedTask))->response()->setStatusCode(200);
    }

    public function updateStatus(UpdateTaskStatusRequest $request, Task $task): JsonResponse
    {
        $updatedTask = $this->taskService->updateTaskStatus($task, $request->validated('status'));
        return (new TaskResource($updatedTask))->response()->setStatusCode(200);
    }

    public function update(Request $request, Task $task): JsonResponse
    {
        $this->authorize('update', $task);
        $updatedTask = $this->taskService->updateTask($task, $request->validated());
        return (new TaskResource($updatedTask))->response()->setStatusCode(200);
    }

    public function destroy(Task $task): JsonResponse
    {
        $this->authorize('delete', $task);
        $this->taskService->deleteTask($task);
        return response()->json(null, 204);
    }
}
