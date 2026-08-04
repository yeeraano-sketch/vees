<?php

declare(strict_types=1);

namespace Vees\Core\Provider\Domain\Entities;

use Vees\Core\Provider\Domain\Enums\VerificationStatus;
use Vees\Core\SharedKernel\Domain\Entity;

final class ProviderVerification extends Entity
{
    public function __construct(
        private VerificationStatus $status = VerificationStatus::Pending,
    ) {}

    protected function identity(): mixed
    {
        return 'verification';
    }

    public function status(): VerificationStatus
    {
        return $this->status;
    }

    public function verify(): void
    {
        $this->status = VerificationStatus::Verified;
    }

    public function reject(): void
    {
        $this->status = VerificationStatus::Rejected;
    }

    public function reset(): void
    {
        $this->status = VerificationStatus::Pending;
    }

    public function isVerified(): bool
    {
        return $this->status === VerificationStatus::Verified;
    }
}
