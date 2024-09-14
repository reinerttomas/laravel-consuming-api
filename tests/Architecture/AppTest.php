<?php

declare(strict_types=1);

arch('php')
    ->preset()
    ->php();

arch('security')
    ->preset()
    ->security();

arch('laravel')
    ->preset()
    ->laravel()
    ->ignoring('App\Http\Integrations');

arch('strict')
    ->expect('App')
    ->toUseStrictTypes()
    ->and([
        'sleep',
        'usleep',
    ])->not->toBeUsed();
