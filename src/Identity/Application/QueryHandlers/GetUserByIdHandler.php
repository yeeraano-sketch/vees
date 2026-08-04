<?php

declare(strict_types=1);

namespace Vees\Core\Identity\Application\QueryHandlers;

use Vees\Core\Identity\Application\Queries\GetUserByIdQuery;
use Vees\Core\Identity\Domain\Repositories\UserRepository;
use Vees\Core\Identity\Domain\ValueObjects\UserId;
use Vees\Core\Identity\Application\DTOs\UserDto;

final readonly class GetUserByIdHandler
{
    public function __construct(
        private UserRepository $users,
    ) {
    }

    public function handle(GetUserByIdQuery $query): ?UserDto
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
