<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\RepositoryInterfaces\TransactionInterface;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Services\TransactionService;
use Exception;
use Illuminate\Support\Collection;

class TransactionRepository implements TransactionInterface
{
    /**
     * Create transaction from wallet to wallet
     *
     * @param  $walletFromId
     * @param  $walletToId
     * @param  $amount (satoshi)
     *
     * @return WalletTransaction
     * @throws Exception
     */
    public function createTransaction(string $walletFromId, string $walletToId, int $amount): WalletTransaction
    {
        return (new TransactionService())
            ->createTransaction($walletFromId, $walletToId, $amount);
    }


    /**
     * Get all user transactions
     *
     * @param  int $userId
     *
     * @return Collection|Wallet
     */
    public function getUserTransactions($userId): Collection
    {
        $walletIds = Wallet::where('user_id', $userId)->pluck('id')->toArray();
        return WalletTransaction::whereIn('from', $walletIds)
            ->orWhereIn('to', $walletIds)
            ->get();
    }
}
