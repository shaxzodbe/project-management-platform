<?php

namespace Modules\Project\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Project\Models\Project;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     */
    public function __construct() {}

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-any-project');
    }

    public function view(User $user, Project $project): bool
    {
        return $user->id === $project->user_id || $user->hasPermissionTo('view-project');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-project');
    }

    public function update(User $user, Project $project): bool
    {
        return $user->id === $project->user_id || $user->hasPermissionTo('update-project');
    }

    public function delete(User $user, Project $project): bool
    {
        return $user->id === $project->user_id || $user->hasPermissionTo('delete-project');
    }
}
