<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Domain;

final readonly class Error extends ValueObject
{
    private function __construct(
        public ErrorType $type,
        public string $code,
        public string $message,
        public array $metadata = [],
    ) {
    }

    public static function business(
        string $code,
        string $message,
        array $metadata = [],
    ): self {
        return new self(
            ErrorType::Business,
            $code,
            $message,
            $metadata,
        );
    }

    public static function system(
        string $code,
        string $message,
        array $metadata = [],
    ): self {
        return new self(
            ErrorType::System,
            $code,
            $message,
            $metadata,
        );
    }

    public function equals(self $other): bool
    {
        return $this->type === $other->type
            && $this->code === $other->code
            && $this->message === $other->message
            && $this->metadata == $other->metadata;
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type->value,
            'code' => $this->code,
            'message' => $this->message,
            'metadata' => $this->metadata,
        ];
    }
}