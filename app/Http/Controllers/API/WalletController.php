<?php
declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\WalletResource;
use App\Interfaces\RepositoryInterfaces\WalletInterface;
use App\Traits\Api\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class   WalletController extends Controller
{
    use ApiResponse;

    /**
     * @var WalletInterface
     */
    private $walletRepository;

    /**
     * WalletController constructor.
     *
     * @param WalletInterface $walletRepository (walletRepository)
     */
    public function __construct(WalletInterface $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return JsonResponse
     */
    public function store(): JsonResponse
    {
        try {
            $data = $this->walletRepository->createWallet(
                auth()->user()->getAuthIdentifier()
            );
            return $this->successResponse('Wallet created', new WalletResource($data));
        } catch (Exception $exception) {
            return $this->errorResponse(
                $exception->getMessage(),
                Response::HTTP_UNPROCESSABLE_ENTITY
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
            $data = $this->walletRepository->getWalletByHash($id);
            return $this->successResponse('Wallet info', new WalletResource($data));
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
