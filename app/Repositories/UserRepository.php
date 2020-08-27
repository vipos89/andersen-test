<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Http\Requests\UserRequest;
use App\Interfaces\RepositoryInterfaces\UserInterface;
use App\Models\User;
use App\Traits\Api\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserRepository implements UserInterface
{

    /**
     * Create new user
     *
     * @param  UserRequest $request
     * @return User
     * @throws Exception
     */
    public function requestUser(UserRequest $request): User
    {
        try {
            $user = new User($request->all());
            $user->password = Hash::make($request->password);
            $user->api_token = Str::random(80);
            $user->save();
            return $user;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
