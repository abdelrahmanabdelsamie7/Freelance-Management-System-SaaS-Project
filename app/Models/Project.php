<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\{ProjectScopes, HasSlug};

class Project extends Model
{
    use SoftDeletes, ProjectScopes,  HasSlug;
    protected $fillable = [
        'title',
        'slug',
        'description',
        'status',
        'priority',
        'created_by',
        'start_date',
        'deadline',
        'budget',
        'currency',
    ];
    protected $casts = [
        'start_date' => 'date',
        'deadline' => 'date',
        'budget' => 'decimal:2',
    ];
    //
}