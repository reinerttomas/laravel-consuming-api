<?php

declare(strict_types=1);

namespace App\Services\GitHub;

use App\Collections\GitHub\RepoCollection;
use App\Contracts\GitHub;
use App\DataTransferObjects\GitHub\CreateRepoData;
use App\DataTransferObjects\GitHub\RepoData;
use App\DataTransferObjects\GitHub\UpdateRepoData;
use App\Exceptions\NotImplementedException;
use Faker\Generator;

final readonly class GitHubServiceFake implements GitHub
{
    public function getRepos(): RepoCollection
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
        throw new NotImplementedException;
    }

    public function updateRepo(string $owner, string $repoName, UpdateRepoData $data): RepoData
    {
        throw new NotImplementedException;
    }

    public function deleteRepo(string $owner, string $repoName): void
    {
        throw new NotImplementedException;
    }

    private function fakeRepo(?string $owner = null, ?string $name = null): RepoData
    {
        $faker = app(Generator::class);
        $owner ??= $faker->word;
        $name ??= $faker->word;

        return new RepoData(
            id: $faker->randomNumber(),
            owner: $owner,
            name: $name,
            fullName: $owner . '/' . $name,
            private: $faker->boolean(),
            description: $faker->sentence,
            createdAt: now(),
        );
    }
}
