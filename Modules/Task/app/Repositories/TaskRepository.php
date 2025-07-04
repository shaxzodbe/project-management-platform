<?php

namespace Modules\Task\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\Task\Interfaces\TaskRepositoryInterface;
use Modules\Task\Models\Task;

class TaskRepository implements TaskRepositoryInterface
{
    public function getAll(): Collection
    {
        return Task::all();
    }

    public function findById(int $id): ?Task
    {
        return Task::find($id);
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update(Task $task, array $data): Task
    {
        $task->update($data);
        return $task;
    }

    public function delete(Task $task): bool
    {
        return $task->delete();
    }
}
