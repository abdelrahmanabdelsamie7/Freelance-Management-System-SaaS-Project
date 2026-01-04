<?php

namespace App\Services;

use App\Repositories\Interfaces\ProjectRepositoryInterface;

class ProjectService
{
    public function __construct(
        private ProjectRepositoryInterface $projectRepo
    ) {}

    public function getAllProjects(array $filters = [], int $perPage = 15)
    {
        return $this->projectRepo->all($filters, $perPage);
    }

    public function getProject(int $id)
    {
        return $this->projectRepo->find($id);
    }

    public function createProject(array $data)
    {
        if (isset($data['deadline']) && now()->greaterThan($data['deadline'])) {
            throw new \Exception('Deadline cannot be in the past');
        }
        return $this->projectRepo->create($data);
    }

    public function updateProject(int $id, array $data): bool
    {
        $project = $this->projectRepo->find($id);
        if (!$project) {
            throw new \Exception('Project not found');
        }

        return $this->projectRepo->update($id, $data);
    }

    public function deleteProject(int $id): bool
    {
        return $this->projectRepo->delete($id);
    }

    public function searchProjects(string $term, array $filters = [])
    {
        return $this->projectRepo->search($term, $filters);
    }
}
