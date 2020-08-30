<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $transaction_id
 * @property int $commission
 */
class Commission extends Model
{
    protected $guarded = [];
}
