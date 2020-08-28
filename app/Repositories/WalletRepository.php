<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Http\Resources\WalletResource;
use App\Interfaces\RepositoryInterfaces\WalletInterface;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Services\WalletService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        return (new WalletService())->createWalletForUser($userId);
    }

    /**
     * Get info about wallet by hash
     *
     * @param string $hash
     *
     * @return WalletResource
     */
    public function getWalletByHash(string $hash): WalletResource
    {
        $wallet = Wallet::find($hash);
        if (!$wallet) {
            throw new ModelNotFoundException('Wallet not found');
        }

        return new WalletResource($wallet);
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
