<?php

declare(strict_types=1);

namespace App\Http\Integrations\GitHub\Requests;

use App\DataTransferObjects\GitHub\CreateRepoData;
use App\DataTransferObjects\GitHub\RepoData;
use App\Http\Integrations\GitHub\Transformers\RepoDataTransformer;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

final class CreateRepo extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly CreateRepoData $createRepoData,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/user/repos';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return [
            'name' => $this->createRepoData->name,
            'description' => $this->createRepoData->description,
            'private' => $this->createRepoData->isPrivate,
        ];
    }

    /**
     * @throws \JsonException
     */
    public function createDtoFromResponse(Response $response): RepoData
    {
        return RepoDataTransformer::make()->toDto($response->json());
    }
}
