<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Contracts\Transformer;

/**
 * @template T
 *
 * @implements Transformer<T>
 */
abstract class BaseTransformer implements Transformer
{
    public static function make(): static
    {
        return \app(static::class);
    }
}
