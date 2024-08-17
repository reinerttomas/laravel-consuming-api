<?php

declare(strict_types=1);

namespace App\Http\Integrations\GitHub\Requests;

use App\DataTransferObjects\GitHub\RepoData;
use App\Http\Integrations\GitHub\Transformers\RepoDataTransformer;
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
        return (new RepoDataTransformer)->toDto($response->json());
    }
}
