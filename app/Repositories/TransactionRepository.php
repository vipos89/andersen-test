<?php


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
    public function createTransaction($walletFromId, $walletToId, $amount)
    {
        $res = (new TransactionService())->createTransaction($walletFromId, $walletToId, $amount);
    }

    /**
     * @inheritDoc
     */
    public function getUserTransactions($userId)
    {
        $walletIds = Wallet::where('user_id', $userId)->pluck('id')->toArray();
        try {
            $transactions = WalletTransaction::whereIn('from', $walletIds)
                ->orWhereIn('to', $walletIds)
                ->get();
            return $this->successResponse('Success', $transactions, 200);
        } catch (\Exception $exception) {
            $this->errorResponse($exception->getMessage());
        }
    }
}
