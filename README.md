# Laravel Consuming API

This project shows how to consume external APIs in [Laravel](#https://laravel.com/). It implements practical examples and uses [Saloon](#https://docs.saloon.dev/) to make HTTP requests to the GitHub API. 

## Features

* ✅ Laravel 11
* ✅ Saloon 3
* ✅ PHPStan
* ✅ Laravel Pint (PHP Coding Standards Fixer)
* ✅ Pest (testing)

## Installation

Install dependencies using Composer

```
composer install
```

Create your .env file from example

```
cp .env.example .env
```

## Configuration

Configure the GitHub API token in the .env file

```
GITHUB_TOKEN=xxx
```

## Integration GitHub API with Saloon

### Building the Interface

There is **GitHub** interface in an `app/Contracts` directory. This interface will define the methods that we want our integration service class to have.

It looks like this:

```php
namespace App\Contracts;

use App\Collections\GitHub\RepoCollection;
use App\DataTransferObjects\GitHub\CreateRepoData;
use App\DataTransferObjects\GitHub\RepoData;
use App\DataTransferObjects\GitHub\UpdateRepoData;

interface GitHub
{
    public function getRepos(?int $perPage = null): RepoCollection;

    public function getRepo(string $owner, string $repoName): RepoData;

    /**
     * @return list<string>
     */
    public function getRepoLanguages(string $owner, string $repoName): array;

    /**
     * @throws \App\Exceptions\Integrations\GitHub\GitHubException
     */
    public function createRepo(CreateRepoData $data): RepoData;

    public function updateRepo(string $owner, string $repoName, UpdateRepoData $data): RepoData;

    /**
     * @throws \App\Exceptions\Integrations\GitHub\NotFoundException
     * @throws \App\Exceptions\Integrations\GitHub\UnauthorizedException
     */
    public function deleteRepo(string $owner, string $repoName): void;
}
```

Note that we use DTOs classes to better describe the data structure.

### Creating the Integration Service Class

**GitHubService** is a class that implements the **GitHub** interface and uses **Saloon** to send HTTP requests.

### Saloon

Thanks to the Saloon implementation we can use the functions:

- Authentication
- Sending requests
  - Fetching a single resource
  - Fetching a list of resources
  - Creating a new resource
  - Updating an existing resource
  - Deleting an existing resource
- Pagination
- Sending concurrent requests
- Middleware
- Plugins
- Error handling
- Retry requests
- Handling API rate limits
- Caching responses
- Testing API integrations
