<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Http\Resources\WalletResource;
use App\Interfaces\RepositoryInterfaces\WalletInterface;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Services\WalletService;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class WalletRepository implements WalletInterface
{
    /**
     * @param int $userId
     *
     * @return Wallet
     * @throws Exception
     */
    public function createWallet(int $userId): Wallet
    {

    }

    /**
     * Get info about wallet by hash
     *
     * @param string $hash
     *
     * @return Wallet
     */
    public function getWalletByHash(string $hash): Wallet
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
