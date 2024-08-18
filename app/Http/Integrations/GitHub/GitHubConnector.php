<?php

declare(strict_types=1);

namespace App\Http\Integrations\GitHub;

use GuzzleHttp\Psr7\Header;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\HasPagination;
use Saloon\PaginationPlugin\PagedPaginator;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;
use Saloon\Traits\Plugins\HasTimeout;

final class GitHubConnector extends Connector implements HasPagination
{
    use AcceptsJson;
    use AlwaysThrowOnErrors;
    use HasTimeout;

    private const string BASE_URL = 'https://api.github.com/';

    protected int $connectTimeout = 10;

    protected int $requestTimeout = 30;

    public function __construct(public readonly string $token) {}

    public function resolveBaseUrl(): string
    {
        return self::BASE_URL;
    }

    /**
     * @return array<string, string>
     */
    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/vnd.github+json',
        ];
    }

    public function defaultAuth(): TokenAuthenticator
    {
        return new TokenAuthenticator($this->token);
    }

    public function paginate(Request $request): PagedPaginator
    {
        return new class(connector: $this, request: $request) extends PagedPaginator
        {
            protected ?int $perPageLimit = 100;

            protected function isLastPage(Response $response): bool
            {
                $linkHeader = Header::parse($response->header('Link') ?? []);

                return \collect($linkHeader)
                    ->where(fn (array $link): bool => $link['rel'] === 'next')
                    ->isEmpty();
            }

            protected function getPageItems(Response $response, Request $request): array
            {
                return $response->dtoOrFail()->toArray();
            }
        };
    }
}
