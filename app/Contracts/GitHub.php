<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Collections\GitHub\RepoCollection;
use App\DataTransferObjects\GitHub\CreateRepoData;
use App\DataTransferObjects\GitHub\RepoData;
use App\DataTransferObjects\GitHub\UpdateRepoData;

interface GitHub
{
    public function getRepos(string $username): RepoCollection;

    public function getRepo(string $owner, string $repoName): RepoData;

    /**
     * @return list<string>
     */
    public function getRepoLanguages(string $owner, string $repoName): array;

    public function createRepo(CreateRepoData $data): RepoData;

    public function updateRepo(string $owner, string $repoName, UpdateRepoData $data): RepoData;

    public function deleteRepo(string $owner, string $repoName): void;
}
