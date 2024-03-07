<?php

declare(strict_types = 1);

use App\Http\Controllers\FizzBuzzController;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get(uri: '/', action: static function (): Factory|View {
    return view(view: 'welcome');
});

Route::get(uri: '/fizzbuzz', action: [FizzBuzzController::class, 'show']);
