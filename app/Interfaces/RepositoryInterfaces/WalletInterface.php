<?php


namespace App\Interfaces\RepositoryInterfaces;


use App\Http\Requests\UserRequest;

Interface WalletInterface
{
    /**
     * Get user's wallets
     *
     * @method  GET api/wallets
     *
     */
    public function getUserWallets();

    /**
     * Create new Wallet for current user
     * @method POST api/wallets
     * @param  $userId
     * @return mixed
     */
    public function createWallet($userId);

    /**
     * Get wallet by address
     * @method GET api/wallets/{address}
     * @param $address
     * @return mixed
     */
    public function getWalletByHash($address);

    /**
     * Get wallet transactions
     * @method GET api/wallets/{address}/transactions
     * @param $address
     * @return mixed
     */
    public function getWalletTransactions($address);

}
