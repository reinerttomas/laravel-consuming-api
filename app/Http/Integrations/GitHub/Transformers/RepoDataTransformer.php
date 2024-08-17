<?php

declare(strict_types=1);

namespace App\Http\Integrations\GitHub\Transformers;

use App\Contracts\Transformer;
use App\DataTransferObjects\GitHub\RepoData;
use Carbon\CarbonImmutable;

/**
 * @implements Transformer<\App\DataTransferObjects\GitHub\RepoData>
 */
final readonly class RepoDataTransformer implements Transformer
{
    public function toDto(array $data): RepoData
    {
        return new RepoData(
            id: $data['id'],
            owner: $data['owner']['login'],
            name: $data['name'],
            fullName: $data['full_name'],
            private: $data['private'],
            description: $data['description'] ?? '',
            createdAt: CarbonImmutable::parse($data['created_at'])
        );
    }

    /**
     * @throws \Exception
     */
    public function toArray(mixed $object): array
    {
        throw new \Exception('Not implemented');
    }
}
