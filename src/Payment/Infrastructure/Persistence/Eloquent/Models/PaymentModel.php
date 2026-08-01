<?php

declare(strict_types=1);

namespace App\Payment\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

final class PaymentModel extends Model
{
    use HasUuids;

    protected $table = 'payments';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'amount' => 'array',
        ];
    }
}
