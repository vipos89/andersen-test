<?php


namespace App\Services;

use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionService
{
    /**
     * @param Wallet $walletFrom
     * @param Wallet $walletTo
     * @param int $amount
     * @return mixed
     */
    public function createTransaction(Wallet $walletFrom, Wallet $walletTo, int $amount)
    {
        DB::beginTransaction();
        try {
            $commission = ($walletFrom->user_id === $walletTo->user_id)
                ? 0 : round(config('wallets.commission_size_in_percents') * $amount);
            if ($walletFrom->satoshi_balance >= $commission + $amount) {
                $transaction = WalletTransaction::create(
                    [
                        'from' => $walletFrom->user_id,
                        'to' => $walletTo->user_id,
                        'amount' => $amount,
                        'commission' => $commission
                    ]
                );
                $walletFrom->satoshi_balance -= ($commission + $amount);
                $walletTo->satoshi_balance += $amount;
                $walletFrom->save();
                $walletTo->save();
                DB::commit();
                return $transaction;
            }

        } catch (\Exception $e) {
            Log::alert($e->getMessage());
            return false;
        }
    }
}
