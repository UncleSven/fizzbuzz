<?php

declare(strict_types = 1);

namespace Domain\FizzBuzz;

interface FizzBuzzStrategy
{
    /**
     * @param  int  $min
     * @param  int  $max
     *
     * @return string[]
     */
    public function evaluate(int $min, int $max): array;
}
