<?php

declare(strict_types=1);

arch('to be requests')
    ->expect('App\Http\Integrations\**\Requests')
    ->toBeClass()
    ->toBeFinal()
    ->toExtend(\Saloon\Http\Request::class);
