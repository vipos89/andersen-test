<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\RepositoryInterfaces\TransactionInterface;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Collection;

class TransactionRepository implements TransactionInterface
{
    /**
     * Get all user transactions
     *
     * @param int $userId
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
