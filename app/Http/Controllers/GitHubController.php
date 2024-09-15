<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\GitHub;
use App\Exceptions\Integrations\GitHub\GitHubException;
use App\Exceptions\Integrations\GitHub\NotFoundException;
use App\Exceptions\Integrations\GitHub\UnauthorizedException;
use App\Http\Requests\GitHub\StoreRepoRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Saloon\RateLimitPlugin\Exceptions\RateLimitReachedException;

final class GitHubController extends Controller
{
    public function index(GitHub $gitHub): View
    {
        return view('repos.index')->with([
            'repos' => $gitHub->getRepos(),
        ]);
    }

    public function show(string $owner, string $name, GitHub $gitHub): RedirectResponse|View
    {

        try {
            $repo = $gitHub->getRepo(
                owner: $owner,
                repoName: $name,
            );
            $languages = $gitHub->getRepoLanguages(
                owner: $owner,
                repoName: $name,
            );
        } catch (RateLimitReachedException $e) {
            $seconds = $e->getLimit()->getRemainingSeconds();

            return redirect(route('dashboard'))
                ->with(
                    'error',
                    'Rate limit exceeded. Please try again in ' . $seconds . ' seconds.',
                );
        }

        return view('repos.show')->with([
            'repo' => $repo,
            'languages' => $languages,
        ]);
    }

    public function store(StoreRepoRequest $request, GitHub $gitHub): RedirectResponse
    {
        try {
            $repo = $gitHub->createRepo($request->toDto());
        } catch (GitHubException $e) {
            return \redirect()
                ->route('github.repos.store')
                ->with('error', $e->getMessage());
        }

        return redirect()
            ->route('github.repos.show', [
                $repo->owner,
                $repo->name,
            ])
            ->with('success', 'Repo created successfully');
    }

    public function destroy(
        string $owner,
        string $name,
        GitHub $gitHub
    ): RedirectResponse {
        try {
            $gitHub->deleteRepo(
                owner: $owner,
                repoName: $name,
            );
        } catch (UnauthorizedException) {
            return redirect()
                ->route('github.repos.show', [$owner, $name])
                ->with('error', 'You do not have permission to delete this repo.');
        } catch (NotFoundException) {
            return redirect()
                ->route('github.repos.show', [$owner, $name])
                ->with('error', 'The repo does not exist.');
        }

        return redirect()
            ->route('github.repos.index')
            ->with('success', 'Repo deleted successfully');
    }
}
