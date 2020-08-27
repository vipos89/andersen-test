<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Http\Resources\WalletResource;
use App\Interfaces\RepositoryInterfaces\WalletInterface;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Traits\Api\ApiResponse;

class WalletRepository implements WalletInterface
{
    use ApiResponse;

    public const START_SATOSHI_BALANCE = 100000000;


    /**
     * @param  int $userId
     * @return Wallet
     * @throws \Exception
     */
    public function createWallet(int $userId): Wallet
    {
        $walletsCount = Wallet::where('user_id', $userId)->count();
        if ($walletsCount < config('wallets.wallets_max_count')) {
            return Wallet::create(
                [
                'user_id' => $userId,
                'satoshi_balance' => self::START_SATOSHI_BALANCE
                ]
            );
        }
        throw new \Exception("Can't create more than " . config('wallets.wallets_max_count') . " wallets for user");
    }

    /**
     * Get info about wallet by hash
     *
     * @param  string $hash
     * @return WalletResource
     */
    public function getWalletByHash(string $hash): WalletResource
    {
        return WalletResource(Wallet::findOrFail($hash));
    }

    /**
     * Get all transactions by wallet
     *
     * @param  string $address
     * @return Collection|WalletTransaction
     */
    public function getWalletTransactions(string $address)
    {
        return WalletTransaction::where('from', $address)
            ->orWhere('to', $address)
            ->get();
    }
}
