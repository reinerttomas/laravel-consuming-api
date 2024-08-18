<?php

declare(strict_types=1);

namespace App\Console\Commands\GitHub;

use App\Contracts\GitHub;
use App\DataTransferObjects\GitHub\UpdateRepoData;
use Illuminate\Console\Command;

final class UpdateRepoCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'github:update-repo';

    /**
     * @var string
     */
    protected $description = 'Update github repository';

    public function __construct(
        private readonly GitHub $gitHub,
    ) {
        parent::__construct();
    }

    public function handle(): void
    {
        $repoData = $this->gitHub->updateRepo(
            $this->ask('Repository owner'),
            $this->ask('Repository name'),
            new UpdateRepoData(
                name: $this->ask('Repository new name'),
                description: $this->ask('Repository new description'),
                isPrivate: $this->confirm('Private repository?'),
            )
        );

        $this->info('Success! Repository ' . $repoData->fullName . ' updated.');
    }
}
