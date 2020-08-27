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
    public function store()
    {
        try {
            $data = $this->walletRepository->createWallet(auth()->user()->getAuthIdentifier());
            return $this->successResponse('Wallet created', $data);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), []);
        }
    }

    /**
     * @param  $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->walletRepository->getWalletByHash($id);
    }

    /**
     * Get all transactions by Wallet
     *
     * @param  $walletId
     * @return mixed
     */
    public function transactions(string $walletId)
    {
        return $this->walletRepository->getWalletTransactions($walletId);
    }
}
