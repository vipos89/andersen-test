<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\RepositoryInterfaces\WalletInterface;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    /**
     * @var WalletInterface
     */
    private $walletRepository;

    public function __construct(WalletInterface $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->walletRepository->createWallet(auth()->user()->getAuthIdentifier());
    }

    public function show(Request $request, $id)
    {
        return $this->walletRepository->getWalletByHash($id);
    }

    public function transactions(Request $request, $walletId)
    {
        return $this->walletRepository->getWalletTransactions($walletId);
    }

}
