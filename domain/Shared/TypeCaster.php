<?php

declare(strict_types = 1);

namespace Domain\Shared;

final readonly class TypeCaster
{
    public function asInteger(mixed $value, int $default): int
    {
        if (is_numeric(value: $value)) {
            return (int) $value;
        }

        return $default;
    }
}
