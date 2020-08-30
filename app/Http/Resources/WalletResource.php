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
     * @var WalletService
     */
    private $walletService;

    /**
     * WalletResource constructor.
     * @param $resource
     */
    public function __construct($resource)
    {
        $this->walletService = resolve(WalletService::class);
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'btc' => $this->walletService->convertToBTC((int)$this->satoshi_balance),
            'usd' => $this->walletService->convertToUsd((int)$this->satoshi_balance),
        ];
    }
}
