<?php

declare(strict_types=1);

namespace App\Console\Commands\GitHub;

use App\Http\Integrations\GitHub\GitHubConnector;
use App\Http\Integrations\GitHub\Requests\GetRepo;
use Illuminate\Console\Command;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Collection;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Response;

final class SendMultipleRequestsCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'github:send-multiple-requests';

    /**
     * @var string
     */
    protected $description = 'Send multiple requests';

    private readonly string $token;

    public function __construct()
    {
        parent::__construct();

        $this->token = \config('services.github.token');
    }

    public function handle(): void
    {
        $this->info('Sending requests...');

        $result = Benchmark::measure([
            function (): void {
                $this->sendSequentialRequests();
            },
            function (): void {
                $this->sendConcurrentRequests();
            },
        ]);

        $this->info('Done!');
        $this->info('Sequential: ' . $this->formatTime($result[0]));
        $this->info('Concurrent: ' . $this->formatTime($result[1]));
    }

    /**
     * @throws \Saloon\Exceptions\Request\FatalRequestException
     * @throws \Saloon\Exceptions\Request\RequestException
     */
    private function sendSequentialRequests(): void
    {
        $connector = new GitHubConnector($this->token);

        $this->requests()->each(function (GetRepo $request) use ($connector): void {
            $connector->send($request);
        });
    }

    /**
     * @throws \Saloon\Exceptions\InvalidPoolItemException
     */
    private function sendConcurrentRequests(): void
    {
        (new GitHubConnector($this->token))
            ->pool($this->requests())
            ->setConcurrency(10)
            ->withResponseHandler(function (Response $response): void {
                $this->warn('Handling response!');
            })
            ->withExceptionHandler(function (FatalRequestException|RequestException $e): void {
                $this->error('Handling exception!');
            })
            ->send()
            ->wait();
    }

    /**
     * @return \Illuminate\Support\Collection<int, GetRepo>
     */
    private function requests(): Collection
    {
        return collect([
            new GetRepo('laravel', 'framework'),
            new GetRepo('laravel', 'laravel'),
            new GetRepo('laravel', 'telescope'),
            new GetRepo('ash-jc-allen', 'short-url'),
            new GetRepo('saloonphp', 'saloon'),
            new GetRepo('saloonphp', 'laravel-plugin'),
        ]);
    }

    private function formatTime(float $time): string
    {
        return \round($time / 1000, 2) . 'ms';
    }
}
