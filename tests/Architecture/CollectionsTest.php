<?php

declare(strict_types=1);

use Illuminate\Support\Collection;

arch('to be collections')
    ->expect('App\Collections')
    ->toBeClass()
    ->toBeFinal()
    ->toExtend(Collection::class)
    ->toHaveSuffix('Collection');
