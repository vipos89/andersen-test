<?php


namespace App\Services;


use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;

class TransactionService
{
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
}
