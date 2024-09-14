<?php

declare(strict_types=1);

use function Pest\Laravel\get;

it('returns a successful response', function () {
    get('/')->assertOk();
});
