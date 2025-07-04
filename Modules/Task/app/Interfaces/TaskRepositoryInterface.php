<?php

namespace Modules\Task\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Modules\Task\Models\Task;

interface TaskRepositoryInterface
{
    public function getAll(): Collection;

    public function findById(int $id): ?Task;

    public function create(array $data): Task;

    public function update(Task $task, array $data): Task;

    public function delete(Task $task): bool;
}
