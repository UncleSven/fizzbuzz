<?php

declare(strict_types = 1);

namespace Tests\Unit\domain\FizzBuzz;

use Domain\FizzBuzz\DefaultStrategy;
use Domain\FizzBuzz\FizzBuzzConstraint;
use Domain\FizzBuzz\FizzBuzzStrategy;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\UnitTestCase;

final class DefaultStrategyTest extends UnitTestCase
{
    private FizzBuzzConstraint&MockObject $constraint1;

    private FizzBuzzConstraint&MockObject $constraint2;

    private FizzBuzzStrategy $strategy;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->constraint1 = $this::createMock(FizzBuzzConstraint::class);
        $this->constraint2 = $this::createMock(FizzBuzzConstraint::class);
        $this->strategy = new DefaultStrategy($this->constraint1, $this->constraint2);

        parent::setUp();
    }

    public function testSingleLoopWithFirstConstraintMatch(): void
    {
        $this->constraint1
            ->expects($this::once())
            ->method('evaluate')
            ->with(7)
            ->willReturn('foo');

        $this->constraint2
            ->expects($this::never())
            ->method('evaluate');

        $this::assertSame(expected: ['foo'], actual: $this->strategy->evaluate(min: 7, max: 7));
    }

    public function testSingleLoopWithSecondConstraintMatch(): void
    {
        $this->constraint1
            ->expects($this::once())
            ->method('evaluate')
            ->with(7)
            ->willReturn(null);

        $this->constraint2
            ->expects($this::once())
            ->method('evaluate')
            ->with(7)
            ->willReturn('foo');

        $this::assertSame(expected: ['foo'], actual: $this->strategy->evaluate(min: 7, max: 7));
    }

    public function testNoLoop(): void
    {
        $this->constraint1
            ->expects($this::never())
            ->method('evaluate');

        $this->constraint2
            ->expects($this::never())
            ->method('evaluate');

        $this::assertSame(expected: [], actual: $this->strategy->evaluate(min: -1, max: -2));
    }

    public function testLoopWithNoMatchingConstraints(): void
    {
        $this->constraint1
            ->expects($this::exactly(3))
            ->method('evaluate')
            ->with(
                $this::callback(
                    static function (int $number): bool {
                        static $i = 0;
                        $i++;

                        return $number === $i;
                    }
                ))
            ->willReturn(null);

        $this->constraint2
            ->expects($this::exactly(3))
            ->method('evaluate')
            ->with(
                $this::callback(
                    static function (int $number): bool {
                        static $i = 0;
                        $i++;

                        return $number === $i;
                    }
                ))
            ->willReturn(null);

        $this::assertSame(expected: ['1', '2', '3'], actual: $this->strategy->evaluate(min: 1, max: 3));
    }

    public function testLoopWithTwoMatchingConstraints(): void
    {
        $this->constraint1
            ->expects($this::exactly(4))
            ->method('evaluate')
            ->willReturn(null, null, 'foo', 'foo');

        $this->constraint2
            ->expects($this::exactly(2))
            ->method('evaluate')
            ->willReturn('bar', null);

        $this::assertSame(expected: ['bar', '2', 'foo', 'foo'], actual: $this->strategy->evaluate(min: 1, max: 4));
    }
}
