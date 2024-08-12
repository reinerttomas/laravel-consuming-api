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
        public string $private,
        public int $description,
        public CarbonInterface $createdAt,
    ) {}
}
