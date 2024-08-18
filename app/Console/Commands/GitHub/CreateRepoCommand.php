<?php

declare(strict_types=1);

namespace App\Console\Commands\GitHub;

use App\Contracts\GitHub;
use App\DataTransferObjects\GitHub\CreateRepoData;
use Illuminate\Console\Command;

final class CreateRepoCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'github:create-repo';

    /**
     * @var string
     */
    protected $description = 'Create github repository';

    public function __construct(
        private readonly GitHub $gitHub,
    ) {
        parent::__construct();
    }

    public function handle(): void
    {
        $repoData = $this->gitHub->createRepo(
            new CreateRepoData(
                name: $this->ask('Repository name'),
                description: $this->ask('Repository description'),
                isPrivate: $this->confirm('Private repository?'),
            )
        );

        $this->info('Success! Repository ' . $repoData->fullName . ' created.');
    }
}
