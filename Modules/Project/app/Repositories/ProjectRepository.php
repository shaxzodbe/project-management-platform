<?php

namespace Modules\Project\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\Project\Interfaces\ProjectRepositoryInterface;
use Modules\Project\Models\Project;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function getAll(): Collection
    {
        return Project::all();
    }

    public function findById(int $id): ?Project
    {
        return Project::find($id);
    }

    public function create(array $data): Project
    {
        return Project::create($data);
    }

    public function update(Project $project, array $data): Project
    {
        $project->update($data);
        return $project;
    }

    public function delete(Project $project): bool
    {
        return $project->delete();
    }
}
