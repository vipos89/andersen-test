<?php


namespace App\Repositories;


use App\Http\Requests\UserRequest;
use App\Interfaces\RepositoryInterfaces\UserInterface;
use App\Models\User;
use App\Traits\Api\ApiResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserRepository implements UserInterface
{
    use ApiResponse;


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllUsers()
    {
        try {
            return $this->successResponse('All users', User::all());
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @inheritDoc
     */
    public function getUserById($id)
    {
        try {
            return $this->successResponse('User details', User::firstOrFail($id));
        } catch (\Exception $exception) {
            return $this->errorResponse('User not found', 404);
        }
    }


    /**
     * @param UserRequest $request
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function requestUser(UserRequest $request, $id = null)
    {
        DB::beginTransaction();
        try {
            $user = $id ? User::find($id) : new User;
            if ($id && !$user) {
                return $this->errorResponse("No user with ID $id", 404);
            }
            $user->fill($request->all());
            if (!$id) {
                $user->password = Hash::make($request->password);
                $user->api_token = Str::random(80);
            }
            $user->save();
            DB::commit();
            return $this->successResponse(
                $id ? "User updated"
                    : "User created",
                $id ? $user : ['api_token' => $user->api_token], !$id ? 200 : 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @inheritDoc
     */
    public function deleteUser($id)
    {
        DB::beginTransaction();
        try {
            $user = User::find($id);

            // Check the user
            if (!$user) {
                return $this->error("No user with ID $id", 404);
            }

            // Delete the user
            $user->delete();
            DB::commit();
            return $this->success("User deleted", $user);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}
