<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;

arch('extends base model')
    ->expect('App\Models')
    ->toExtend(Model::class);
