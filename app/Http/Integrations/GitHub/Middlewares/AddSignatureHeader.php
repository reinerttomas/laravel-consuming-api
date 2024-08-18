<?php

declare(strict_types=1);

namespace App\Http\Integrations\GitHub\Middlewares;

use Illuminate\Support\Str;
use Saloon\Contracts\RequestMiddleware;
use Saloon\Http\PendingRequest;

final readonly class AddSignatureHeader implements RequestMiddleware
{
    public function __invoke(PendingRequest $pendingRequest): void
    {
        $pendingRequest->headers()->add(
            key: 'X-Signature',
            value: Str::ulid()->toBase32(),
        );
    }
}
