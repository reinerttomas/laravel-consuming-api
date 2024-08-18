<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\GitHub;
use Illuminate\View\View;

final class GitHubController extends Controller
{
    public function index(GitHub $gitHub): View
    {
        return view('repos.index')->with([
            'repos' => $gitHub->getRepos(),
        ]);
    }

    public function show(string $owner, string $name, GitHub $gitHub): View
    {
        $repo = $gitHub->getRepo(
            owner: $owner,
            repoName: $name,
        );

        $languages = $gitHub->getRepoLanguages(
            owner: $owner,
            repoName: $name,
        );

        return view('repos.show')->with([
            'repo' => $repo,
            'languages' => $languages,
        ]);
    }
}
