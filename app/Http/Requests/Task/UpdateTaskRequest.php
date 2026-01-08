<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'status' => ['sometimes', 'in:todo,in_progress,done'],
            'due_date' => ['sometimes', 'date'],
            'contribution_percentage' => ['sometimes', 'integer', 'between:1,100'],
        ];
    }
}
