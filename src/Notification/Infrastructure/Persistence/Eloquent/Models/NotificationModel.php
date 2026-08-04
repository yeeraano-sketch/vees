<?php

declare(strict_types=1);

namespace Vees\Core\Notification\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

final class NotificationModel extends Model
{
    use HasUuids;

    protected $table = 'notifications';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];
}
