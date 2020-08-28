<?php
declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Interfaces\RepositoryInterfaces\UserInterface;
use App\Traits\Api\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    use ApiResponse;
    /**
     * @var UserInterface
     */
    private $userRepository;

    /**
     * UserController constructor.
     *
     * @param UserInterface $userRepository repository implementation
     */
    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  UserRequest $request validation
     *
     * @return JsonResponse
     */
    public function store(UserRequest $request): JsonResponse
    {
        try {
            $user = $this->userRepository->requestUser($request);
            return  $this->successResponse('User created',
                    ['api_token'=>$user->api_token]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), []);
        }
    }
}
