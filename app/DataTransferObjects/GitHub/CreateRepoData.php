<?php

declare(strict_types=1);

namespace App\DataTransferObjects\GitHub;

final readonly class CreateRepoData
{
    public function __construct(
        public string $name,
        public string $description,
        public bool $isPrivate,
    ) {}
}
