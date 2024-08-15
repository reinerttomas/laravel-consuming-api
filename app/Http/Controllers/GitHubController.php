<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\GitHub;
use Illuminate\View\View;

final class GitHubController extends Controller
{
    public function show(string $owner, string $name, GitHub $gitHub): View
    {
        $repo = $gitHub->getRepo(
            owner: $owner,
            repoName: $name,
        );

        return view('repos.show')->with([
            'repo' => $repo,
        ]);
    }
}