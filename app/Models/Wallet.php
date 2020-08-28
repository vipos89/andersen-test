<?php
declare(strict_types=1);

namespace App\Models;

use App\Repositories\WalletRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property int satoshi_balance
 * @property int user_id
 */
class Wallet extends Model
{

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
            WalletRepository::START_SATOSHI_BALANCE;
    }
}
