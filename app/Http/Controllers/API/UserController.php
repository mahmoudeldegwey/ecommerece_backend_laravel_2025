<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Http\Services\UserService;
use App\Http\Requests\{CreateUserRequest,UpdateUserRequest};

class UserController
{

    public function __construct(private UserService $userService)
    {
    }

    public function index(Request $request)
    {
        return $this->userService->index($request);
    }

    public function store(CreateUserRequest $request)
    {
        return $this->userService->store($request);        
    }

    public function show(User $user){
        return $this->userService->show($user);
    }

    public function update(User $user,UpdateUserRequest $request)
    {
        return $this->userService->update($user,$request);   
    }

    public function updatePassword(User $user,UpdatePasswordRequest $request)
    {
        return $this->userService->updatePassword($user,$request);
    }

    public function destroy(User $user)
    {
        return $this->userService->destroy($user);
    }
}
