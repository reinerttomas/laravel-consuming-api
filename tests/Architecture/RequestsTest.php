<?php

declare(strict_types=1);

arch('to be requests')
    ->expect('App\Http\Requests')
    ->toBeClass()
    ->toBeFinal()
    ->toExtend(Illuminate\Foundation\Http\FormRequest::class)
    ->toHaveSuffix('Request');
