<?php

declare(strict_types=1);

namespace Vees\Core\Identity\Infrastructure\Persistence;

use Illuminate\Database\Eloquent\Model;

final class UserModel extends Model
{
    protected $table = 'users';

    protected $guarded = [];

    public $timestamps = true;
}
