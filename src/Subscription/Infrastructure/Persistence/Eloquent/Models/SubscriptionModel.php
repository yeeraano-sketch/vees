<?php

declare(strict_types=1);

namespace Vees\Core\Subscription\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

final class SubscriptionModel extends Model
{
    use HasUuids;

    protected $table = 'subscriptions';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];
}
