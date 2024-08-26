<?php

declare(strict_types=1);

namespace App\Http\Integrations\GitHub;

use App\Exceptions\Integrations\GitHub\GitHubException;
use App\Exceptions\Integrations\GitHub\NotFoundException;
use App\Exceptions\Integrations\GitHub\UnauthorizedException;
use GuzzleHttp\Psr7\Header;
use Illuminate\Support\Facades\Cache;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\HasPagination;
use Saloon\PaginationPlugin\PagedPaginator;
use Saloon\RateLimitPlugin\Contracts\RateLimitStore;
use Saloon\RateLimitPlugin\Limit;
use Saloon\RateLimitPlugin\Stores\LaravelCacheStore;
use Saloon\RateLimitPlugin\Traits\HasRateLimits;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;
use Saloon\Traits\Plugins\HasTimeout;
use Throwable;

final class GitHubConnector extends Connector implements HasPagination
{
    use AcceptsJson;
    use AlwaysThrowOnErrors;
    use HasRateLimits;
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

    public function getRequestException(Response $response, ?Throwable $senderException): ?Throwable
    {
        return match ($response->status()) {
            403 => new UnauthorizedException(
                message: $response->body(),
                code: $response->status(),
                previous: $senderException,
            ),
            404 => new NotFoundException(
                message: $response->body(),
                code: $response->status(),
                previous: $senderException,
            ),
            default => new GitHubException(
                message: $response->body(),
                code: $response->status(),
                previous: $senderException,
            ),
        };
    }

    /**
     * @return list<Limit>
     */
    protected function resolveLimits(): array
    {
        return [
            Limit::allow(requests: 10)->everySeconds(seconds: 1),
            Limit::allow(requests: 500)->everyHour(),
        ];
    }

    protected function resolveRateLimitStore(): RateLimitStore
    {
        return new LaravelCacheStore(Cache::store(\config('cache.default')));
    }
}
