<?php

declare(strict_types=1);

namespace App\Console\Commands\GitHub;

use App\Contracts\GitHub;
use Illuminate\Console\Command;

final class DeleteRepoCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'github:delete-repo';

    /**
     * @var string
     */
    protected $description = 'Delete github repository';

    public function __construct(
        private readonly GitHub $gitHub,
    ) {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->gitHub->deleteRepo(
            owner: $this->ask('Repository owner'),
            repoName: $this->ask('Repository name'),
        );

        $this->info('Success! Repository was deleted.');
    }
}
