<?php

declare(strict_types=1);

namespace App\Services\GitHub;

use App\Collections\GitHub\RepoCollection;
use App\Contracts\GitHub;
use App\DataTransferObjects\GitHub\CreateRepoData;
use App\DataTransferObjects\GitHub\RepoData;
use App\DataTransferObjects\GitHub\UpdateRepoData;
use App\Http\Integrations\GitHub\GitHubConnector;
use App\Http\Integrations\GitHub\Requests\GetRepo;

final readonly class GitHubService implements GitHub
{
    public function __construct(
        private string $token,
    ) {}

    public function getRepos(string $username): RepoCollection
    {
        // TODO: Implement getRepos() method.
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

    public function getRepoLanguages(): array
    {
        // TODO: Implement getRepoLanguages() method.
    }

    public function createRepo(CreateRepoData $data): RepoData
    {
        // TODO: Implement createRepo() method.
    }

    public function updateRepo(string $owner, string $repoName, UpdateRepoData $data): RepoData
    {
        // TODO: Implement updateRepo() method.
    }

    public function deleteRepo(string $owner, string $repoName): void
    {
        // TODO: Implement deleteRepo() method.
    }

    private function connector(): GitHubConnector
    {
        return new GitHubConnector($this->token);
    }
}
