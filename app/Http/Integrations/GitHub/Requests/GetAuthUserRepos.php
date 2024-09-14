<?php

declare(strict_types=1);

namespace App\Http\Integrations\GitHub\Requests;

use App\DataTransferObjects\GitHub\RepoData;
use App\Http\Integrations\GitHub\Transformers\RepoDataTransformer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Saloon\CachePlugin\Contracts\Cacheable;
use Saloon\CachePlugin\Contracts\Driver;
use Saloon\CachePlugin\Drivers\LaravelCacheDriver;
use Saloon\CachePlugin\Traits\HasCaching;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;

final class GetAuthUserRepos extends Request implements Cacheable, Paginatable
{
    use HasCaching;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/user/repos';
    }

    /**
     * @return \Illuminate\Support\Collection<int, \App\DataTransferObjects\GitHub\RepoData>
     */
    public function createDtoFromResponse(Response $response): Collection
    {
        return $response->collect()
            ->map(fn (array $data): RepoData => RepoDataTransformer::make()->toDto($data));
    }

    public function resolveCacheDriver(): Driver
    {
        return new LaravelCacheDriver(Cache::store(config('cache.default')));
    }

    public function cacheExpiryInSeconds(): int
    {
        return 60; // 1 minute
    }
}
