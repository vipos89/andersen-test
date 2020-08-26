<?php


namespace App\Interfaces\RepositoryInterfaces;

use App\Http\Requests\UserRequest;

interface WalletInterface
{
    /**
     * Create new Wallet for current user
     * @method POST api/wallets
     * @param  int $userId
     * @return mixed
     */
    public function createWallet(int $userId);

    /**
     * Get wallet by address
     * @method GET api/wallets/{
    address
    }
     * @param $address
     * @return mixed
     */
    public function getWalletByHash($address);

    /**
     * Get wallet transactions
     * @method GET api/wallets/{
    address
    }/transactions
     * @param $address
     * @return mixed
     */
    public function getWalletTransactions($address);
}
