<?php

namespace App\Traits;
use Illuminate\Database\Eloquent\Builder;

trait TaskScopes
{
    /**
     * Scope active tasks
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'todo');
    }

    /**
     * Scope tasks by project
     */
    public function scopeByProject(Builder $query, int $projectId): Builder
    {
        return $query->where('project_id', $projectId);
    }

    /**
     * Scope tasks by user assignment
     */
    public function scopeByUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope search by title or description
     */
    public function scopeSearch(Builder $query, string $term): Builder
    {
        return $query->where(function($q) use ($term){
            $q->where('title', 'LIKE', "%{$term}%")
                ->orWhere('description', 'LIKE', "%{$term}%");
        });
    }
}