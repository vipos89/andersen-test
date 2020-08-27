<?php
declare(strict_types=1);

namespace App\Http\Resources;

use GabrielAndy\Coindesk\Facades\Coindesk;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'btc' => $this->btc_balance,
            'usd' => Coindesk::toCurrency('usd', $this->btc_balance)
        ];
    }
}
