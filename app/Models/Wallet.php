<?php
declare(strict_types=1);

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Wallet extends Model
{

    protected $guarded = [];
    /**
     * @var int
     */
    private $user_id;

    /**
     * @Todo remove to trait
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string)Str::uuid();
        });
    }


    public function getBtcBalanceAttribute()
    {
        return $this->attributes['satoshi_balance'] / 100000000;
    }

}
