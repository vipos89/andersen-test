<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\RepositoryInterfaces\WalletInterface;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Database\Eloquent\Collection;

class WalletRepository implements WalletInterface
{
    /**
     * Get info about wallet by hash
     *
     * @param string $hash
     *
     * @return Wallet|null
     */
    public function getWalletByHash(string $hash): ?Wallet
    {
        return Wallet::find($hash);
    }

    /**
     * Get all transactions by wallet
     *
     * @param string $address
     *
     * @return Collection|WalletTransaction
     */
    public function getWalletTransactions(string $address)
    {
        return WalletTransaction::where('from', $address)
            ->orWhere('to', $address)
            ->get();
    }
}
