<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use Domain\FizzBuzz\FizzBuzzStrategy;
use Domain\Shared\TypeCaster;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

final class FizzBuzzController extends Controller
{
    public function __construct(
        private readonly FizzBuzzStrategy $fizzBuzzStrategy,
        private readonly TypeCaster       $typeCaster,
    ) {}

    public function show(Request $request): Factory|View
    {
        $validator = Validator::make(data: $request->all(), rules: [
            'minimum' => 'bail|integer|min:1|max:100',
            'maximum' => 'bail|required_with:minimum|integer|min:1|max:100|gte:minimum',
        ]);

        $errors = null;
        if ($validator->stopOnFirstFailure()->fails()) {
            $errors = $validator->errors()->all();
        }

        $min = $this->typeCaster->asInteger(value: $request->input(key: 'minimum'), default: 1);
        $max = $this->typeCaster->asInteger(value: $request->input(key: 'maximum'), default: 100);

        $results = null;
        if ($errors === null) {
            $results = $this->fizzBuzzStrategy->evaluate(min: $min, max: $max);
        }

        return view(view: 'fizzbuzz', data: [
            'errors'  => $errors,
            'min'     => $min,
            'max'     => $max,
            'results' => $results,
        ]);
    }
}
