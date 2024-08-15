<?php

declare(strict_types=1);

namespace App\DataTransferObjects\GitHub;

use Carbon\CarbonInterface;

final readonly class RepoData
{
    public function __construct(
        public int $id,
        public string $owner,
        public string $name,
        public string $fullName,
        public bool $private,
        public string $description,
        public CarbonInterface $createdAt,
    ) {}
}
