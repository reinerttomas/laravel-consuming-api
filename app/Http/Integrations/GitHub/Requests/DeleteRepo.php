<?php

declare(strict_types=1);

namespace App\Http\Integrations\GitHub\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

final class DeleteRepo extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        private readonly string $owner,
        private readonly string $repoName,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/repos/' . $this->owner . '/' . $this->repoName;
    }
}
