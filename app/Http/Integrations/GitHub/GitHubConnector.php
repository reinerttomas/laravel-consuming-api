<?php

declare(strict_types=1);

namespace App\Http\Integrations\GitHub;

use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;

final class GitHubConnector extends Connector
{
    use AcceptsJson;

    private const string BASE_URL = 'https://api.github.com/';

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
}
