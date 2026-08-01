<?php

declare(strict_types=1);

namespace App\Provider\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

final class ProviderModel extends Model
{
    use HasUuids;

    protected $table = 'providers';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'verified' => 'boolean',
            'settings' => 'array',
        ];
    }
}
