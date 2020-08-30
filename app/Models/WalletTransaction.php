<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $from
 * @property string $to
 * @property int $amount
 * @property int commission
 */
class WalletTransaction extends Model
{
    protected $fillable = ['from', 'to', 'amount', 'commission'];

}
