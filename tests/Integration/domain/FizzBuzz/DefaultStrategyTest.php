<?php

declare(strict_types = 1);

namespace Tests\Integration\domain\FizzBuzz;

use Domain\FizzBuzz\FizzBuzzStrategy;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Tests\IntegrationTestCase;

final class DefaultStrategyTest extends IntegrationTestCase
{
    private FizzBuzzStrategy $strategy;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function setUp(): void
    {
        $app = $this->createApplication();

        /** @phpstan-ignore-next-line */
        $this->strategy = $app->get(FizzBuzzStrategy::class);

        parent::setUp();
    }

    /**
     * @param  array<int, int|string>  $expected
     *
     * @dataProvider provideEvaluateSingleLoopData
     */
    public function testEvaluateSingleLoop(int $minMax, array $expected): void
    {
        $this::assertSame(expected: $expected, actual: $this->strategy->evaluate(min: $minMax, max: $minMax));
    }

    /**
     * @return iterable<array<int, int|array<int, string>>>
     */
    public static function provideEvaluateSingleLoopData(): iterable
    {
        yield 'number 0 expect FizzBuz' => [0, ['FizzBuzz']];
        yield 'number 1 expect 1' => [1, ['1']];
        yield 'number -1 expect -1' => [-1, ['-1']];
        yield 'number 3 expect Fizz' => [3, ['Fizz']];
        yield 'number -3 expect Fizz' => [-3, ['Fizz']];
        yield 'number 5 expect Buzz' => [5, ['Buzz']];
        yield 'number -5 expect Buzz' => [-5, ['Buzz']];
        yield 'number 15 expect FizzBuzz' => [15, ['FizzBuzz']];
        yield 'number -15 expect FizzBuzz' => [-15, ['FizzBuzz']];
    }

    public function testEvaluateLoop(): void
    {
        $expected = [
            '68',
            'Fizz',
            'Buzz',
            '71',
            'Fizz',
            '73',
            '74',
            'FizzBuzz',
        ];

        $this::assertSame(expected: $expected, actual: $this->strategy->evaluate(min: 68, max: 75));
    }
}
