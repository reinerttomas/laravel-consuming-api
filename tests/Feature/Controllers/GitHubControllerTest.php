<?php

declare(strict_types=1);

use App\Collections\GitHub\RepoCollection;
use App\Contracts\GitHub;
use App\Services\GitHub\GitHubServiceFake;

use function Pest\Laravel\get;
use function Pest\Laravel\swap;

it('returns view with repositories', function () {
    // Arrange
    swap(GitHub::class, new GitHubServiceFake);

    // Act & Assert
    get(route('github.index'))
        ->assertOk()
        ->assertViewIs('repos.index')
        ->assertViewHas(
            'repos',
            fn (RepoCollection $repoCollection) => $repoCollection->count() === 2,
        );
});

it('returns view with empty repositories', function () {
    // Arrange

    // Act & Assert
})->todo();

it('returns api error', function () {
    // Arrange

    // Act & Assert
})->todo();

it('returns a rate limit error', function () {
    // Arrange

    // Act & Assert
})->todo();
