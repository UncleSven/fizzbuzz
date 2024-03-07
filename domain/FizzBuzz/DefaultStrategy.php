<?php

declare(strict_types = 1);

namespace Domain\FizzBuzz;

final readonly class DefaultStrategy implements FizzBuzzStrategy
{
    /**
     * @var FizzBuzzConstraint[]
     */
    private array $constraints;

    public function __construct(FizzBuzzConstraint ...$constraints)
    {
        $this->constraints = $constraints;
    }

    public function evaluate(int $min, int $max): array
    {
        $results = [];

        for ($i = $min; $i <= $max; $i++) {
            $result = null;

            foreach ($this->constraints as $constraint) {
                $result = $constraint->evaluate(number: $i);
                if ($result !== null) {
                    $results[] = $result;
                    break;
                }
            }

            if ($result === null) {
                $results[] = (string) $i;
            }
        }

        return $results;
    }
}
