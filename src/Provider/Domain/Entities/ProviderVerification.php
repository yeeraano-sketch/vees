<?php

declare(strict_types=1);

namespace App\Provider\Domain\Entities;

use App\SharedKernel\Domain\Entity;

final class ProviderVerification extends Entity
{
    public function __construct(
        private bool $verified = false,
    ) {
    }

    protected function identity(): mixed
    {
        return 'verification';
    }

    public function isVerified(): bool
    {
        return $this->verified;
    }

    public function verify(): void
    {
        $this->verified = true;
    }

    public function revoke(): void
    {
        $this->verified = false;
    }
}
