<?php
declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $from
 * @property string $to
 * @property int $amount
 * @property int commission
 */
class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'from'=>$this->from,
            'to' => $this->to,
            'amount' => $this->amount,
            'commission' => $this->commission
        ];
    }
}
