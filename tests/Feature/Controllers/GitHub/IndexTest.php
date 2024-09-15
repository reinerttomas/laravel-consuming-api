<?php

declare(strict_types=1);

use App\Collections\GitHub\RepoCollection;

use function Pest\Laravel\get;

it('returns view with repositories', function () {
    // Arrange
    fakeGitHub();

    // Act & Assert
    get(route('github.repos.index'))
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
