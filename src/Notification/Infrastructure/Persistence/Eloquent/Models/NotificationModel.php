<?php

declare(strict_types=1);

namespace App\Notification\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

final class NotificationModel extends Model
{
    use HasUuids;

    protected $table = 'notifications';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];
}
