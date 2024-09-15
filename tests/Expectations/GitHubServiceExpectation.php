<?php

declare(strict_types=1);

namespace Tests\Expectations;

use App\Services\GitHub\GitHubServiceFake;
use Closure;

/**
 * @mixin \Pest\Expectation
 */
final class GitHubServiceExpectation
{
    public static function register(): void
    {
        expect()->extend('toHaveCreatedRepo', self::toHaveCreatedRepo());
        expect()->extend('toHaveEmptyCreatedRepo', self::toHaveEmptyCreatedRepo());
    }

    public static function toHaveCreatedRepo(): Closure
    {
        return function (Closure $callback) {
            $gitHubFake = $this->value;

            if (! $gitHubFake instanceof GitHubServiceFake) {
                throw new \InvalidArgumentException('The value must be an instance of ' . GitHubServiceFake::class);
            }

            $repoIsToBeCreated = $gitHubFake->getReposToCreate()
                ->where($callback)
                ->isNotEmpty();

            expect($repoIsToBeCreated)->toBeTrue('Repo was not created.');

            return $this;
        };
    }

    public static function toHaveEmptyCreatedRepo(): Closure
    {
        return function () {
            $gitHubFake = $this->value;

            if (! $gitHubFake instanceof GitHubServiceFake) {
                throw new \InvalidArgumentException('The value must be an instance of ' . GitHubServiceFake::class);
            }

            expect($gitHubFake->getReposToCreate())->toBeEmpty('Repo was not created.');

            return $this;
        };
    }
}
