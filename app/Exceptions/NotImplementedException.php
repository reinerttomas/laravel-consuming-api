<?php

declare(strict_types=1);

namespace App\Exceptions;

final class NotImplementedException extends Exception
{
    public function __construct()
    {
        parent::__construct(message: 'Not implemented', code: 500);
    }
}
