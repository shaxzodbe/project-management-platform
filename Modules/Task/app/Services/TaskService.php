<?php

namespace Modules\Task\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Modules\Task\Enums\TaskStatusEnum;
use Modules\Task\Interfaces\TaskRepositoryInterface;
use Modules\Task\Jobs\SendTaskAssignedNotification;
use Modules\Task\Models\Task;

class TaskService
{
    protected TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function getAllTasks(): Collection
    {
        return $this->taskRepository->getAll();
    }

    public function getTaskById(int $id): ?Task
    {
        return $this->taskRepository->findById($id);
    }

    public function createTask(array $data): Task
    {
        $data['status'] = $data['status'] ?? TaskStatusEnum::Pending->value;
        return $this->taskRepository->create($data);
    }

    public function assignTask(Task $task, User $assignee): Task
    {
        $task->assigned_to_user_id = $assignee->id;
        $task->save();

        SendTaskAssignedNotification::dispatch($task, $assignee);

        return $task;
    }

    public function updateTaskStatus(Task $task, string $status): Task
    {
        if (!TaskStatusEnum::tryFrom($status)) {
            throw new \InvalidArgumentException('Invalid task status provided.');
        }

        $task->status = $status;
        $task->save();
        return $task;
    }

    public function updateTask(Task $task, array $data): Task
    {
        return $this->taskRepository->update($task, $data);
    }

    public function deleteTask(Task $task): bool
    {
        return $this->taskRepository->delete($task);
    }
}
