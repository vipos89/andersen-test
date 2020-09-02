<?php
declare(strict_types=1);

namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService
{
    /**
     * @param  array $data
     * @return User
     */
    public function createUser(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        $data['api_token'] = Str::random(80);

        return factory(User::class)->create($data);
    }
}
