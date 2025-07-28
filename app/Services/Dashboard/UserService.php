<?php
namespace App\Services\Dashboard;

use App\Filters\Dashboard\UserFilter;
use App\Http\Requests\Dashboard\UserCreateRequest;
use App\Http\Requests\Dashboard\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UserService
{
    public function __construct(protected UserFilter $filter)
    {
    }

    public function getAllUsers(Request $request)
    {
        $users = User::query();
        $filteredData = $this->filter->apply($users)
            ->get()
            ->makeVisible("is_blocked");
        return $filteredData;
    }

    public function getUser(string $user_id)
    {
        $user = User::findOrFail($user_id)
            ->makeVisible("is_blocked");
        return $user;
    }

    public function createUser(UserCreateRequest $request)
    {
        $data = $request->validated();
        $user = User::create($request->except("role"));
        $user->assignRole($data["role"]);
        return $user;
    }

    public function updateUser(UserUpdateRequest $request, string $user_id)
    {
        $user = User::findOrFail($user_id);
        return DB::transaction(function () use ($user, $request) {
            $data = $request->validated();
            $user->update($request->except("role"));
            if (isset($data["role"])) {
                $user->syncRoles($data["role"]);
            }
            return $user;
        });
    }

    public function deleteUser(string $user_id)
    {
        DB::transaction(function () use ($user_id) {
            $user = User::findOrFail($user_id);
            $user->delete();
        });
    }

    public function statusChange(string $user_id)
    {
        $user = User::findOrFail($user_id);
        return DB::transaction(function () use ($user) {
            $user->is_blocked = !$user->is_blocked;
            $user->save();
            return $user->is_blocked;
        });
    }

}