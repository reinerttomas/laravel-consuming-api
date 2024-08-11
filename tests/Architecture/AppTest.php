<?php

declare(strict_types=1);

arch('use string type check')
    ->expect('App')
    ->toUseStrictTypes();

arch('do not leave debug statements')
    ->expect(['dd', 'ddd', 'die', 'dump', 'ray', 'sleep', 'var_dump'])
    ->toBeUsedInNothing();
