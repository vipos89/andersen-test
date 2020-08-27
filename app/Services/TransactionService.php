<?php


namespace App\Services;

use App\Models\Commission;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionService
{
    /**
     * @param  Wallet $walletFrom
     * @param  Wallet $walletTo
     * @param  int    $amount
     * @return mixed
     * @throws \Exception
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
                        'from' => $walletFrom->id,
                        'to' => $walletTo->id,
                        'amount' => $amount,
                        'commission' => $commission
                    ]
                );
                $walletFrom->satoshi_balance -= ($commission + $amount);
                $walletTo->satoshi_balance += $amount;
                $walletFrom->save();
                $walletTo->save();
                Commission::create(
                    [
                        'transaction_id' => $transaction->id,
                        'commission' => $commission,
                    ]
                );
                DB::commit();
                return $transaction;
            }
            throw new \Exception('Not enough credentials');
        } catch (\Exception $e) {
            Log::alert($e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }
}
