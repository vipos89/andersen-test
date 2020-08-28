<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Http\Requests\UserRequest;
use App\Interfaces\RepositoryInterfaces\UserInterface;
use App\Models\User;
use App\Services\UserService;
use Exception;

class UserRepository implements UserInterface
{
    /**
     * Create new user
     *
     * @param UserRequest $request
     * @return User
     * @throws Exception
     */
    public function requestUser(UserRequest $request): User
    {
        return (new UserService())->createUser($request->all());
    }
}
