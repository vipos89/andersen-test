<?php


namespace App\Interfaces\RepositoryInterfaces;


interface TransactionInterface
{
    /**
     * Create new transaction
     * @method POST api/transactions/
     * @param $walletFrom
     * @param $walletTo
     * @param $amount
     * @return mixed
     */
    public function createTransaction(string $walletFrom, string $walletTo, int $amount);

    /**
     * Get all  users transactions
     * @method GET api/transactions/
     * @param $userId
     * @return mixed
     */
    public function getUserTransactions(int $userId);

}
