<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\TaskScopes;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes, TaskScopes;

    protected $fillable = [
        'project_id',
        'user_id',
        'title',
        'description',
        'status',
        'due_date',
        'contribution_percentage'
    ];

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
