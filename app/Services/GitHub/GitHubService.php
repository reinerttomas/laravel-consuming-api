<?php

declare(strict_types=1);

namespace App\Services\GitHub;

use App\Collections\GitHub\RepoCollection;
use App\Contracts\GitHub;
use App\DataTransferObjects\GitHub\CreateRepoData;
use App\DataTransferObjects\GitHub\RepoData;
use App\DataTransferObjects\GitHub\UpdateRepoData;
use App\Http\Integrations\GitHub\GitHubConnector;
use App\Http\Integrations\GitHub\Requests\CreateRepo;
use App\Http\Integrations\GitHub\Requests\GetRepo;
use App\Http\Integrations\GitHub\Requests\GetRepoLanguages;
use App\Http\Integrations\GitHub\Requests\UpdateRepo;

final readonly class GitHubService implements GitHub
{
    public function __construct(
        private string $token,
    ) {}

    public function getRepos(string $username): RepoCollection
    {
        throw new \Exception('Not implemented');
    }

    /**
     * @throws \Saloon\Exceptions\Request\FatalRequestException
     * @throws \Saloon\Exceptions\Request\RequestException
     */
    public function getRepo(string $owner, string $repoName): RepoData
    {
        return $this->connector()
            ->send(new GetRepo($owner, $repoName))
            ->dtoOrFail();
    }

    /**
     * @throws \Saloon\Exceptions\Request\FatalRequestException
     * @throws \Saloon\Exceptions\Request\RequestException
     */
    public function getRepoLanguages(string $owner, string $repoName): array
    {
        return $this->connector()
            ->send(new GetRepoLanguages($owner, $repoName))
            ->collect()
            ->keys()
            ->all();
    }

    /**
     * @throws \Saloon\Exceptions\Request\FatalRequestException
     * @throws \Saloon\Exceptions\Request\RequestException
     */
    public function createRepo(CreateRepoData $data): RepoData
    {
        return $this->connector()
            ->send(new CreateRepo($data))
            ->dtoOrFail();
    }

    /**
     * @throws \Saloon\Exceptions\Request\FatalRequestException
     * @throws \Saloon\Exceptions\Request\RequestException
     */
    public function updateRepo(string $owner, string $repoName, UpdateRepoData $data): RepoData
    {
        return $this->connector()
            ->send(
                new UpdateRepo(owner: $owner, repoName: $repoName, data: $data)
            )
            ->dtoOrFail();
    }

    public function deleteRepo(string $owner, string $repoName): void
    {
        throw new \Exception('Not implemented');
    }

    private function connector(): GitHubConnector
    {
        return new GitHubConnector($this->token);
    }
}
