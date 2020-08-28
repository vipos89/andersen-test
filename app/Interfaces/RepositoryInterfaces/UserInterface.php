<?php


namespace App\Interfaces\RepositoryInterfaces;

use App\Http\Requests\UserRequest;

interface UserInterface
{
    /**
     * Create
     *
     * @param  UserRequest $request
     * @access public
     */
    public function requestUser(UserRequest $request);
}
