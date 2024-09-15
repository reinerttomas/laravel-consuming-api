<?php

declare(strict_types=1);

use App\DataTransferObjects\GitHub\CreateRepoData;
use App\DataTransferObjects\GitHub\RepoData;
use App\Http\Integrations\GitHub\Requests\CreateRepo;
use App\Services\GitHub\GitHubService;
use Carbon\CarbonInterface;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockResponse;

use function Pest\Faker\fake;

it('can create repo in github', function (array $data) {
    // Arrange
    Saloon::fake([
        'user/repos' => MockResponse::make($data),
    ]);

    $repoData = new CreateRepoData(
        name: $data['name'],
        description: $data['description'],
        isPrivate: $data['private'],
    );

    // Act
    $repo = (new GitHubService('token'))->createRepo($repoData);

    // Assert the correct repo data was returned.
    expect($repo)
        ->toBeInstanceOf(RepoData::class)
        ->id->toBe($data['id'])
        ->name->toBe($data['name'])
        ->owner->toBe($data['owner']['login'])
        ->fullName->toBe($data['full_name'])
        ->description->toBe($data['description'])
        ->private->toBe($data['private'])
        ->createdAt->toBeInstanceOf(CarbonInterface::class);

    // Assert the correct request was sent to the GitHub API.
    Saloon::assertSent(static fn (CreateRepo $request): bool => $request->resolveEndpoint() === '/user/repos'
        && $request->getMethod() === Method::POST && $request->body()->all() === [
            'name' => $data['name'],
            'description' => $data['description'],
            'private' => $data['private'],
        ],
    );
})->with([
    fn (): array => [
        'id' => fake()->randomNumber(),
        'name' => fake()->slug(),
        'owner' => [
            'login' => fake()->name(),
        ],
        'full_name' => fake()->name() . '/' . fake()->slug(),
        'description' => fake()->sentence(),
        'private' => fake()->boolean(),
        'created_at' => fake()->iso8601(),
    ],
]);
