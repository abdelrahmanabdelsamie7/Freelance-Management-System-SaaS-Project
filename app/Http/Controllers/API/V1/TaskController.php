<?php

namespace App\Http\Controllers\API\V1;

use App\Traits\ResponseJsonTrait;
use App\Http\Requests\Task\{StoreTaskRequest, UpdateTaskRequest};
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
class TaskController extends Controller
{
    use ResponseJsonTrait;

    public function __construct(private TaskService $taskService){}

    // List tasks with filters & pagination
    public function index(Request $request){
        try{
            $filters = $request->only(['status', 'project_id', 'user_id']);
            $perpage = $request->get('per_page', 15);
            
            $tasks = $this->taskService->getAllTasks($filters, $perpage);

            return $this->paginated($tasks, [
                'filters_applied' => array_keys($filters)
            ]);
        }catch (\Exception $e) {
            return $this->error('Failed to fetch tasks', $e->getMessage());
        }
    }

    // Create a task
    public function store(StoreTaskRequest $request){
        try{
            $task = $this->taskServirce->createTask($request->validated());

            return $this->success($task, 'Task created successfully', 201);
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    // Show a task
    public function show(int $id){
        try{
            $task = $this->taskServirce->getTask($id);
            if(!$task){
                return $this->error('Task not found', null, 404);
            }
            return $this->success($task);
        }catch(\Exception $e){
            return $this->error('Failed to fetch task', $e->getMessage());
        }
    }

    // Update a task
    public function update(UpdateTaskRequest $request, int $id)
    {
        try{
            $updated = $this->taskServirce->updateTask($id, $request->validated());

            if(!$updated){
                return $this->error('Task not found', null, 404);
            }

            $task = $this->taskServirce->getTask($id);
            return $this->success($task, 'Task updated successfully');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    // Delete a task (soft delete)
    public function destroy(int $id){
        try{
            $task = $this->taskServirce->getTask($id);
            if(!$task){
                return $this->error('Task not found', null, 404);
            }

            $deleted = $this->taskServirce->deleteTask($id);
            if(!$deleted){
                return $this->error('Failed to delete task');
            }

            return $this->success(null, 'Task deleted successfully');
        }catch(\Exception $e){
            return $this->error('Failed to delete task');
        }
    }

    // Search tasks
    public function search(Request $request){
        try{
            $term = $request->get('q');
            if(empty($term)){
                return $this->error('Search term required');
            }

            $filters = $request->only(['status', 'project_id', 'user_id']);
            $result = $this->taskServirce->searchTask($term, $filters);

            return $this->paginated($result, [
                'search_term' => $term,
                'filters_applied' => array_keys($filters)
            ]);
        }catch(\Exception $e){
            return $this->error('Search failed');
        }
    }
}