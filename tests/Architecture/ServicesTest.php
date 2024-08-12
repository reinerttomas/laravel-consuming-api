<?php

declare(strict_types=1);

arch('to be services')
    ->expect('App\Services')
    ->toBeClass()
    ->toBeFinal()
    ->toBeReadonly()
    ->toExtendNothing();
