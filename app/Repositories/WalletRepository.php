<?php

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
     * @inheritDoc
     */
    public function createWallet($userId)
    {
        $walletsCount = Wallet::where('user_id', $userId)->count();
        if ($walletsCount < config('wallets.wallets_max_count')) {
            $wallet = Wallet::create([
                'user_id' => $userId,
                'satoshi_balance' => self::START_SATOSHI_BALANCE
            ]);
            return $this->successResponse('success', new WalletResource($wallet), 200);
        }
        return $this->errorResponse('You can\'t create wallet', [], 403);
    }

    /**
     * @inheritDoc
     */
    public function getWalletByHash($hash)
    {
        try {
            return $this->successResponse('Success', new WalletResource(Wallet::findOrFail($hash)), 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Wallet not found', [], 404);
        }
    }

    /**
     * @inheritDoc
     */
    public function getWalletTransactions($address)
    {
        $transactions = WalletTransaction::where('from', $address)
            ->orWhere('to', $address)
            ->get();
        try {
            return $this->successResponse('Success', $transactions, 200);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), null);
        }
    }
}
