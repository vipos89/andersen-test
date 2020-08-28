<?php


namespace App\Services;


use App\Models\Wallet;

class WalletService
{
    /**
     * @param int $userId
     * @return Wallet
     */
    public function createWalletForUser(int $userId): Wallet
    {
        $walletsCount = Wallet::where('user_id', $userId)->count();
        if ($walletsCount < config('wallets.wallets_max_count')) {
            return Wallet::create(
                [
                    'user_id' => $userId,
                    'satoshi_balance' => Wallet::START_SATOSHI_BALANCE
                ]
            );
        }
        throw new Exception("Can't create more than " . config('wallets.wallets_max_count') . " wallets for user");
    }
}
