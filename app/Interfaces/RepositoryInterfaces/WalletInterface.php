<?php


namespace App\Interfaces\RepositoryInterfaces;


interface WalletInterface
{

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
