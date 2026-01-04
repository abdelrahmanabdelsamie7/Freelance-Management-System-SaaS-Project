<?php

namespace App\Traits;
use Illuminate\Database\Eloquent\Builder;

trait ProjectScopes
{
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }
    public function scopeByPriority(Builder $query, string $priority): Builder
    {
        return $query->where('priority', $priority);
    }
    public function scopeSearch(Builder $query, string $term): Builder
    {
        return $query->where('title', 'LIKE', "%{$term}%")
            ->orWhere('description', 'LIKE', "%{$term}%");
    }
}
