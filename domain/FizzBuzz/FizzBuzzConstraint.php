<?php

declare(strict_types = 1);

namespace Domain\FizzBuzz;

interface FizzBuzzConstraint
{
    public function evaluate(int $number): ?string;
}
