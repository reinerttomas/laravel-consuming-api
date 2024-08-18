<?php

declare(strict_types=1);

namespace App\Http\Integrations\GitHub\Transformers;

use App\DataTransferObjects\GitHub\RepoData;
use App\Transformer\BaseTransformer;
use Carbon\CarbonImmutable;

/**
 * @extends BaseTransformer<\App\DataTransferObjects\GitHub\RepoData>
 */
final class RepoDataTransformer extends BaseTransformer
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
