<?php
namespace App\Repositories;

use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TaskRepository implements TaskRepositoryInterface
{
    public function __construct(private Task $model) {}

    public function all(array $filters = [], int $perpage = 15): LengthAwarePaginator {
        return Task::query()
            ->when(isset($filters['project_id']), fn($q) => 
                $q->where('project_id', $filters['project_id'])
            )
            ->when(isset($filters['user_id']), fn($q) => 
                $q->where('user_id', $filters['user_id'])
            )
            ->paginate($perpage);
    }

    public function find(int $id):? Task
    {
        return Task::find($id);
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $task = Task::find($id);
        return $task ? $task->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $task = Task::find($id);
        return $task ? $task->delete() : false;
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

    public function restore(int $id): bool
    {
        $task = Task::withTrashed()->findOrFail($id);
        return $task->restore();
    }
}