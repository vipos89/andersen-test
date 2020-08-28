<?php


namespace App\Interfaces\RepositoryInterfaces;


interface WalletInterface
{
    /**
     * Create new Wallet for current user
     *
     * @param  int $userId
     * @return mixed
     */
    public function createWallet(int $userId);

    /**
     * Get wallet by address
     *
     * @param  $address
     * @return mixed
     */
    public function getWalletByHash(string $address);

    /**
     * Get wallet transactions
     *
     * @param  $address
     * @return mixed
     */
    public function getWalletTransactions(string $address);
}
