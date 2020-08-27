<?php
declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\RepositoryInterfaces\WalletInterface;
use App\Traits\Api\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WalletController extends Controller
{
    use ApiResponse;

    /**
     * @var WalletInterface
     */
    private $walletRepository;

    /**
     * WalletController constructor.
     *
     * @param WalletInterface $walletRepository
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
            $data = $this->walletRepository->createWallet(auth()->user()->getAuthIdentifier());
            return $this->successResponse('Wallet created', $data);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), []);
        }
    }

    /**
     * Get wallet info
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        try {
            $data = $this->walletRepository->getWalletByHash($id);
            return $this->successResponse('Wallet info', $data);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), []);
        }
    }

    /**
     * Get all transactions by Wallet
     *
     * @param string $walletId
     * @return JsonResponse
     */
    public function transactions(string $walletId): JsonResponse
    {
        try {
            $data = $this->walletRepository->getWalletTransactions($walletId);
            return $this->successResponse('Transactions info', $data);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), []);
        }
    }
}
