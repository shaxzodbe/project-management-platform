<?php

namespace Modules\Task\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Task\Models\Task;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     */
    public function __construct() {}

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-any-task');
    }

    public function view(User $user, Task $task): bool
    {
        return $user->id === $task->project->user_id ||
            $user->id === $task->assigned_to_user_id ||
            $user->hasPermissionTo('view-task');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-task');
    }

    public function update(User $user, Task $task): bool
    {
        return ($user->id === $task->project->user_id || $user->id === $task->assigned_to_user_id) ||
            $user->hasPermissionTo('update-task');
    }

    public function assign(User $user, Task $task): bool
    {
        return $user->id === $task->project->user_id || $user->hasPermissionTo('assign-task');
    }

    public function updateStatus(User $user, Task $task): bool
    {
        return ($user->id === $task->project->user_id || $user->id === $task->assigned_to_user_id) ||
            $user->hasPermissionTo('update-task-status');
    }

    public function delete(User $user, Task $task): bool
    {
        return $user->id === $task->project->user_id || $user->hasPermissionTo('delete-task');
    }
}
