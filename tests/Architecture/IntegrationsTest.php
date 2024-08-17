<?php

declare(strict_types=1);

use App\Contracts\Transformer;

arch('to be requests')
    ->expect('App\Http\Integrations\**\Requests')
    ->toBeClass()
    ->toBeFinal()
    ->toExtend(\Saloon\Http\Request::class);

arch('to be transformers')
    ->expect('App\Http\Integrations\**\Transformers')
    ->toBeClass()
    ->toBeFinal()
    ->toBeReadonly()
    ->toImplement(Transformer::class)
    ->toHaveSuffix('Transformer');
