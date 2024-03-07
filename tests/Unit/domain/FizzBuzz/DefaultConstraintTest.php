<?php

declare(strict_types = 1);

namespace Tests\Unit\domain\FizzBuzz;

use DivisionByZeroError;
use Domain\FizzBuzz\DefaultConstraint;
use Domain\FizzBuzz\FizzBuzzConstraint;
use PHPUnit\Framework\MockObject\Exception;
use Tests\UnitTestCase;

final class DefaultConstraintTest extends UnitTestCase
{
    /**
     * @dataProvider provideModuloIsNotZero
     * @throws Exception
     */
    public function testModuloIsNotZero(int $number): void
    {
        $subConstraintMock = $this::createMock(FizzBuzzConstraint::class);
        $subConstraintMock
            ->expects($this::never())
            ->method('evaluate');

        $constraint = new DefaultConstraint(7, 'wow', $subConstraintMock);

        $this::assertNull(actual: $constraint->evaluate(number: $number));
    }

    /**
     * @return iterable<array<int, int>>
     */
    public static function provideModuloIsNotZero(): iterable
    {
        yield 'Test 1 with negative number' => [-6];
        yield 'Test 2 with negative number' => [-111];
        yield 'Test 1 with positive number ' => [1];
        yield 'Test 2 with positive number ' => [111];
    }

    /**
     * @dataProvider provideCorrectResult
     */
    public function testCorrectResult(int $number): void
    {
        $constraint = new DefaultConstraint(trigger: 7, result: 'wow');

        $this::assertSame(expected: 'wow', actual: $constraint->evaluate(number: $number));
    }

    /**
     * @return iterable<array<int, int>>
     */
    public static function provideCorrectResult(): iterable
    {
        yield 'Test with zero' => [0];
        yield 'Test 1 with negative number' => [-7];
        yield 'Test 2 with negative number' => [-14];
        yield 'Test 1 with positive number ' => [7];
        yield 'Test 2 with positive number ' => [21];
        yield 'Test 3 with positive number ' => [77];
    }

    /**
     * @dataProvider provideCorrectResultDueToSubConstraint
     */
    public function testCorrectResultDueToSubConstraintWithPositiveTrigger(int $number, ?string $expected): void
    {
        $subConstraint1 = new DefaultConstraint(6, 'foo');
        $subConstraint2 = new DefaultConstraint(8, 'bar');
        $subConstraint3 = new DefaultConstraint(2, 'hooray', $subConstraint1);
        $constraint = new DefaultConstraint(10, 'wow', $subConstraint2, $subConstraint3);

        $this::assertSame(expected: $expected, actual: $constraint->evaluate(number: $number));
    }

    /**
     * @dataProvider provideCorrectResultDueToSubConstraint
     */
    public function testCorrectResultDueToSubConstraintWithNegativeTrigger(int $number, ?string $expected): void
    {
        $subConstraint1 = new DefaultConstraint(-6, 'foo');
        $subConstraint2 = new DefaultConstraint(-8, 'bar');
        $subConstraint3 = new DefaultConstraint(-2, 'hooray', $subConstraint1);
        $constraint = new DefaultConstraint(-10, 'wow', $subConstraint2, $subConstraint3);

        $this::assertSame(expected: $expected, actual: $constraint->evaluate(number: $number));
    }

    /**
     * @return iterable<array<int, int|string|null>>
     */
    public static function provideCorrectResultDueToSubConstraint(): iterable
    {
        yield 'Test with zero' => [0, 'bar'];
        yield 'Test 10 and 8 with positive number' => [80, 'bar'];
        yield 'Test 10 and 8 with negative number' => [-80, 'bar'];
        yield 'Test 10 and 2 with negative number' => [-20, 'hooray'];
        yield 'Test 10 and 2 with positive number' => [20, 'hooray'];
        yield 'Test 10 and 2 and 6 with negative number' => [-60, 'foo'];
        yield 'Test 10 and 2 and 6 with positive number' => [60, 'foo'];
        yield 'Test null with negative number' => [-24, null];
        yield 'Test null with positive number' => [-24, null];
    }

    public function testDivisionByZeroError(): void
    {
        $constraint = new DefaultConstraint(0, 'wow');
        $this::expectException(DivisionByZeroError::class);
        $constraint->evaluate(number: 7);
    }

    /**
     * @throws Exception
     */
    public function testSubConstraintIsCalledCorrectly(): void
    {
        $subConstraintMock = $this::createMock(FizzBuzzConstraint::class);
        $subConstraintMock
            ->expects($this::once())
            ->method('evaluate')
            ->with(70)
            ->willReturn('hossa');

        $constraint = new DefaultConstraint(7, 'wow', $subConstraintMock);

        $this::assertSame(expected: 'hossa', actual: $constraint->evaluate(number: 70));

        $subConstraintMock = $this::createMock(FizzBuzzConstraint::class);
        $subConstraintMock
            ->expects($this::once())
            ->method('evaluate')
            ->with(70)
            ->willReturn(null);

        $constraint = new DefaultConstraint(7, 'wow', $subConstraintMock);

        $this::assertSame(expected: 'wow', actual: $constraint->evaluate(number: 70));
    }
}
