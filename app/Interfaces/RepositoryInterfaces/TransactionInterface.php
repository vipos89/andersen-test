<?php


namespace App\Interfaces\RepositoryInterfaces;


interface TransactionInterface
{
    /**
     * Get all  users transactions
     *
     * @param  $userId
     * @return mixed
     */
    public function getUserTransactions(int $userId);

}
