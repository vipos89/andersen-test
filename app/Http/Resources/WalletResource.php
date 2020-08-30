<?php
declare(strict_types=1);

namespace App\Http\Resources;

use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $satoshi_balance
 * @property int $id
 */
class WalletResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $walletService = new WalletService();
        return [
            'id' => $this->id,
            'btc' => $walletService->convertToBTC($this->satoshi_balance),
            'usd' => $this->$walletService->convertToUsd($this->satoshi_balance),
        ];
    }
}
