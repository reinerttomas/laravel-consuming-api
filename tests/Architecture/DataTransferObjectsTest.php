<?php

declare(strict_types=1);

arch('to be data transfer objects')
    ->expect('App\DataTransferObjects')
    ->toBeClass()
    ->toBeFinal()
    ->toBeReadonly()
    ->toHaveSuffix('Data');
