<?php

declare(strict_types=1);

use App\Services\GitHub\GitHubServiceFake;

arch('to be services')
    ->expect('App\Services')
    ->toBeClass()
    ->toBeFinal()
    ->toBeReadonly()
    ->ignoring(GitHubServiceFake::class)
    ->toExtendNothing();
