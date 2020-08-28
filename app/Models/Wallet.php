<?php
declare(strict_types=1);

namespace App\Models;

use App\Repositories\WalletRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property mixed satoshi_balance
 * @property int user_id
 */
class Wallet extends Model
{

    protected $guarded = [];
    /**
     * @var int
     */
    private $user_id;

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


    public function getBtcBalanceAttribute()
    {
        return $this->attributes['satoshi_balance'] / WalletRepository::START_SATOSHI_BALANCE;
    }
}
