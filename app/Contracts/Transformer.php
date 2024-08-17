<?php

declare(strict_types=1);

namespace App\Contracts;

/**
 * @template T
 */
interface Transformer
{
    /**
     * @param  array<string, mixed>  $data
     * @return T
     */
    public function toDto(array $data): mixed;

    /**
     * @param  T  $object
     * @return array<string, mixed>
     */
    public function toArray(mixed $object): array;
}
