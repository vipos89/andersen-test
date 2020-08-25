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
    public function createTransaction($walletFrom, $walletTo, $amount);

    /**
     * Get all  users transactions
     * @method GET api/transactions/
     * @param $userId
     * @return mixed
     */
    public function getUserTransactions($userId);

}
