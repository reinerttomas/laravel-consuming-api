<?php

declare(strict_types=1);

namespace App\Http\Integrations\GitHub\Requests;

use App\DataTransferObjects\GitHub\RepoData;
use Carbon\CarbonImmutable;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

final class GetRepo extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly string $owner,
        private readonly string $repo,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/repos/' . $this->owner . '/' . $this->repo;
    }

    /**
     * @throws \JsonException
     */
    public function createDtoFromResponse(Response $response): RepoData
    {
        $data = $response->json();

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
}
