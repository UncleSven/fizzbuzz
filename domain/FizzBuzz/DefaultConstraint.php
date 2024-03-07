<?php

declare(strict_types = 1);

namespace Domain\FizzBuzz;

final readonly class DefaultConstraint implements FizzBuzzConstraint
{
    /**
     * @var FizzBuzzConstraint[]
     */
    private array $constraints;

    public function __construct(
        private int $trigger,
        private string $result,
        FizzBuzzConstraint ...$constraints,
    )
    {
        $this->constraints = $constraints;
    }

    public function evaluate(int $number): ?string
    {
        if ($number % $this->trigger !== 0) {
            return null;
        }

        foreach ($this->constraints as $constraint) {
            $result = $constraint->evaluate(number: $number);
            if ($result !== null) {
                return $result;
            }
        }

        return $this->result;
    }
}
