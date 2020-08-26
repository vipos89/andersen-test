<?php
declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\RepositoryInterfaces\WalletInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WalletController extends Controller
{
    /**
     * @var WalletInterface
     */
    private $walletRepository;

    /**
     * WalletController constructor.
     * @param WalletInterface $walletRepository
     */
    public function __construct(WalletInterface $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        return $this->walletRepository->createWallet(auth()->user()->getAuthIdentifier());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->walletRepository->getWalletByHash($id);
    }

    /**
     * Get all transactions by Wallet
     * @param $walletId
     * @return mixed
     */
    public function transactions(string $walletId)
    {
        return $this->walletRepository->getWalletTransactions($walletId);
    }

}
