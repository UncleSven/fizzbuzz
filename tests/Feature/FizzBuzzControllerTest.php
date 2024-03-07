<?php

namespace Tests\Feature;

use Illuminate\Testing\TestResponse;
use Tests\FeatureTestCase;

final class FizzBuzzControllerTest extends FeatureTestCase
{
    public function testShowWithoutParameter(): void
    {
        $response = $this->get(uri: '/fizzbuzz');
        $response->assertStatus(status: 200);

        $data = $this->getData(response: $response);

        $this::assertNull(actual: $data['errors']);
        $this::assertSame(expected: 1, actual: $data['min']);
        $this::assertSame(expected: 100, actual: $data['max']);
    }

    public function testShowWithParameter(): void
    {
        $response = $this->get(uri: '/fizzbuzz?minimum=68&maximum=75');
        $response->assertStatus(status: 200);

        $data = $this->getData(response: $response);

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

        $this::assertNull(actual: $data['errors']);
        $this::assertSame(expected: 68, actual: $data['min']);
        $this::assertSame(expected: 75, actual: $data['max']);
        $this::assertSame(expected: $expected, actual: $data['results']);
    }

    /**
     * @dataProvider provideMinimumErrors
     */
    public function testMinimumErrors(int|string $minimum, string $error): void
    {
        $response = $this->get(uri: "/fizzbuzz?minimum={$minimum}&maximum=1");
        $response->assertStatus(status: 200);

        $errors = $this->getData(response: $response)['errors'];

        $this::assertNotNull(actual: $errors);
        $this::assertSame(expected: [$error], actual: $errors);
    }

    /**
     * @return iterable<array<int, int|string>>
     */
    public static function provideMinimumErrors(): iterable
    {
        yield 'minimum is a string' => ['min', 'The minimum field must be an integer.'];
        yield 'minimum is an empty string' => ['', 'The minimum field must be an integer.'];
        yield 'minimum is less than 1' => [0, 'The minimum field must be at least 1.'];
        yield 'minimum is greater than 100' => [101, 'The minimum field must not be greater than 100.'];
    }

    /**
     * @dataProvider provideMaximumErrors
     */
    public function testMaximumErrors(int|string $maximum, string $error): void
    {
        $response = $this->get(uri: "/fizzbuzz?minimum=40&maximum={$maximum}");
        $response->assertStatus(status: 200);

        $errors = $this->getData(response: $response)['errors'];

        $this::assertNotNull(actual: $errors);
        $this::assertSame(expected: [$error], actual: $errors);
    }

    /**
     * @return iterable<array<int, int|string>>
     */
    public static function provideMaximumErrors(): iterable
    {
        yield 'maximum is a string' => ['min', 'The maximum field must be an integer.'];
        yield 'maximum is an empty string' => ['', 'The maximum field is required when minimum is present.'];
        yield 'maximum is less than 1' => [0, 'The maximum field must be at least 1.'];
        yield 'maximum is greater than 100' => [101, 'The maximum field must not be greater than 100.'];
        yield 'maximum must be greater than minimum' => [39, 'The maximum field must be greater than or equal to 40.'];
    }

    public function testErrorWhenNoMaximumIsPresent(): void
    {
        $response = $this->get(uri: '/fizzbuzz?minimum=40');
        $response->assertStatus(status: 200);

        $errors = $this->getData(response: $response)['errors'];

        $this::assertNotNull(actual: $errors);
        $this::assertSame(expected: ['The maximum field is required when minimum is present.'], actual: $errors);
    }

    /**
     * @return array<string, int|array<int|string, string>>
     */
    private function getData(TestResponse $response): array
    {
        /** @phpstan-ignore-next-line */
        return $response->getOriginalContent()->getData();
    }
}
