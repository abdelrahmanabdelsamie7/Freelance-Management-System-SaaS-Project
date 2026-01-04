<?php
namespace App\Repositories;

use App\Models\Project;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function __construct(private Project $model) {}
    public function all(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->newQuery();
        foreach ($filters as $key => $value) {
            if (!empty($value)) {
                $query->where($key, $value);
            }
        }
        return $query->paginate($perPage);
    }

    public function find(int $id): ?Project
    {
        return $this->model->find($id);
    }

    public function create(array $data): Project
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $project = $this->find($id);
        return $project ? $project->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $project = $this->find($id);
        return $project ? $project->delete() : false;
    }

    public function search(string $term, array $filters = []): LengthAwarePaginator
    {
        $query = $this->model->search($term);
        foreach ($filters as $key => $value) {
            if (!empty($value)) {
                $query->where($key, $value);
            }
        }
        return $query->paginate(15);
    }
}