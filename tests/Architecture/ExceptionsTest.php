<?php

declare(strict_types=1);

arch('to be exceptions')
    ->expect('App\Exceptions')
    ->toBeClass()
    ->toHaveSuffix('Exception');
