<?php

declare(strict_types=1);

namespace Vees\Core\Matching\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

final class MatchingModel extends Model
{
    use HasUuids;

    protected $table = 'matchings';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];
}
