<?php

declare(strict_types = 1);

namespace App\Console\Commands;

use Domain\FizzBuzz\FizzBuzzStrategy;
use Illuminate\Console\Command;

final class FizzBuzz extends Command
{
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the FizzBuzz coding challenge (from 1 to 100)';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fizz-buzz';

    /**
     * Execute the console command.
     */
    public function handle(FizzBuzzStrategy $fizzBuzzStrategy): void
    {
        $min = 1;
        $max = 100;

        $this->info(string: 'Output FizzBuzz');
        $this->info(string: "Minimum: {$min}");
        $this->info(string: "Maximum: {$max}");

        $results = $fizzBuzzStrategy->evaluate(min: $min, max: $max);
        foreach ($results as $result) {
            $this->line(string: $result);
        }
    }
}
