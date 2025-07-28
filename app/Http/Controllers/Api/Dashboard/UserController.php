<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UserCreateRequest;
use App\Http\Requests\Dashboard\UserUpdateRequest;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use App\Services\Dashboard\UserService;

class UserController extends Controller
{
    use ResponseTrait;

    public function __construct(protected UserService $service)
    {
    }

    public function index(Request $request)
    {
        try {
            $users = $this->service->getAllUsers($request);
            return $this->showResponse($users);
        } catch (\Exception $e) {
            return $this->showError($e);
        }
    }

    public function show(string $user_id)
    {
        try {
            $user = $this->service->getUser($user_id);
            return $this->showResponse($user);
        } catch (\Exception $e) {
            return $this->showError($e);
        }
    }

    public function store(UserCreateRequest $request)
    {
        try {
            $user = $this->service->createUser($request);
            return $this->showResponse($user);
        } catch (\Exception $e) {
            return $this->showError($e);
        }
    }

    public function update(UserUpdateRequest $request, string $user_id)
    {
        try {
            $user = $this->service->updateUser($request, $user_id);
            return $this->showResponse($user);
        } catch (\Exception $e) {
            return $this->showError($e);
        }
    }

    public function destroy(string $user_id)
    {
        try {
            $this->service->deleteUser($user_id);
            return $this->showMessage('operation done successfully !!');
        } catch (\Exception $e) {
            return $this->showError($e);
        }
    }

    public function statusChange(string $user_id)
    {
        try {
            $bool = $this->service->statusChange($user_id);
            return match ($bool) {
                false => $this->showMessage("User unblocked successfully !!"),
                true => $this->showMessage("User blocked successfully !!"),
            };
        } catch (\Exception $e) {
            return $this->showError($e);
        }
    }


}
