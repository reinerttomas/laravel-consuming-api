<?php

declare(strict_types=1);

namespace App\Http\Integrations\GitHub\Requests;

use App\DataTransferObjects\GitHub\RepoData;
use App\DataTransferObjects\GitHub\UpdateRepoData;
use App\Http\Integrations\GitHub\Transformers\RepoDataTransformer;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

final class UpdateRepo extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function __construct(
        private readonly string $owner,
        private readonly string $repoName,
        private readonly UpdateRepoData $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/repos/' . $this->owner . '/' . $this->repoName;
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return [
            'name' => $this->data->name,
            'description' => $this->data->description,
            'private' => $this->data->isPrivate,
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
