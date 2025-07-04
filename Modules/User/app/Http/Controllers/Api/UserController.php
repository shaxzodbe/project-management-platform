<?php

namespace Modules\User\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Modules\User\Http\Requests\CreateUserRequest;
use Modules\User\Http\Requests\UpdateUserRequest;
use Modules\User\Services\UserService;
use Modules\User\Transformers\UserResource;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(): JsonResponse
    {
        $this->authorize('viewAny', User::class);
        $users = $this->userService->getAllUsers();
        return UserResource::collection($users)->response()->setStatusCode(200);
    }

    public function store(CreateUserRequest $request): JsonResponse
    {
        $user = $this->userService->createUser($request->validated());
        return (new UserResource($user))->response()->setStatusCode(201);
    }

    public function show(User $user): JsonResponse
    {
        $this->authorize('view', $user);
        return (new UserResource($user))->response()->setStatusCode(200);
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $updatedUser = $this->userService->updateUser($user, $request->validated());
        return (new UserResource($updatedUser))->response()->setStatusCode(200);
    }

    public function destroy(User $user): JsonResponse
    {
        $this->authorize('delete', $user);
        $this->userService->deleteUser($user);
        return response()->json(null, 204);
    }
}
