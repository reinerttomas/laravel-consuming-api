<?php

declare(strict_types=1);

use App\DataTransferObjects\GitHub\CreateRepoData;
use App\Exceptions\Integrations\GitHub\GitHubException;

use function Pest\Laravel\post;

it('can create repo', function (array $data) {
    // Arrange
    $gitHubFake = fakeGitHub();

    // Act & Assert
    expect(post('/repos', $data))
        ->assertRedirect(route('github.repos.show', ['owner', 'test-repo']))
        ->assertSessionHas('success', 'Repo created successfully');

    expect($gitHubFake)->toHaveCreatedRepo(
        fn (CreateRepoData $repo): bool => $repo->name === $data['name']
            && $repo->description === $data['description']
            && $repo->isPrivate === $data['isPrivate']
    );
})->with([
    'test-repo' => fn (): array => [
        'name' => 'test-repo',
        'description' => 'test-description',
        'isPrivate' => true,
    ],
]);

it('can redirect back if an error occurs', function (array $data) {
    // Arrange
    $gitHubFake = fakeGitHub()->shouldFailWithException(
        new GitHubException('Test error message')
    );

    // Act & Assert
    expect(post('/repos', $data))
        ->assertRedirect(route('github.repos.store'))
        ->assertSessionHas('error', 'Test error message');

    expect($gitHubFake)->toHaveEmptyCreatedRepo();
})->with([
    'test-repo' => fn (): array => [
        'name' => 'test-repo',
        'description' => 'test-description',
        'isPrivate' => true,
    ],
]);
