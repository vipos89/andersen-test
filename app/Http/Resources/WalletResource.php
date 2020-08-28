<?php
declare(strict_types=1);

namespace App\Http\Resources;

use GabrielAndy\Coindesk\Facades\Coindesk;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'btc' => $this->btc_balance,
            'usd' => Coindesk::toCurrency('usd', $this->btc_balance)
        ];
    }
}
