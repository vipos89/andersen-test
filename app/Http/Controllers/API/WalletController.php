<?php
declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\WalletResource;
use App\Interfaces\RepositoryInterfaces\WalletInterface;
use App\Services\WalletService;
use App\Traits\Api\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Exception;

class   WalletController extends Controller
{
    use ApiResponse;

    /**
     * @var WalletInterface
     */
    private $walletRepository;
    /**
     * @var WalletService
     */
    private $walletService;

    /**
     * WalletController constructor.
     *
     * @param WalletInterface $walletRepository (walletRepository)
     * @param WalletService $walletService
     */
    public function __construct(WalletInterface $walletRepository, WalletService $walletService)
    {
        $this->walletRepository = $walletRepository;
        $this->walletService = $walletService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return JsonResponse
     */
    public function store(): JsonResponse
    {
        try {
            $data = $this->walletService
                ->createWalletForUser(
                    auth()->user()->getAuthIdentifier()
                );
            return $this->successResponse(
                'Wallet created',
                new WalletResource($data)
            );
        } catch (Exception $exception) {
            return $this->errorResponse(
                $exception->getMessage(),
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }
    }

    /**
     * Get wallet info
     *
     * @param string $id hash id of wallet
     *
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        try {
            $wallet = $this->walletRepository->getWalletByHash($id);
            if (!$wallet) {
                throw new ModelNotFoundException('Wallet not found');
            }
            return $this->successResponse('Wallet info', new WalletResource($wallet));
        } catch (Exception $exception) {
            return $this->errorResponse(
                $exception->getMessage(),
                Response::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * Get all transactions by Wallet
     *
     * @param string $walletId (wallet hash)
     *
     * @return JsonResponse
     */
    public function transactions(string $walletId): JsonResponse
    {
        try {
            $data = $this->walletRepository->getWalletTransactions($walletId);
            return $this->successResponse(
                'Transactions info',
                WalletResource::collection($data)
            );
        } catch (Exception $exception) {
            return $this->errorResponse(
                $exception->getMessage(),
                Response::HTTP_NOT_FOUND
            );
        }
    }
}
