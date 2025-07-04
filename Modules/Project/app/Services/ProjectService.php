<?php

namespace Modules\Project\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Modules\Project\Interfaces\ProjectRepositoryInterface;
use Modules\Project\Models\Project;

class ProjectService
{
    protected ProjectRepositoryInterface $projectRepository;

    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function getAllProjects(): Collection
    {
        return $this->projectRepository->getAll();
    }

    public function getProjectById(int $id): ?Project
    {
        return $this->projectRepository->findById($id);
    }

    public function createProject(array $data): Project
    {
        $data['user_id'] = Auth::id();
        return $this->projectRepository->create($data);
    }

    public function updateProject(Project $project, array $data): Project
    {
        return $this->projectRepository->update($project, $data);
    }

    public function deleteProject(Project $project): bool
    {
        return $this->projectRepository->delete($project);
    }
}
