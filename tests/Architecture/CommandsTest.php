<?php

declare(strict_types=1);

use Illuminate\Console\Command;

arch('to be commands')
    ->expect('App\Console\Contracts')
    ->toBeClass()
    ->toBeFinal()
    ->toExtend(Command::class)
    ->toHaveSuffix('Command');
