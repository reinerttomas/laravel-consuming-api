<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Collections\GitHub\RepoCollection;
use App\DataTransferObjects\GitHub\CreateRepoData;
use App\DataTransferObjects\GitHub\RepoData;
use App\DataTransferObjects\GitHub\UpdateRepoData;

interface GitHub
{
    public function getRepos(?int $perPage = null): RepoCollection;

    public function getRepo(string $owner, string $repoName): RepoData;

    /**
     * @return list<string>
     */
    public function getRepoLanguages(string $owner, string $repoName): array;

    /**
     * @throws \App\Exceptions\Integrations\GitHub\GitHubException
     */
    public function createRepo(CreateRepoData $data): RepoData;

    public function updateRepo(string $owner, string $repoName, UpdateRepoData $data): RepoData;

    /**
     * @throws \App\Exceptions\Integrations\GitHub\NotFoundException
     * @throws \App\Exceptions\Integrations\GitHub\UnauthorizedException
     */
    public function deleteRepo(string $owner, string $repoName): void;
}
