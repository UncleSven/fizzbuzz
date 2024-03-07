<?php

declare(strict_types = 1);

namespace Tests\Unit\domain\Shared;

use DateTime;
use Domain\Shared\TypeCaster;
use Tests\UnitTestCase;

final class TypeCasterTest extends UnitTestCase
{
    private TypeCaster $typeCaster;

    /**
     * @return iterable<array<int, mixed>>
     */
    public static function provideAsIntegerData(): iterable
    {
        yield 'string mzu8' => ['mzu8', 0];
        yield 'string dde87de' => ['dde87de', 0];
        yield 'string 879dde87de' => ['879dde87de', 0];
        yield 'string 8745' => ['8745', 8745];
        yield 'string -54478' => ['-54478', -54478];
        yield 'string -10' => ['-10', -10];
        yield 'string -387.43' => ['-387.43', -387];
        yield 'string 7.43' => ['7.43', 7];
        yield 'string 0.43' => ['0.43', 0];
        yield 'string 0.63' => ['0.63', 0];
        yield 'array string' => [['478'], 0];
        yield 'array integer' => [[478], 0];
        yield 'object' => [new DateTime(), 0];
        yield 'bool false' => [false, 0];
        yield 'bool true' => [true, 0];
        yield 'integer 47' => [47, 47];
        yield 'float -147.87' => [-147.87, -147];
        yield 'float -7.87' => [7.87, 7];
    }

    /**
     * @dataProvider provideAsIntegerData
     */
    public function testAsInteger(mixed $value, int $expected): void
    {
        $this::assertSame(expected: $expected, actual: $this->typeCaster->asInteger(value: $value, default: 0));
    }

    protected function setUp(): void
    {
        $this->typeCaster = new TypeCaster();

        parent::setUp();
    }
}
