<?php
declare(strict_types=1);

namespace App\Services;


use App\Models\Wallet;
use Exception;
use GabrielAndy\Coindesk\Facades\Coindesk;

class WalletService
{
    /**
     * @param int $userId
     * @return Wallet
     * @throws Exception
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

    /**
     * Convert Satoshi to btc
     *
     * @param int $satochiBalance
     * @return float|int
     */
    public function convertToBTC(int $satochiBalance)
    {
        return $satochiBalance / Wallet::START_SATOSHI_BALANCE;
    }

    /**
     * @param int $satoshiBalance
     *
     * @return  float|int
     */
    public function convertToUsd(int $satoshiBalance)
    {
        return Coindesk::toCurrency('usd', $this->convertToBTC($satoshiBalance));
    }
}
