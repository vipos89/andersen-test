<?php
declare(strict_types=1);

namespace App\Models;

use GabrielAndy\Coindesk\Facades\Coindesk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property int satoshi_balance
 * @property int user_id
 */
class Wallet extends Model
{
    public const START_SATOSHI_BALANCE = 100000000;

    protected $guarded = [];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(
            static function ($model) {
                $model->{$model->getKeyName()} = (string)Str::uuid();
            }
        );
    }

    /**
     * @return bool
     */
    public function getIncrementing(): bool
    {
        return false;
    }

    /**
     * @return string
     */
    public function getKeyType(): string
    {
        return 'string';
    }


    /**
     * Mutator: converts satoshi to BTC
     *
     * @return int
     */
    public function getBtcBalanceAttribute(): int
    {
        return $this->attributes['satoshi_balance'] /
            Wallet::START_SATOSHI_BALANCE;
    }

    /**
     * Mutator: converts satoshi to usd
     *
     */
    public function getUsdBalanceAttribute()
    {
        return Coindesk::toCurrency('usd', $this->btc_balance);
    }
}
