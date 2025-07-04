<?php

namespace Modules\Project\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Modules\Project\Models\Project;

interface ProjectRepositoryInterface
{
    public function getAll(): Collection;

    public function findById(int $id): ?Project;

    public function create(array $data): Project;

    public function update(Project $project, array $data): Project;

    public function delete(Project $project): bool;
}
