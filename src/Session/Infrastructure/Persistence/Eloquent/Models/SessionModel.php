<?php

declare(strict_types=1);

namespace Vees\Core\Session\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

final class SessionModel extends Model
{
    use HasUuids;

    protected $table = 'sessions';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];
}
