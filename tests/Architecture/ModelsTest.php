<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;

arch('to be models')
    ->expect('App\Models')
    ->toBeClass()
    ->toBeFinal()
    ->toExtend(Model::class);
