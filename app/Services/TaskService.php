<?php

namespace App\Services;

use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TaskService
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository
    ){}

    public function getAllTasks(array $filters = [], int $perpage = 15){
        return $this->taskRepository->all($filters, $perpage);
    }   

    public function getTask($id){
        return $this->taskRepository->find($id);
    }

    public function createTask(array $data){
        return $this->taskRepository->create($data);
    }

    public function updateTask(int $id, array $data): bool
    {
        return $this->taskRepository->update($id, $data);
    }

    public function deleteTask(int $id):bool
    {
        return $this->taskRepository->delete($id);
    }

    public function searchTask(string $term, array $filters = []): LengthAwarePaginator
    {
        return $this->taskRepository->search($term, $filters);
    }
}