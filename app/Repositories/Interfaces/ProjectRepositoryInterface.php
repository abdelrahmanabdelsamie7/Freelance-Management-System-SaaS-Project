<?php

namespace App\Repositories\Interfaces;

use App\Models\Project;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProjectRepositoryInterface
{
    public function all(array $filters = [], int $perPage = 15): LengthAwarePaginator;
    public function find(int $id): ?Project;
    public function create(array $data): Project;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function search(string $term, array $filters = []): LengthAwarePaginator;
}
