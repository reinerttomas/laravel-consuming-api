<?php

declare(strict_types=1);

namespace App\Http\Requests\GitHub;

use App\DataTransferObjects\GitHub\CreateRepoData;
use Illuminate\Foundation\Http\FormRequest;

final class StoreRepoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'isPrivate' => ['required', 'bool'],
        ];
    }

    public function toDto(): CreateRepoData
    {
        return new CreateRepoData(...$this->validated());
    }
}
