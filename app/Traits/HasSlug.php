<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(function (Model $model) {
            $model->generateSlugOnCreate();
        });

        static::updating(function (Model $model) {
            $model->generateSlugOnUpdate();
        });
    }

    protected function generateSlugOnCreate(): void
    {
        $slugColumn = $this->getSlugColumn();
        $sourceColumn = $this->getSlugSourceColumn();

        if (empty($this->{$slugColumn}) && !empty($this->{$sourceColumn})) {
            $this->{$slugColumn} = $this->createUniqueSlug($this->{$sourceColumn});
        }
    }

    protected function generateSlugOnUpdate(): void
    {
        $slugColumn = $this->getSlugColumn();
        $sourceColumn = $this->getSlugSourceColumn();

        if ($this->isDirty($sourceColumn) && !empty($this->{$sourceColumn})) {
            $this->{$slugColumn} = $this->createUniqueSlug($this->{$sourceColumn});
        }
    }

    protected function createUniqueSlug(string $value): string
    {
        $slug = Str::slug($value);
        $originalSlug = $slug;
        $counter = 1;

        while ($this->slugExists($slug)) {
            $slug = $originalSlug . '-' . $counter++;
        }

        return $slug;
    }

    protected function slugExists(string $slug): bool
    {
        $query = static::where($this->getSlugColumn(), $slug);

        if ($this->exists) {
            $query->where($this->getKeyName(), '!=', $this->getKey());
        }

        return $query->exists();
    }

    protected function getSlugColumn(): string
    {
        return 'slug';
    }

    protected function getSlugSourceColumn(): string
    {
        return 'title';
    }

    public function scopeFindBySlug($query, string $slug): mixed
    {
        return $query->where($this->getSlugColumn(), $slug)->firstOrFail();
    }

    public function getRouteKeyName(): string
    {
        return $this->getSlugColumn();
    }
}
