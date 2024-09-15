<?php

declare(strict_types=1);

namespace App\Services\GitHub;

use App\Collections\GitHub\RepoCollection;
use App\Contracts\GitHub;
use App\DataTransferObjects\GitHub\CreateRepoData;
use App\DataTransferObjects\GitHub\RepoData;
use App\DataTransferObjects\GitHub\UpdateRepoData;
use App\Exceptions\Integrations\GitHub\GitHubException;
use App\Exceptions\NotImplementedException;
use Illuminate\Support\Collection;

final class GitHubServiceFake implements GitHub
{
    /**
     * @param  Collection<int, CreateRepoData>  $reposToCreate
     */
    public function __construct(
        private readonly Collection $reposToCreate = new Collection,
        private ?GitHubException $failureException = null,
    ) {}

    public function getRepos(?int $perPage = null): RepoCollection
    {
        return RepoCollection::make([
            $this->fakeRepo(),
            $this->fakeRepo(),
        ]);
    }

    public function getRepo(string $owner, string $repoName): RepoData
    {
        throw new NotImplementedException;
    }

    public function getRepoLanguages(string $owner, string $repoName): array
    {
        throw new NotImplementedException;
    }

    public function createRepo(CreateRepoData $data): RepoData
    {
        if ($this->failureException !== null) {
            throw $this->failureException;
        }

        $this->reposToCreate->push($data);

        return $this->fakeRepo('owner', $data->name);
    }

    public function updateRepo(string $owner, string $repoName, UpdateRepoData $data): RepoData
    {
        throw new NotImplementedException;
    }

    public function deleteRepo(string $owner, string $repoName): void
    {
        throw new NotImplementedException;
    }

    /**
     * @return Collection<int, CreateRepoData>
     */
    public function getReposToCreate(): Collection
    {
        return $this->reposToCreate;
    }

    public function shouldFailWithException(GitHubException $exception): self
    {
        $this->failureException = $exception;

        return $this;
    }

    private function fakeRepo(?string $owner = null, ?string $name = null): RepoData
    {
        $owner ??= fake()->word;
        $name ??= fake()->word;

        return new RepoData(
            id: fake()->randomNumber(),
            owner: $owner,
            name: $name,
            fullName: $owner . '/' . $name,
            private: fake()->boolean(),
            description: fake()->sentence,
            createdAt: now(),
        );
    }
}
