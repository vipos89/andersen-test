<?php


namespace App\Repositories;


use App\Interfaces\RepositoryInterfaces\TransactionInterface;
use App\Models\Wallet;
use App\Models\WalletTransaction;
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
        DB::beginTransaction();
        try {
            $walletFrom = Wallet::findOrFail($walletFromId);
            $walletTo = Wallet::findOrFail($walletToId);
            $commission = ($walletFrom->user_id == $walletTo->user_id) ? 0 : round(config('wallets.commission_size_in_percents') * $amount);
            if ($walletFrom->satoshi_balance >= $commission + $amount) {
                $transaction = WalletTransaction::create([
                    'from' => $walletFromId,
                    'to' => $walletToId,
                    'amount' => $amount,
                    'commission' => $commission
                ]);
                $walletFrom->satoshi_balance -= ($commission + $amount);
                $walletTo->satoshi_balance += $amount;
                $walletFrom->save();
                $walletTo->save();

            }
            DB::commit();
            return $this->successResponse('Success', $transaction);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), null);
        }
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
