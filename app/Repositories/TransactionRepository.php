<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\RepositoryInterfaces\TransactionInterface;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Services\TransactionService;
use App\Traits\Api\ApiResponse;
use Illuminate\Support\Facades\DB;

class TransactionRepository implements TransactionInterface
{
    use ApiResponse;

    /**
     * @param $walletFromId
     * @param $walletToId
     * @param $amount (satoshi)
     * @return mixed|void
     */
    public function createTransaction(string $walletFromId, string $walletToId, int $amount)
    {
        $walletFrom = Wallet::findOrFail($walletFromId);
        $walletTo = Wallet::findOrFail($walletToId);
        return (new TransactionService())->createTransaction($walletFrom, $walletTo, $amount);
    }

    /**
     * @inheritDoc
     */
    public function getUserTransactions($userId)
    {
        $walletIds = Wallet::where('user_id', $userId)->pluck('id')->toArray();
        return WalletTransaction::whereIn('from', $walletIds)
            ->orWhereIn('to', $walletIds)
            ->get();
    }
}
