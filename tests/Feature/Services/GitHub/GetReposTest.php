<?php

declare(strict_types=1);

use App\Http\Integrations\GitHub\Requests\GetAuthUserRepos;
use App\Services\GitHub\GitHubService;
use Saloon\Http\Faking\MockResponse;

it('returns repos from paginated response', function (): void {
    // Arrange

    // Mock the responses for each page.
    Saloon::fake([
        MockResponse::fixture('GitHub/Repos/All/Page1'),
        MockResponse::fixture('GitHub/Repos/All/Page2'),
        MockResponse::fixture('GitHub/Repos/All/Page3'),
        MockResponse::fixture('GitHub/Repos/All/Page4'),
        MockResponse::fixture('GitHub/Repos/All/Page5'),
    ]);

    // Act
    $repos = (new GitHubService(config('services.github.token')))->getRepos(perPage: 10);

    // Assert
    expect($repos)->toHaveCount(41);

    // Assert that all 4 requests were made with the correct query parameters.
    foreach ([1, 2, 3, 4, 5] as $pageNumber) {
        Saloon::assertSent(static fn (GetAuthUserRepos $request): bool => $request->query()->all() === [
            'per_page' => 10,
            'page' => $pageNumber,
        ]);
    }

    exit();
})->skip('to may responses');
