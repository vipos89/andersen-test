<?php


namespace App\Interfaces\RepositoryInterfaces;

use App\Http\Requests\UserRequest;

interface UserInterface
{
    /**
     * Create
     *
     * @param  UserRequest $request
     * @method POST    api/users
     * @access public
     */
    public function requestUser(UserRequest $request);
}
