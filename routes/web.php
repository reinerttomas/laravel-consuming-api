<?php

declare(strict_types=1);

use App\Http\Controllers\GitHubController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'));
Route::get('/repos', [GitHubController::class, 'index'])->name('github.index');
Route::get('/repos/{owner}/{name}', [GitHubController::class, 'show'])->name('github.show');
