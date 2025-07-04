<?php

namespace Modules\User\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $authenticatedUser): bool
    {
        return $authenticatedUser->hasPermissionTo('view-any-user');
    }

    public function view(User $authenticatedUser, User $modelUser): bool
    {
        if ($authenticatedUser->id === $modelUser->id) {
            return true;
        }

        return $authenticatedUser->hasPermissionTo('view-user');
    }

    public function create(User $authenticatedUser): bool
    {
        return $authenticatedUser->hasPermissionTo('create-user');
    }

    public function update(User $authenticatedUser, User $modelUser): bool
    {
        return $authenticatedUser->id === $modelUser->id ||
            $authenticatedUser->hasPermissionTo('update-user');
    }

    public function delete(User $authenticatedUser, User $modelUser): bool
    {
        return $authenticatedUser->id !== $modelUser->id &&
            $authenticatedUser->hasPermissionTo('delete-user');
    }
}
