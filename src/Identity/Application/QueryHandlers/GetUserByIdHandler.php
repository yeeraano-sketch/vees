<?php

declare(strict_types=1);

namespace App\Identity\Application\QueryHandlers;

use App\Identity\Application\Queries\GetUserByIdQuery;
use App\Identity\Domain\Repositories\UserRepository;
use App\Identity\Domain\ValueObjects\UserId;
use App\Identity\Application\DTOs\UserDto;

final readonly class GetUserByIdHandler
{
    public function __construct(
        private UserRepository $users,
    ) {
    }

    public function __invoke(GetUserByIdQuery $query): ?UserDto
    {
        $user = $this->users->findById(
            new UserId($query->id),
        );

        if ($user === null) {
            return null;
        }

        return UserDto::fromAggregate($user);
    }
}
