<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\RepositoryInterfaces\TransactionInterface;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Services\TransactionService;
use App\Traits\Api\ApiResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TransactionRepository implements TransactionInterface
{
    use ApiResponse;

    /**
     * Create transaction from wallet to wallet
     *
     * @param  $walletFromId
     * @param  $walletToId
     * @param  $amount       (satoshi)
     * @return mixed|void
     * @throws \Exception
     */
    public function createTransaction(string $walletFromId, string $walletToId, int $amount)
    {
        return (new TransactionService())->createTransaction($walletFromId, $walletToId, $amount);
    }


    /**
     * Get all user transactions
     *
     * @param  int $userId
     * @return Collection
     */
    public function getUserTransactions($userId)
    {
        $walletIds = Wallet::where('user_id', $userId)->pluck('id')->toArray();
        return WalletTransaction::whereIn('from', $walletIds)
            ->orWhereIn('to', $walletIds)
            ->get();
    }
}
