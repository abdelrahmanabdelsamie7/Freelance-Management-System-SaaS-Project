<?php

namespace App\Http\Controllers\API\V1;

use App\Traits\ResponseJsonTrait;
use App\Http\Requests\Project\{StoreProjectRequest, UpdateProjectRequest};
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
class ProjectController extends Controller
{
    use ResponseJsonTrait;

    public function __construct(private ProjectService $projectService) {}

    public function index(Request $request)
    {
        try {
            $filters = $request->only(['status', 'priority']);
            $perPage = $request->get('per_page', 15);
            $projects = $this->projectService->getAllProjects($filters, $perPage);
            return $this->paginated($projects, [
                'filters_applied' => array_keys($filters)
            ]);
        } catch (\Exception $e) {
            return $this->error('Failed to fetch projects', $e->getMessage());
        }
    }
    
    public function store(StoreProjectRequest $request)
    {
        try {
            $project = $this->projectService->createProject($request->validated());
            return $this->success($project, 'Project created successfully', 201);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function show(int $id)
    {
        try {
            $project = $this->projectService->getProject($id);
            if (!$project) {
                return $this->error('Project not found', null, 404);
            }
            return $this->success($project);
        } catch (\Exception $e) {
            return $this->error('Failed to fetch project', $e->getMessage());
        }
    }

    public function update(UpdateProjectRequest $request, int $id)
    {
        try {
            $updated = $this->projectService->updateProject($id, $request->validated());
            if (!$updated) {
                return $this->error('Project not found', null, 404);
            }
            $project = $this->projectService->getProject($id);
            return $this->success($project, 'Project updated successfully');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function destroy(int $id)
    {
        try {
            $project = $this->projectService->getProject($id);
            if (!$project) {
                return $this->error('Project not found', null, 404);
            }
            $deleted = $this->projectService->deleteProject($id);
            if (!$deleted) {
                return $this->error('Failed to delete project');
            }
            return $this->success(null, 'Project deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete project');
        }
    }

    public function search(Request $request)
    {
        try {
            $term = $request->get('q');
            if (empty($term)) {
                return $this->error('Search term is required');
            }
            $filters = $request->only(['status', 'priority']);
            $results = $this->projectService->searchProjects($term, $filters);
            return $this->paginated($results, [
                'search_term' => $term,
                'filters_applied' => array_keys($filters)
            ]);
        } catch (\Exception $e) {
            return $this->error('Search failed');
        }
    }
}